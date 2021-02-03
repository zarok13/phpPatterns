<?php

namespace App\Creational\AbstractFactory;

use App\Creational\AbstractFactory\Interfaces\CsvWriter;
use App\Creational\AbstractFactory\Interfaces\JsonWriter;

class UnixJsonWriter implements JsonWriter
{
    public function write(array $data, bool $formatted): string
    {
        $options = 0;

        if ($formatted) {
            $options = JSON_PRETTY_PRINT;
        }

        return json_encode($data, $options);
    }

    public function withCsv(CsvWriter $collaborator): string
    {
        $result = $collaborator->write(['ubuntu', 'ubuntu']);
        return 'Json with Csv result. '. $result;
    }
}