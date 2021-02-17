<?php

namespace App\Structural\Composite;

class InputElement implements IRenderable
{
    public function render(): string
    {
        return '<input type="text" />';
    }
}