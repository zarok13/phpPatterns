<?php

namespace App\Structural\Bridge;

class PlainTextFormatter implements IFormatter
{
    public function format(string $text): string
    {
        return $text;
    }
}