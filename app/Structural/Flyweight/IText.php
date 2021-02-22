<?php

namespace App\Structural\Flyweight;

/**
 * This is the interface that all flyweights need to implement
 */
interface IText
{
    public function render(string $extrinsicState): string;
}