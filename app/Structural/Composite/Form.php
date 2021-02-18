<?php

namespace App\Structural\Composite;

class Form implements IRenderable
{
    private array $elements;

    /**
     * composite function for both simple and complex components
     *
     * @return string
     */
    public function render(): string
    {
        $formCode = '<form>';

        foreach ($this->elements as $element) {
            $formCode .= $element->render();
        }

        $formCode .= '</form>';

        return $formCode;
    }

    /**
     * add Element
     *
     * @param IRenderable $element
     * @return void
     */
    public function addElement(IRenderable $element)
    {
        $this->elements[] = $element;
    }

    /**
     * remove Element
     *
     * @param IRenderable $needle
     * @return void
     */
    public function removeElement(IRenderable $needle, $strict = true)
    {
        // var_dump($needle,'next', $this->elements);
        if (($key = array_search($needle, $this->elements, $strict)) !== false ) {
            echo $key;
            unset($this->elements[$key]);
        }
    }
}
