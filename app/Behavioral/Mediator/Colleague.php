<?php

namespace App\Behavioral\Mediator;

abstract class Colleague
{
    protected IMediator $mediator;

    public function setMediator(IMediator $mediator)
    {
        $this->mediator = $mediator;
    }
}