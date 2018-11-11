<?php

namespace App\RoomService;

interface RoomInterface
{

    /**
     * Registers array of dirt patches.
     *
     * @param array $patch_coords
     */
    public function setPatches(array $patch_coords);

    /**
     * Return array of dirt patches.
     *
     * @return \App\RoomService\Coordinates[]
     */
    public function getPatches();

    /**
     * Adds a dirt patch to the room.
     *
     * @param \App\RoomService\Coordinates $coords
     */
    public function addPatch(Coordinates $coords);

    /**
     * Cleans patch at the specified coordinates.
     *
     * @param \App\RoomService\Coordinates $coords
     */
    public function cleanPatch(Coordinates $coords);

    /**
     * Check if provided coordinates are valid for the room.
     *
     * @param \App\RoomService\Coordinates $coords
     *
     * @return bool
     */
    public function validateCoordinates(Coordinates $coords);

    /**
     * Asserts the provided coordinates for this room are valid.
     *
     * @param \App\RoomService\Coordinates $coords
     *
     * @throws \App\Exceptions\RoomServiceValidation
     */
    public function assertValidCoordinates(Coordinates $coords);
}
