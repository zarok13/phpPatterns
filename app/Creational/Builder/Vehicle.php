<?php

namespace App\Creational\Builder;

abstract class Vehicle
{
    private $data = [];

    public function setPart(string $key, object $value)
    {
        $this->data[$key] = $value;
    }
}