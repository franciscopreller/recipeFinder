<?php

namespace FP\RecipeFinderBundle\Tests\Command;

use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use FP\RecipeFinderBundle\Command\RecipeFindCommand;

class RecipeFindCommandTest extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->kernel = $this->getMock('Symfony\Component\HttpKernel\Kernel', array(), array(), '', false, false);
	}

	public function testExecute()
	{

	    $application = new Application($this->kernel);
	    $application->add(new RecipeFindCommand());

	    $command = $application->find('recipe:find');
	    $commandTester = new CommandTester($command);
	    $commandTester->execute(array(
	    	'--demo' => true
	    ));

	    $this->assertContains("'salad sandwich'", $commandTester->getDisplay());
	}
}