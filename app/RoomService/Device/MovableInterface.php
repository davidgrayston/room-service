<?php

namespace App\RoomService\Device;

use App\RoomService\Area\AreaInterface;

interface MovableInterface
{

    /**
     * Set instructions.
     *
     * @param string $instructions
     *   Directions that the object should take - allowed characters: NESW.
     *
     * @return $this
     */
    public function setInstructions(string $instructions);

    /**
     * Sets the area that this movable item is in.
     *
     * @return $this
     */
    public function setArea(AreaInterface $area);

    /**
     * Return area that this movable item is in.
     *
     * @return \App\RoomService\Area\AreaInterface
     *
     * @throws \LogicException
     */
    public function getArea();

    /**
     * Runs the instructions.
     *
     * @return $this
     */
    public function run();

    /**
     * Sets the position of the item within the area.
     *
     * @param array $coords
     *   The coordinates of the item.
     *
     * @return $this
     *
     * @throws \LogicException
     * @throws \App\Exceptions\RoomServiceValidation
     */
    public function setPosition(array $coords);

    /**
     * Returns the item coordinates.
     *
     * @return \App\RoomService\Area\Coordinates
     */
    public function getPosition();
}
