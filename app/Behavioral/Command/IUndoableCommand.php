<?php

namespace App\Behavioral\Command;

interface IUndoableCommand extends ICommand
{
    /**
     * This method is used to undo change made by command execution
     */
    public function undo();
}