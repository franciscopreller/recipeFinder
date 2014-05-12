<?php

namespace FP\RecipeFinderBundle\Tests\Model;

use FP\RecipeFinderBundle\Model\Item;
use FP\RecipeFinderBundle\Exception\InvalidDateFormatException;

class ItemTest extends \PHPUnit_Framework_TestCase
{
	public function testSetName()
	{
		$name = "bananas";
		$item = new Item();
		$item->setName($name);

		$this->assertEquals($name, $item->getName());
	}

	public function testSetAmount()
	{
		$amount = 10;
		$item = new Item();
		$item->setAmount($amount);

		$this->assertEquals($amount, $item->getAmount());
	}

	public function testSetUnit()
	{
		$unit = "slices";
		$item = new Item();
		$item->setUnit($unit);

		$this->assertEquals($unit, $item->getUnit());
	}

	public function testSetUseByDate()
	{
		$date = "25/12/2014";
		$item = new Item();
		$item->setUseByDate($date);

		$this->assertEquals($date, $item->getUseByDate());
	}

	public function testSetUseByDateInvalidDate()
	{
		$this->setExpectedException('\FP\RecipeFinderBundle\Exception\InvalidDateFormatException');

		// invalid date format (not dd/mm/yyyy)
		$date = "2014-12-25";
		$item = new Item();
		$item->setUseBydate($date);
	}

	public function testConstructor()
	{
		$name      = "bread";
		$amount    = 5;
		$unit      = "slices";
		$useByDate = "25/12/2014";

		$item = new Item($name, $amount, $unit, $useByDate);

		$this->assertEquals($name, $item->getName());
		$this->assertEquals($amount, $item->getAmount());
		$this->assertEquals($unit, $item->getUnit());
		$this->assertEquals($useByDate, $item->getUseByDate());
	}
}