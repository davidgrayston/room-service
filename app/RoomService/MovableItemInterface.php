<?php

namespace App\RoomService;

interface MovableItemInterface
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
     * Sets the room that this movable item is in.
     *
     * @return $this
     */
    public function setRoom(RoomInterface $room);

    /**
     * Return room that this movable item is in.
     *
     * @return \App\RoomService\RoomInterface
     *
     * @throws \LogicException
     */
    public function getRoom();

    /**
     * Runs the instructions.
     *
     * @return $this
     */
    public function run();

    /**
     * Sets the position of the item within the room.
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
     * @return \App\RoomService\Coordinates
     */
    public function getPosition();
}
