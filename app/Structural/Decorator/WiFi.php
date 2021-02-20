<?php

namespace App\Structural\Decorator;

class WiFi extends BookingDecorator
{
    private const PRICE = 2;

    public function calculatePrice(): int
    {
        return parent::calculatePrice() + self::PRICE;
    }

    public function getDescription(): string
    {
        return parent::getDescription() . ' with wifi';
    }
}