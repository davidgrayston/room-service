<?php

namespace App\RoomService\Device;

class Hoover extends AbstractMovable
{

    /**
     * @inheritdoc
     */
    protected function operate()
    {
        $this->getArea()->cleanPatch($this->getPosition());
    }
}
