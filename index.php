<?php

use App\Excel\ExcelWriter;

error_reporting(E_ALL);
ini_set("display_errors", "On");
require "vendor/autoload.php";

$excel = new ExcelWriter();
$excel->write();