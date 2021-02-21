<?php

namespace App\Structural\Facade;

interface IBios
{
    public function execute();

    public function waitForKeyPress();

    public function launch(OperatingSystem $os);

    public function powerDown();
}