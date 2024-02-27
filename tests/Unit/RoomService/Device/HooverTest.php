<?php

namespace Tests\Unit\Roomservice\Device;

use App\RoomService\Area\Area;
use App\RoomService\Area\Coordinates;
use App\RoomService\Device\Hoover;
use LogicException;
use Tests\TestCase;

/**
 * Class HooverTest
 *
 * @package Tests\Unit\Roomservice\Device
 * @coversDefaultClass App\RoomService\Device\Hoover
 */
class HooverTest extends TestCase
{
    private Hoover $hoover;

    protected function setup(): void
    {
        $this->hoover = new Hoover();
    }

    /**
     * @covers ::operate
     */
    public function testOperate()
    {
        // Create area to be cleaned.
        $area = new Area([3, 3]);
        $area->setPatches([
            [1, 1],
            [2, 2],
        ]);

        // Create hoover to clean the area.
        $hoover = new Hoover();
        $hoover
            ->setArea($area)
            ->setPosition([0, 0])
            ->setInstructions('NENE')
            ->run();

        $this->assertEquals(2, $area->getPatchesCleaned());
    }

    /**
     * @covers ::setArea
     * @covers ::getArea
     */
    public function testSetArea()
    {
        $area = new Area([1, 2]);
        $this->hoover->setArea($area);
        $this->assertEquals($area, $this->hoover->getArea());
    }

    /**
     * @covers ::getArea
     */
    public function testGetAreaException()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Item does not have an area set.');
        $this->hoover->getArea();
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
        $this->hoover
            ->setArea(new Area($area_size))
            ->setPosition($position)
            ->setInstructions($instructions)
            ->run();
        $this->assertEquals(new Coordinates($final_position), $this->hoover->getPosition());
    }

    /**
     * Data provider for instructions test.
     */
    public static function setInstructionsProvider()
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
