<?php

namespace App\Creational\AbstractFactory;

use App\Creational\AbstractFactory\Interfaces\CsvWriter;

class UnixCsvWriter implements CsvWriter
{
    public function write(array $line): string
    {
        return join(',', $line) . "\n";
    }
}