<?php

namespace App\Structural\Flyweight;

use Countable;

/**
 * A factory manages shared flyweights. Clients should not instantiate them directly,
 * but let the factory take care of returning existing objects or creating new ones.
 */
class TextFactory implements Countable
{
    /**
     * @param string $name
     * @return IText
     */
    private array $charPool = [];

    public function get(string $name): IText
    {
        if (!isset($this->charPool[$name])) {
            $this->charPool[$name] = $this->create($name);
        }

        return $this->charPool[$name];
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return IText
     */
    private function create(string $name): IText
    {
        if (strlen($name) == 1) {
            return new Character($name);
        } else {
            return new Word($name);
        }
    }

    public function count(): int
    {
        return count($this->charPool);
    }
}