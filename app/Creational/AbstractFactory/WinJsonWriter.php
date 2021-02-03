<?php

namespace App\Creational\AbstractFactory;

use App\Creational\AbstractFactory\Interfaces\CsvWriter;
use App\Creational\AbstractFactory\Interfaces\JsonWriter;

class WinJsonWriter implements JsonWriter
{
    public function write(array $data, bool $formatted): string
    {
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    public function withCsv(CsvWriter $collaborator): string
    {
        return 'Json with Csv result. ' . $collaborator->write(['win', 'win']);
    }
}