<?php

namespace App\RoomService\Device;

use App\RoomService\Area\AreaInterface;
use App\RoomService\Area\Coordinates;

abstract class AbstractMovable implements MovableInterface
{

    /**
     * @var array Instructions for the movable device.
     */
    protected $instructions = [];

    /**
     * @var AreaInterface
     */
    protected $area;

    /**
     * @var \App\RoomService\Area\Coordinates
     */
    protected $coords;

    /**
     * @inheritdoc
     */
    public function setInstructions(string $instructions)
    {
        foreach (str_split($instructions) as $instruction) {
            if (in_array($instruction, ['N', 'E', 'S', 'W'])) {
                $this->instructions[] = $instruction;
            }
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        foreach ($this->instructions as $instruction) {
            // Clone existing coordinates to be adjusted and checked.
            $new_coords = clone $this->coords;

            // Change coordinates according to instructions.
            switch ($instruction) {
                case 'N':
                    $new_coords->goNorth();
                    break;
                case 'E':
                    $new_coords->goEast();
                    break;
                case 'S':
                    $new_coords->goSouth();
                    break;
                case 'W':
                    $new_coords->goWest();
                    break;
            }

            // Check that the area coordinates are valid before moving hoover / cleaning.
            if ($this->getArea()->validateCoordinates($new_coords)) {
                $this->coords = $new_coords;
                $this->operate();
            }
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setArea(AreaInterface $area)
    {
        $this->area = $area;

        // Unset existing coordinates when the area changes.
        unset($this->coords);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getArea()
    {
        if (isset($this->area)) {
            return $this->area;
        }
        throw new \LogicException('Item does not have an area set.');
    }

    /**
     * @inheritdoc
     */
    public function setPosition(array $coords)
    {
        // Assert that the coordinates are valid for the the area.
        $new_coords = new Coordinates($coords);
        $this->getArea()->assertValidCoordinates($new_coords);

        // Set the coordinates.
        $this->coords = $new_coords;

        // Perform operations.
        $this->operate();

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPosition()
    {
        return $this->coords;
    }

    /**
     * Device classes should implement this method to perform operations when
     * it is moved.
     */
    abstract protected function operate();
}
