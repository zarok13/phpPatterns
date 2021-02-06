<?php

namespace App\Creational\SimpleFactory;

class Bicycle
{
    public function driveTo(string $destination)
    {
        return $destination;
    }
}
