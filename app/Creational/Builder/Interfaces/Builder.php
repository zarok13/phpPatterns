<?php

namespace App\Creational\Builder\Interfaces;

use App\Creational\Builder\Vehicle;

interface Builder
{
    public function createVehicle();

    public function addWheel();
    public function addEngine();
    public function addDoors();

    public function getVehicle(): Vehicle;
}