<?php

namespace App\RoomService\Device;

class Hoover extends AbstractMovable
{

    /**
     * @inheritdoc
     */
    protected function onMove()
    {
        $this->getArea()->cleanPatch($this->getPosition());
    }
}
