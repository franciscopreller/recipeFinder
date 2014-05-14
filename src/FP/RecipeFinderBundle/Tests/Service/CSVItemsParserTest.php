<?php

namespace FP\RecipeFinderBundle\Tests\Service;

use FP\RecipeFinderBundle\Service\CSVItemsParser;
use FP\RecipeFinderBundle\Container\ItemList;

class CSVItemsParserTest extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$data = implode(PHP_EOL, array(
			"bread,10,slices,25/12/2014",
			"cheese,10,slices,25/12/2014",
			"butter,250,grams,25/12/2014",
			"peanut butter,250,grams,2/12/2014",
			"mixed salad,500,grams,26/12/2013"
		));
		$this->parser = new CSVItemsParser($data);
		$this->list   = new ItemList();
	}

	public function testGetPlainData()
	{
		$data = $this->parser->getPlainData();

		// count total rows, should be 5
		$this->assertCount(5, $data);

		// count total elements in first row, should be 4
		$this->assertCount(4, $data[0]);

		// read first element in last row, should be mixed salad
		$this->assertEquals("mixed salad", $data[4][0]);
	}

	public function testGetDataWithColumns()
	{
		$data = $this->parser->getFormattedData(array("name", "amount", "unit", "useByDate"));

		// expect first item's name property to be bread
		$this->assertEquals("bread", $data[0]->name);

		// expect first item's amount property to be 10
		$this->assertEquals(10, (int) $data[0]->amount);

		// expect first item's unit to be slices
		$this->assertEquals("slices", $data[0]->unit);

		// expect first item's useByDate to be 25/12/2014
		$this->assertEquals("25/12/2014", $data[0]->useByDate);
	}

	public function testGetItemList()
	{
		$list = $this->parser->getItemList($this->list);
		
		// query for the item with butter as name
		$this->assertEquals("butter", $list->whereAttribute("name", "butter")->first()->name);
	}
}