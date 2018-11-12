<?php

namespace Tests\Unit\Roomservice\Device;

use App\RoomService\Area\Area;
use App\RoomService\Device\AbstractMovable;
use Tests\TestCase;

/**
 * Class AbstractMovableTest
 *
 * @package Tests\Unit\Roomservice\Device
 * @coversDefaultClass App\RoomService\Device\AbstractMovable
 */
class AbstractMovableTest extends TestCase
{

    /**
     * @covers ::setArea
     * @covers ::getArea
     */
    public function testSetArea()
    {
        $movable = $this->getMockForAbstractClass(AbstractMovable::class);
        $area = new Area([1, 2]);
        $movable->setArea($area);
        $this->assertEquals($area, $movable->getArea());
    }

}
