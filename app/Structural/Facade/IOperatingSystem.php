<?php

namespace App\Structural\Facade;

interface IOperatingSystem
{
    public function halt();

    public function getName(): string;
}