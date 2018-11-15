<?php

namespace Tests\Unit\Roomservice\Device;

use App\RoomService\Area\Area;
use App\RoomService\Area\Coordinates;
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
    public function setup()
    {
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

    /**
     * @covers ::setInstructions
     * @covers ::getPosition
     * @covers ::getPosition
     * @covers ::run
     * @dataProvider setInstructionsProvider
     */
    public function testSetInstructions($area_size, $position, $instructions, $final_position, $operation_count)
    {
        $this->movable->expects($this->exactly($operation_count))
            ->method('operate');

        $this->movable
            ->setArea(new Area($area_size))
            ->setPosition($position)
            ->setInstructions($instructions)
            ->run();
        $this->assertEquals(new Coordinates($final_position), $this->movable->getPosition());
    }

    /**
     * Data provider for instructions test.
     */
    public function setInstructionsProvider()
    {
        return [
            [
                [2, 2],
                [0, 0],
                'NESW',
                [0, 0],
                5,
            ],
            [
                [10, 10],
                [0, 0],
                'NENENENENESESE',
                [7, 3],
                15,
            ],
            [
                [20, 20],
                [5, 5],
                'NNNNNNNNNNNNNNNEEEEE',
                [10, 19],
                20
            ]
        ];
    }
}
