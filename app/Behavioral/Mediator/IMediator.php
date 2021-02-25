<?php

namespace App\Behavioral\Mediator;

interface IMediator
{
    public function getUser(string $username): string;
}