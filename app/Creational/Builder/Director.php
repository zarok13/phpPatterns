<?php

namespace App\Creational\Builder;

use App\Creational\Builder\Interfaces\Builder;
use App\Creational\Builder\Vehicle;

class Director
{
    public function build(Builder $builder): Vehicle
    {
        $builder->createVehicle();
        $builder->addDoors();
        $builder->addEngine();
        $builder->addWheel();

        return $builder->getVehicle();
    }
}