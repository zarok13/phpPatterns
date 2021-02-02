<?php

namespace Creational\AbstractFactory;

interface JsonWriter
{
    public function write(array $data, bool $formatted): string;
}