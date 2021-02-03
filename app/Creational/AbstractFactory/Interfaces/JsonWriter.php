<?php

namespace App\Creational\AbstractFactory\Interfaces;

interface JsonWriter
{
    public function write(array $data, bool $formatted): string;
    public function withCsv(CsvWriter $collaborator): string;
}
