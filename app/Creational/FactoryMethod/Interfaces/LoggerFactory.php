<?php declare(strict_types=1);

namespace App\Creational\FactoryMethod\Interfaces;

use App\Creational\FactoryMethod\Interfaces\Logger;

interface LoggerFactory
{
    public function createLogger(): Logger;
}