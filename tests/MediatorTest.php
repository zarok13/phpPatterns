<?php declare(strict_types=1);

namespace DesignPatterns\Tests\Mediator\Tests;

use App\Behavioral\Mediator\Ui;
use App\Behavioral\Mediator\UserRepository;
use App\Behavioral\Mediator\UserRepositoryUiMediator;
use PHPUnit\Framework\TestCase;

require "app/Behavioral/Mediator/Examples/Conceptual.php";

class MediatorTest extends TestCase
{
    public function testOutputHelloWorld()
    {
        $mediator = new UserRepositoryUiMediator(new UserRepository(), new Ui());

        $this->expectOutputString('User: Dominik');
        $mediator->printInfoAbout('Dominik');
    }
}