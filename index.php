<?php

use App\Creational\AbstractFactory\UnixCsvWriter;

error_reporting(E_ALL);
ini_set("display_errors","On");
require "vendor/autoload.php";



$unixCsvWriter = new UnixCsvWriter();


echo $unixCsvWriter->write(['fasdf','gdsfgsd']);
