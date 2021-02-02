<?php

namespace App\Creational\AbstractFactory;

interface CsvWriter
{
    public function write(array $line): string;
}