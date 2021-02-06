<?php

namespace DesignPatterns\Creational\StaticFactory\Tests;

use App\Creational\StaticFactory\FormatNumber;
use App\Creational\StaticFactory\FormatString;
use App\Creational\StaticFactory\StaticFactory;
use PHPUnit\Framework\TestCase;

class StaticFactoryTest extends TestCase
{
    public function testCanCreateNumberFormatter()
    {
        $this->assertInstanceOf(FormatNumber::class, StaticFactory::factory('number'));
    }

    public function testCanCreateStringFormatter()
    {
        $this->assertInstanceOf(FormatString::class, StaticFactory::factory('string'));
    }

    public function testException()
    {
        $this->expectException(\InvalidArgumentException::class);

        StaticFactory::factory('object');
    }
}