<?php

namespace App\Behavioral\Visitor;

interface Role
{
    public function accept(RoleVisitor $visitor);
}