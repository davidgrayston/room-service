<?php

namespace Tests\Unit\Roomservice\Area;

use App\Exceptions\RoomServiceValidation;
use App\RoomService\Area\Coordinates;
use App\RoomService\Area\Area;
use Tests\TestCase;

/**
 * Class AreaTest
 *
 * @package Tests\Unit\Roomservice\Area
 * @coversDefaultClass App\RoomService\Area\Area
 */
class AreaTest extends TestCase
{
    /**
     * @covers ::getPatches
     * @covers ::setPatches
     */
    public function testSetPatches()
    {
        $area = new Area([4, 4]);
        $area->setPatches([
            [1, 2],
            [2, 3],
        ]);
        $patches = $area->getPatches();

        $this->assertEquals(1, $patches['1,2']->x());
        $this->assertEquals(2, $patches['1,2']->y());
        $this->assertEquals(2, $patches['2,3']->x());
        $this->assertEquals(3, $patches['2,3']->y());
    }

    /**
     * @covers ::assertValidCoordinates
     */
    public function testCoordinateException()
    {
        $this->expectException(RoomServiceValidation::class);
        $this->expectExceptionMessage('Coordinates [5,2] are not valid for area [4,4]');

        $area = new Area([4, 4]);
        $area->assertValidCoordinates(new Coordinates([5, 2]));
    }

    /**
     * @covers ::cleanPatch
     * @covers ::getPatchesCleaned
     */
    public function testCleanPatch()
    {
        $area = new Area([4, 4]);
        $area->setPatches([
            [1, 2],
            [2, 3],
        ]);

        foreach ($area->getPatches() as $patch) {
            $area->cleanPatch($patch);
        }

        $this->assertEquals(2, $area->getPatchesCleaned());
    }

}
