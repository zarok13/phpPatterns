<?php

namespace Tests;

use App\Behavioral\Visitor\RecordingVisitor;
use App\Behavioral\Visitor\User;
use App\Behavioral\Visitor\Group;
use App\Behavioral\Visitor\Role;
use PHPUnit\Framework\TestCase;

require "app/Behavioral/Visitor/Examples/Conceptual.php";

class VisitorTest extends TestCase
{
    private RecordingVisitor $visitor;

    protected function setUp(): void
    {
        $this->visitor = new RecordingVisitor();
    }

    public function provideRoles()
    {
        return [
            [new User('Dominik')],
            [new Group('Administrators')],
        ];
    }

    /**
     * @dataProvider provideRoles
     */
    public function testVisitSomeRole(Role $role)
    {
        $role->accept($this->visitor);
        $this->assertSame($role, $this->visitor->getVisited()[0]);
    }
}