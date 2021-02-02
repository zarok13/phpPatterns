<?php declare(strict_types=1);

namespace Tests;

use App\Creational\AbstractFactory\CsvWriter;
use App\Creational\AbstractFactory\JsonWriter;
use App\Creational\AbstractFactory\UnixWriterFactory;
use App\Creational\AbstractFactory\WinWriterFactory;
use App\Creational\AbstractFactory\WriterFactory;
use PHPUnit\Framework\TestCase;

class AbstractFactoryTest extends TestCase
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function provideFactory()
    {
        return [
            [new UnixWriterFactory()],
            [new WinWriterFactory()]
        ];
    }

    /**
     * @dataProvider provideFactory
     *
     * @param WriterFactory $writerFactory
     */
    public function testCanCreateCsvWriterOnUnix(WriterFactory $writerFactory)
    {
        $this->assertInstanceOf(JsonWriter::class, $writerFactory->createJsonWriter());
        $this->assertInstanceOf(CsvWriter::class, $writerFactory->createCsvWriter());
    }
}