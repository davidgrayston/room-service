<?php

namespace Tests\Unit\Roomservice\Device;

use App\RoomService\Area\Area;
use App\RoomService\Device\Hoover;
use Tests\TestCase;

/**
 * Class HooverTest
 *
 * @package Tests\Unit\Roomservice\Device
 * @coversDefaultClass App\RoomService\Device\Hoover
 */
class HooverTest extends TestCase
{
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
}
