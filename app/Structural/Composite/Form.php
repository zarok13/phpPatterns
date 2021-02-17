<?php

namespace App\Structural\Composite;

class Form implements IRenderable
{
    private array $elements;

    public function render(): string
    {
        $formCode = '<form>';

        foreach ($this->elements as $element) {
            $formCode .= $element->render();
        }

        $formCode .= '</form>';

        return $formCode;
    }

    public function addElement(IRenderable $element)
    {
        $this->elements[] = $element;
    }
}
