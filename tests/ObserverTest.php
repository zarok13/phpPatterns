<?php

namespace Tests;

use App\Behavioral\Observer\User;
use App\Behavioral\Observer\UserObserver;
use PHPUnit\Framework\TestCase;

require "app/Behavioral/Observer/Examples/Conceptual.php";

class ObserverTest extends TestCase
{
    public function testChangeInUserLeadsToUserObserverBeingNotified()
    {
        $observer = new UserObserver();

        $user = new User();
        $user->attach($observer);

        $user->changeEmail('foo@bar.com');
        $this->assertCount(1, $observer->getChangedUsers());
    }
}