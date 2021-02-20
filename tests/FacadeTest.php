<?php

namespace Tests;

use App\Structural\Facade\Bios;
use App\Structural\Facade\Facade;
use App\Structural\Facade\OperatingSystem;
use PHPUnit\Framework\TestCase;

require "app/Structural/Facade/Examples/Conceptual.php";

class FacadeTest extends TestCase
{
    public function testComputerOn()
    {
        $os = $this->createMock(OperatingSystem::class);

        $os->method('getName')
            ->will($this->returnValue('Linux'));

        $bios = $this->createMock(Bios::class);
        $bios->method('launch')->with($os);

        $facade = new Facade($bios, $os);

        $facade->turnOn();

        $this->assertSame('Linux', $os->getName());
    }
}