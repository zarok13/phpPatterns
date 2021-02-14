<?php

namespace App\Structural\Adapter;


interface IBook
{
    public function turnPage();

    public function open();

    public function getPage(): int;
}