<?php

namespace Tests;

use App\Structural\Bridge\HelloWorldService;
use App\Structural\Bridge\HtmlFormatter;
use App\Structural\Bridge\PingService;
use App\Structural\Bridge\PlainTextFormatter;
use PHPUnit\Framework\TestCase;

require "app/Structural/Bridge/Real/Real.php";

class BridgeTest extends TestCase
{
    public function testCanPrintUsingThePlainTextFormatter()
    {
        $service = new HelloWorldService(new PlainTextFormatter());

        $this->assertSame('Hello World', $service->get());

        $service = new PingService(new PlainTextFormatter());

        $this->assertSame('pong', $service->get());
    }

    public function testCanPrintUsingTheHtmlFormatter()
    {
        $service = new HelloWorldService(new HtmlFormatter());

        $this->assertSame('<p>Hello World</p>', $service->get());

        $service = new PingService(new HtmlFormatter());

        $this->assertSame('<p>pong</p>', $service->get());
    }
}