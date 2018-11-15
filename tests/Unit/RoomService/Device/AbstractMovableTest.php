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
     * @var \App\RoomService\Device\AbstractMovable
     */
    protected $movable;

    /**
     * Setup test objects.
     */
    public function setup() {
        $this->movable = $this->getMockForAbstractClass(AbstractMovable::class);
    }

    /**
     * @covers ::setArea
     * @covers ::getArea
     */
    public function testSetArea()
    {
        $area = new Area([1, 2]);
        $this->movable->setArea($area);
        $this->assertEquals($area, $this->movable->getArea());
    }

    /**
     * @covers ::getArea
     * @expectedException LogicException
     * @expectedExceptionMessage Item does not have an area set.
     */
    public function testGetAreaException()
    {
        $this->movable->getArea();
    }
}
