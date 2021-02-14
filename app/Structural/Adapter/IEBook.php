<?php

namespace App\Structural\Adapter;

interface IEBook
{
    public function unlock();

    public function pressNext();

    public function getPage(): array;
}