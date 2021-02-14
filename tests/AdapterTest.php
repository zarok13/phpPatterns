<?php

namespace Tests;

use App\Structural\Adapter\EBookAdapter;
use PHPUnit\Framework\TestCase;
use App\Structural\Adapter\Kindle;
use App\Structural\Adapter\PaperBook;

require "app/Structural/Adapter/Real/Real.php";

final class AdapterTest extends TestCase
{
    public function testCanTurnPageOnBook()
    {
        $book = new PaperBook();
        $book->open();
        $book->turnPage();

        $this->assertSame(2, $book->getPage());
    }

    public function testCanTurnPageOnKindleLikeInANormalBook()
    {
        $kindle = new Kindle();
        $book = new EBookAdapter($kindle);

        $book->open();
        $book->turnPage();

        $this->assertSame(2, $book->getPage());
    }
}