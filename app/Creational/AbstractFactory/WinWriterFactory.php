<?php

namespace App\Creational\AbstractFactory;

use App\Creational\AbstractFactory\Interfaces\CsvWriter;
use App\Creational\AbstractFactory\Interfaces\JsonWriter;
use App\Creational\AbstractFactory\Interfaces\WriterFactory;

class WinWriterFactory implements WriterFactory
{
    public function createCsvWriter(): CsvWriter
    {
        return new WinCsvWriter();
    }

    public function createJsonWriter(): JsonWriter
    {
        return new WinJsonWriter();
    }
}