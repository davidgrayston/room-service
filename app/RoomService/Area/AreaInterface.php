<?php

namespace App\RoomService\Area;

interface AreaInterface
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
     * @return \App\RoomService\Area\Coordinates[]
     */
    public function getPatches();

    /**
     * Adds a dirt patch to the area.
     *
     * @param \App\RoomService\Area\Coordinates $coords
     */
    public function addPatch(Coordinates $coords);

    /**
     * Cleans patch at the specified coordinates.
     *
     * @param \App\RoomService\Area\Coordinates $coords
     */
    public function cleanPatch(Coordinates $coords);

    /**
     * Check if provided coordinates are valid for the area.
     *
     * @param \App\RoomService\Area\Coordinates $coords
     *
     * @return bool
     */
    public function validateCoordinates(Coordinates $coords);

    /**
     * Asserts the provided coordinates for this area are valid.
     *
     * @param \App\RoomService\Area\Coordinates $coords
     *
     * @throws \App\Exceptions\RoomServiceValidation
     */
    public function assertValidCoordinates(Coordinates $coords);
}
