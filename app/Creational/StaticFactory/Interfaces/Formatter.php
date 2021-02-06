<?php

namespace App\Creational\StaticFactory\Interfaces;

interface Formatter
{
    public function format(string $input): string;
}
