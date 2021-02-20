<?php

namespace App\Structural\Decorator;

class ExtraBed extends BookingDecorator
{
    private const PRICE = 30;

    public function calculatePrice(): int
    {
        return parent::calculatePrice() + self::PRICE;
    }

    public function getDescription(): string
    {
        return parent::getDescription() . ' with extra bed';
    }
}