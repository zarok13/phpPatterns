<?php

namespace Tests;

use App\Structural\Facade\IBios;
use App\Structural\Facade\Facade;
use App\Structural\Facade\IOperatingSystem;
use PHPUnit\Framework\TestCase;

require "app/Structural/Facade/Examples/Conceptual.php";

class FacadeTest extends TestCase
{
    public function testComputerOn()
    {
        $os = $this->createMock(IOperatingSystem::class);

        $os->method('getName')
            ->will($this->returnValue('Linux'));

        $bios = $this->createMock(IBios::class);
        $bios->method('launch')->with($os);

        $facade = new Facade($bios, $os);

        $facade->turnOn();

        $this->assertSame('Linux', $os->getName());
    }
}