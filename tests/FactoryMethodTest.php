<?php declare(strict_types=1);

namespace Tests;

use App\Creational\FactoryMethod\FileLogger;
use App\Creational\FactoryMethod\FileLoggerFactory;
use App\Creational\FactoryMethod\StdoutLogger;
use App\Creational\FactoryMethod\StdoutLoggerFactory;
use PHPUnit\Framework\TestCase;

require "app/Creational/FactoryMethod/Real/Real.php";

class FactoryMethodTest extends TestCase
{
    public function testCanCreateStdoutLogging()
    {
        $loggerFactory = new StdoutLoggerFactory();
        $logger = $loggerFactory->createLogger();

        $this->assertInstanceOf(StdoutLogger::class, $logger);
    }

    public function testCanCreateFileLogging()
    {
        $loggerFactory = new FileLoggerFactory(sys_get_temp_dir());
        $logger = $loggerFactory->createLogger();

        $this->assertInstanceOf(FileLogger::class, $logger);
    }
}