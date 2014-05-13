<?php

namespace FP\RecipeFinderBundle\Tests\Model;

use FP\RecipeFinderBundle\Model\Item;

class ItemTest extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->item = new Item();
	}

	public function testSetName()
	{
		$this->item->setName("bananas");
		$this->assertEquals("bananas", $this->item->getName());
	}

	public function testSetAmount()
	{
		$this->item->setAmount(10);
		$this->assertEquals(10, $this->item->getAmount());
	}

	public function testSetAmountInvalid()
	{
		$this->setExpectedException('\FP\RecipeFinderBundle\Exception\InvalidAmountException');
		$this->item->setAmount("notAnAmount");
	}

	public function testSetUnit()
	{
		$this->item->setUnit("slices");
		$this->assertEquals("slices", $this->item->getUnit());
	}

	public function testSetUnitInvalidType()
	{
		$this->setExpectedException('\FP\RecipeFinderBundle\Exception\InvalidUnitTypeException');
		$this->item->setUnit("NotAUnit");
	}

	public function testSetUseByDate()
	{
		$this->item->setUseByDate("25/12/2014");
		$this->assertEquals("25/12/2014", $this->item->getUseByDate());
	}

	public function testSetUseByDateInvalidDate()
	{
		$this->setExpectedException('\FP\RecipeFinderBundle\Exception\InvalidDateFormatException');
		$this->item->setUseBydate("2014-12-25");
	}

	public function testConstructor()
	{
		$item = new Item("bread", 5, "slices", "25/12/2014");

		$this->assertEquals("bread", $item->getName());
		$this->assertEquals(5, $item->getAmount());
		$this->assertEquals("slices", $item->getUnit());
		$this->assertEquals("25/12/2014", $item->getUseByDate());
	}

	public function testIsExpired()
	{
		$this->item->setUseByDate("01/01/2000");
		// should be expired
		$this->assertTrue($this->item->isExpired());

		$this->item->setUseByDate("01/01/3000");
		// should not be expired
		$this->assertFalse($this->item->isExpired());
	}
}