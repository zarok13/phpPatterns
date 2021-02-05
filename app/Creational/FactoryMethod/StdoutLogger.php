<?php declare(strict_types=1);

namespace App\Creational\FactoryMethod;

use App\Creational\FactoryMethod\Interfaces\Logger;

class StdoutLogger implements Logger
{
    public function log(string $message)
    {
        echo $message;
    }
}