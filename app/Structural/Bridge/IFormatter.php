<?php 

namespace App\Structural\Bridge;

interface IFormatter
{
    public function format(string $text): string;
}