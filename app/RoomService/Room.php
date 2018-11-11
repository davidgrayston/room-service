<?php

namespace App\RoomService;

use App\Exceptions\RoomServiceValidation;

class Room implements RoomInterface
{

    /**
     * @var \App\RoomService\Coordinates
     */
    protected $size;

    /**
     * @var \App\RoomService\Coordinates[] registry of dirt patches.
     */
    protected $patches = [];

    /**
     * Room constructor.
     *
     * @param array $room_size
     */
    public function __construct(array $room_size)
    {
        $this->size = new Coordinates($room_size);
    }

    /**
     * @inheritdoc
     */
    public function setPatches(array $patch_coords)
    {
        foreach ($patch_coords as $coords) {
            $this->addPatch(new Coordinates($coords));
        }
    }

    /**
     * @inheritdoc
     */
    public function getPatches()
    {
        return $this->patches;
    }

    /**
     * @inheritdoc
     */
    public function addPatch(Coordinates $coords)
    {
        $this->assertValidCoordinates($coords);
        $this->patches[(string)$coords] = $coords;
    }

    /**
     * @inheritdoc
     */
    public function cleanPatch(Coordinates $coords)
    {
        $this->assertValidCoordinates($coords);
        unset($this->patches[(string)$coords]);
    }

    /**
     * @inheritDoc
     */
    public function validateCoordinates(Coordinates $coords)
    {
        // Check that the coordinates are within the bounds of the room.
        $valid = true;
        foreach (['x', 'y'] as $c) {
            if ($coords->{$c}() >= $this->size->{$c}() || $coords->{$c}() < 0) {
                $valid = false;
            }
        }
        return $valid;
    }

    /**
     * @inheritdoc
     */
    public function assertValidCoordinates(Coordinates $coords)
    {
        // Check that the coordinates are within the bounds of the room.
        if (!$this->validateCoordinates($coords)) {
            throw new RoomServiceValidation(sprintf('Coordinates [%s] are not valid for room [%s]',
              $coords,
              $this->size
            ));
        }
    }
}
