<?php

namespace App\Creational\StaticFactory;

use App\Creational\StaticFactory\Interfaces\Formatter;

class FormatString implements Formatter
{
    public function format(string $input): string
    {
        return $input;
    }
}