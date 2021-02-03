<?php

use App\Creational\AbstractFactory\Interfaces\WriterFactory;
use App\Creational\AbstractFactory\UnixWriterFactory;
use App\Creational\AbstractFactory\WinWriterFactory;

error_reporting(E_ALL);
ini_set("display_errors", "On");
require "vendor/autoload.php";



function clientCode(WriterFactory $factory)
{
    $csvWriter = $factory->createCsvWriter();
    $jsonWriter = $factory->createJsonWriter();
    $data = [];
    if ($factory instanceof UnixWriterFactory) {
        $data = ['ubuntu', 'ubuntu'];
    } elseif ($factory instanceof WinWriterFactory) {
        $data = ['win', 'win'];
    }
    echo $csvWriter->write($data) . "\n";
    echo $jsonWriter->write($data, true) . "\n";
    echo $jsonWriter->withCsv($csvWriter) . "\n";
}

echo "Client: Testing client code with the first factory type:\n";
clientCode(new UnixWriterFactory());

echo "\n";

echo "Client: Testing the same client code with the second factory type:\n";
clientCode(new WinWriterFactory());
