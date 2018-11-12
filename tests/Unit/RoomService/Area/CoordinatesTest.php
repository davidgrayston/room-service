<?php

namespace Tests\Unit\Roomservice\Area;

use Tests\TestCase;
use App\RoomService\Area\Coordinates;

/**
 * Class CoordinatesTest
 *
 * @package Tests\Unit\Roomservice\Area
 * @coversDefaultClass App\RoomService\Area\Coordinates
 */
class CoordinatesTest extends TestCase
{
    /**
     * @covers ::goNorth
     * @covers ::goEast
     * @covers ::goSouth
     * @covers ::goWest
     * @covers ::x
     * @covers ::y
     */
    public function testCoordinatesNavigate()
    {
        $coords = new Coordinates([1, 3]);

        $coords->goNorth();
        $this->assertEquals(1, $coords->x());
        $this->assertEquals(4, $coords->y());

        $coords->goEast();
        $this->assertEquals(2, $coords->x());
        $this->assertEquals(4, $coords->y());

        $coords->goSouth();
        $this->assertEquals(2, $coords->x());
        $this->assertEquals(3, $coords->y());

        $coords->goWest();
        $this->assertEquals(1, $coords->x());
        $this->assertEquals(3, $coords->y());
    }

    /**
     * @covers ::jsonSerialize
     */
    public function testCoordinatesJsonEncode()
    {
        $coords = new Coordinates([2, 4]);
        $this->assertEquals(json_encode($coords), '[2,4]');
    }

    /**
     * @covers ::__tostring()
     */
    public function testCoordinatesToString()
    {
        $coords = new Coordinates([2, 4]);
        $this->assertEquals($coords, '2,4');
        $this->assertSame((string) $coords, '2,4');
    }
}
