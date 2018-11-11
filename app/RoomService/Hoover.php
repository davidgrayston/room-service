<?php

namespace App\RoomService;

class Hoover implements MovableItemInterface
{
    /**
     * @var array
     */
    protected $instructions = [];

    /**
     * @var RoomInterface
     */
    protected $room;

    /**
     * @var \App\RoomService\Coordinates
     */
    protected $coords;

    /**
     * @inheritDoc
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
     * @inheritDoc
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

            // Check that the room coordinates are valid before moving hoover / cleaning.
            if ($this->room->validateCoordinates($new_coords)) {
                $this->coords = $new_coords;
                $this->room->cleanPatch($this->coords);
            }
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setRoom(RoomInterface $room)
    {
        $this->room = $room;

        // Unset existing coordinates when the room changes.
        unset($this->coords);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRoom()
    {
        if (isset($this->room)) {
            return $this->room;
        }
        throw new \LogicException('Item does not have a room set.');
    }

    /**
     * @inheritDoc
     */
    public function setPosition(array $coords)
    {
        // Assert that the coordinates are valid for the the room.
        $new_coords = new Coordinates($coords);
        $this->getRoom()->assertValidCoordinates($new_coords);

        // Set the coordinates.
        $this->coords = $new_coords;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPosition()
    {
        return $this->coords;
    }
}
