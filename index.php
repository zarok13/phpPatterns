<?php

error_reporting(E_ALL);
ini_set("display_errors","On");

require "vendor/autoload.php";

use Creational\AbstractFactory\UnixCsvWriter;
// echo 'fasdf';
$csvWriter = new UnixCsvWriter();
echo 'fasdf';