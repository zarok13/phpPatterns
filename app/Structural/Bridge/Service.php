<?php

namespace App\Structural\Bridge;

abstract class Service
{
    protected IFormatter $implementation;

    public function __construct(IFormatter $printer)
    {
        $this->implementation = $printer;
    }

    public function setImplementation(IFormatter $printer)
    {
        $this->implementation = $printer;
    }

    abstract public function get(): string;
}