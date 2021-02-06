<?php 

namespace App\Creational\StaticFactory;

use App\Creational\StaticFactory\Interfaces\Formatter;

final class StaticFactory
{
    public static function factory(string $type): Formatter
    {
        if($type == 'number'){
            return new FormatNumber();
        } elseif($type == 'string'){
            return new FormatString();
        }

        throw new \InvalidArgumentException('Unknown format given');
    }
}