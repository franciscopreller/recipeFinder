<?php

namespace FP\RecipeFinderBundle\Tests\Container;

use FP\RecipeFinderBundle\Model\Item;
use FP\RecipeFinderBundle\Container\ItemList;

class ItemListTest extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->list = new ItemList();
	}

	public function testAdd()
	{
		$this->list->add(new Item("bread", 10, "slices", "25/12/2014"));
		$this->list->add(new Item("cheese", 10, "slices", "25/12/2014"));

		$this->assertCount(2, $this->list->get());
	}

	public function testGet()
	{
		// test for empty
		$this->assertCount(0, $this->list->get());

		// add one
		$this->list->add(new Item("bread", 10, "slices", "25/12/2014"));

		// test for 1
		$this->assertCount(1, $this->list->get());
	}

	public function testGetByAttribute()
	{
		$this->list->add(new Item("bread", 10, "slices", "25/12/2014"));
		$this->list->add(new Item("cheese", 10, "slices", "25/12/2014"));
		
		// only one bread and should return the name bread
		$this->assertCount(1, $this->list->whereAttribute("name", "bread")->get());
		$this->assertEquals("bread", $this->list->whereAttribute("name", "bread")->first()->name);

		// return 2 items with 'slices' for unit
		$this->assertCount(2, $this->list->whereAttribute("unit", "slices")->get());
	}

	public function testRemove()
	{
		$this->list->add(new Item("bread", 10, "slices", "25/12/2014"));
		$this->list->add(new Item("cheese", 10, "slices", "25/12/2014"));

		// get the item to remove
		$item = $this->list->where("name", "=", "cheese")->first();

		// remove one
		$this->list->remove($item);

		// count should be 1
		$this->assertCount(1, $this->list->get());

		// first item in list's name should be bread
		$this->assertEquals("bread", $this->list->first()->name);
	}

	public function testGetWhere()
	{
		$this->list->add(new Item("bread", 10, "slices", "25/12/2014"));
		$this->list->add(new Item("cheese", 5, "slices", "25/12/2014"));

		// should return 1 item
		$this->assertCount(1, $this->list->where("name", "=", "bread")->get());

		// The item's name will be bread
		$this->assertEquals("bread", $this->list->where("name", "=", "bread")->first()->name);

		// should return 1 item
		$this->assertCount(1, $this->list->where("amount", "<", 9)->get());

		// The item's name will be cheese
		$this->assertEquals("cheese", $this->list->where("amount", "<", 9)->first()->name);
	}

	public function testGetWhereUsingUseByDate()
	{
		$this->list->add(new Item("bread", 10, "slices", "25/12/2014"));
		$this->list->add(new Item("cheese", 5, "slices", "28/12/2014"));

		// should return 1 item
		$this->assertCount(1, $this->list->where("useByDate", ">", "26/12/2014")->get());

		// item's name should equal cheese
		$this->assertEquals("cheese", $this->list->where("useByDate", ">", "26/12/2014")->first()->name);
	}

	public function testMultipleWhereStatements()
	{
		$this->list->add(new Item("bread", 10, "slices", "25/12/2014"));
		$this->list->add(new Item("cheese", 10, "slices", "28/12/2014"));
		$this->list->add(new Item("butter", 250, "grams", "25/12/2014"));

		// should return 2 items
		$items = $this->list
			->where("unit", "=", "slices")
			->where("amount", ">", 5)
			->get();
		$this->assertCount(2, $items);

		// should return 1 item
		$items = $this->list
			->where("useByDate", "<", "27/12/2014")
			->where("unit", "=", "slices")
			->get();
		$this->assertCount(1, $items);

		// should be "bread"
		$item = $this->list
			->where("useByDate", "<", "27/12/2014")
			->where("unit", "=", "slices")
			->first();
		$this->assertEquals("bread", $item->name);
	}

}