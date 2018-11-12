<?php

namespace Tests\Unit\Roomservice\Area;

use App\RoomService\Area\Coordinates;
use Tests\TestCase;
use App\RoomService\Area\Area;

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
    public function testAreaPatches()
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

        $coord = new Coordinates([1, 2]);
        $area->cleanPatch($coord);
    }

    /**
     * @covers ::assertValidCoordinates
     * @expectedException \App\Exceptions\RoomServiceValidation
     * @expectedExceptionMessage Coordinates [5,2] are not valid for area [4,4]
     */
    public function testAreaCoordinateException()
    {
        $area = new Area([4, 4]);
        $area->assertValidCoordinates(new Coordinates([5, 2]));
    }

    /**
     * @covers ::cleanPatch
     */
    public function testAreaCleanPatch()
    {
        $area = new Area([4, 4]);
        $area->setPatches([
          [1, 2],
          [2, 3],
        ]);

        $area->cleanPatch(new Coordinates([1, 2]));

        $patches = $area->getPatches();
        $this->assertFalse(isset($patches['1,2']));
        $this->assertEquals(1, count($patches));
    }

}
