<?php

namespace Tests;

use App\Creational\Builder\Car;
use App\Creational\Builder\CarBuilder;
use App\Creational\Builder\Director;
use App\Creational\Builder\Truck;
use App\Creational\Builder\TruckBuilder;
use PHPUnit\Framework\TestCase;

// require "app/Creational/Builder/Real/Real.php";

class BuilderTest extends TestCase
{
    public function testCanBuildTruck()
    {
        $truckBuilder = new TruckBuilder();
        $newVehicle = (new Director())->build($truckBuilder);
        
        $this->assertInstanceOf(Truck::class, $newVehicle);
    }

    public function testCanBuildCar()
    {
        $carBuilder = new CarBuilder();
        $newVehicle = (new Director())->build($carBuilder);

        $this->assertInstanceOf(Car::class, $newVehicle);
    }
}