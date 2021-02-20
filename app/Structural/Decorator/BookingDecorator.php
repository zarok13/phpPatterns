<?php

namespace App\Structural\Decorator;

class BookingDecorator implements Booking
{
    protected Booking $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function getDescription(): string
    {
        return $this->booking->getDescription();
    }

    public function calculatePrice(): int
    {
        return $this->booking->calculatePrice();
    }
}