<?php declare(strict_types=1);

namespace App\Creational\FactoryMethod\Interfaces;

interface Logger
{
    public function log(string $message);
}