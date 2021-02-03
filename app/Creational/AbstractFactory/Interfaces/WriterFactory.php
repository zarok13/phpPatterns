<?php

namespace App\Creational\AbstractFactory\Interfaces;

interface WriterFactory
{
    public function createCsvWriter(): CsvWriter;
    public function createJsonWriter(): JsonWriter;
}