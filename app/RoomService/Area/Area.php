<?php

namespace App\RoomService\Area;

use App\Exceptions\RoomServiceValidation;

class Area implements AreaInterface
{

    /**
     * @var \App\RoomService\Area\Coordinates
     */
    protected $size;

    /**
     * @var \App\RoomService\Area\Coordinates[] registry of dirt patches.
     */
    protected $patches = [];

    /**
     * @var \int count of patches cleaned.
     */
    protected $patchesCleaned = 0;

    /**
     * Area constructor.
     *
     * @param array $size
     *
     * @throws \App\Exceptions\RoomServiceValidation
     */
    public function __construct(array $size)
    {
        $this->size = new Coordinates($size);
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
    public function getPatchesCleaned()
    {
        return $this->patchesCleaned;
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
        if (isset($this->patches[(string)$coords])) {
            $this->patchesCleaned++;
            unset($this->patches[(string)$coords]);
        }
    }

    /**
     * @inheritdoc
     */
    public function validateCoordinates(Coordinates $coords)
    {
        // Check that the coordinates are within the bounds of the area.
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
        // Check that the coordinates are within the bounds of the area.
        if (!$this->validateCoordinates($coords)) {
            throw new RoomServiceValidation(sprintf('Coordinates [%s] are not valid for area [%s]',
              $coords,
              $this->size
            ));
        }
    }
}
