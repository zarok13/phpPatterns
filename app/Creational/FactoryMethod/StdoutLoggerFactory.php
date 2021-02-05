<?php declare(strict_types=1);

namespace App\Creational\FactoryMethod;

use App\Creational\FactoryMethod\Interfaces\Logger;
use App\Creational\FactoryMethod\Interfaces\LoggerFactory;

class StdoutLoggerFactory implements LoggerFactory
{
    public function createLogger(): Logger
    {
        return new StdoutLogger();
    }
}