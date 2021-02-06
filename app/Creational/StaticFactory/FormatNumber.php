<?php

namespace App\Creational\StaticFactory;

use App\Creational\StaticFactory\Interfaces\Formatter;

class FormatNumber implements Formatter
{
    public function format(string $input): string
    {
        return number_format((int) $input);
    }
}