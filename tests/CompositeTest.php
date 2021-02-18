<?php

namespace Tests;

use App\Structural\Composite\Form;
use App\Structural\Composite\InputElement;
use App\Structural\Composite\TextElement;
use PHPUnit\Framework\TestCase;

require "app/Structural/Composite/Examples/Real.php";

class CompositeTest extends TestCase
{
    public function testRender()
    {
        $form = new Form();
        $email = new TextElement('Email:');
        $input = new InputElement();
        $form->addElement($email);
        $form->addElement($input);

        $embed = new Form();
        $password = new TextElement('Password:');
        $input2 = new InputElement();
        $embed->addElement($password);
        $embed->addElement($input2);
        $form->addElement($embed);

        $this->assertSame(
            '<form>Email:<input type="text" /><form>Password:<input type="text" /></form></form>',
            $form->render()
        );

        $form->removeElement($input);

        $this->assertSame(
            '<form>Email:<form>Password:<input type="text" /></form></form>',
            $form->render()
        );

        $form->addElement($input);

        $form->removeElement($embed);
        
        $this->assertSame(
            '<form>Email:<input type="text" /></form>',
            $form->render()
        );
    }
}