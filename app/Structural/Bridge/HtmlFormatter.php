<?php

namespace App\Structural\Bridge;

class HtmlFormatter implements IFormatter
{
    public function format(string $text): string
    {
        return sprintf('<p>%s</p>', $text);
    }
}