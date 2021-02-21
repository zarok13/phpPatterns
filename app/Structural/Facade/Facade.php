<?php

namespace App\Structural\Facade;

class Facade
{
    private IOperatingSystem $os;
    private IBios $bios;

    public function __construct(IBios $bios, IOperatingSystem $os)
    {
        $this->bios = $bios;
        $this->os = $os;
    }

    public function turnOn()
    {
        $this->bios->execute();
        $this->bios->waitForKeyPress();
        $this->bios->launch($this->os);
    }

    public function turnOff()
    {
        $this->os->halt();
        $this->bios->powerDown();
    }
}