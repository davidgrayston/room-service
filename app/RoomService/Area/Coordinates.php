<?php

namespace App\RoomService\Area;

use App\Exceptions\RoomServiceValidation;

class Coordinates implements \JsonSerializable
{

    /**
     * @var array x/y coordinates.
     */
    protected $coords = [];

    /**
     * Coordinates constructor.
     *
     * @param array $coords
     *
     * @throws \App\Exceptions\RoomServiceValidation
     */
    public function __construct(array $coords)
    {
        $this->validateCoordinatesFormat($coords);
        $this->coords = array_map('intval', $coords);
    }

    /**
     * Validates the provided coordinates format.
     *
     * @param array $coords
     *
     * @throws \App\Exceptions\RoomServiceValidation
     */
    protected function validateCoordinatesFormat(array $coords)
    {
        // Check that the coordinate is an array with 2 integer values.
        $coords = array_filter($coords, 'is_int');
        if (count($coords) !== 2) {
            throw new RoomServiceValidation(sprintf(
              'Coordinate must be an array of 2 integer values, [%s] provided.',
              implode(',', $coords)
            ));
        }
    }

    /**
     * Converts the provided coords into a comma separated string.
     *
     * @return string
     */
    public function __toString()
    {
        return implode(',', $this->coords);
    }

    /**
     * @return int
     */
    public function x()
    {
        return (int)$this->coords[0];
    }

    /**
     * @return int
     */
    public function y()
    {
        return (int)$this->coords[1];
    }

    /**
     * Go north.
     */
    public function goNorth()
    {
        // Increase y coordinate by 1
        $this->coords[1]++;
    }

    /**
     * Go east.
     */
    public function goEast()
    {
        // Increase x coordinate by 1
        $this->coords[0]++;
    }

    /**
     * Go south.
     */
    public function goSouth()
    {
        // Decrease y coordinate by 1.
        $this->coords[1]--;
    }

    /**
     * Go west.
     */
    public function goWest()
    {
        // Decrease x coordinate by 1
        $this->coords[0]--;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return $this->coords;
    }
}
