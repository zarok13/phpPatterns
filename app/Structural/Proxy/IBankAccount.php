<?php

namespace App\Structural\Proxy;

interface IBankAccount
{
    public function deposit(int $amount);

    public function getBalance(): int;
}