<?php

namespace FP\RecipeFinderBundle\Tests\Service;

use FP\RecipeFinderBundle\Service\JsonRecipeCrawler;
use FP\RecipeFinderBundle\Container\ItemList;
use FP\RecipeFinderBundle\Model\Item;

class JsonRecipeCrawlerTest extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		// items
		$list = new ItemList();
		$list->add(new Item("bread", 10, "slices", "25/12/2014"));
		$list->add(new Item("cheese", 10, "slices", "25/12/2014"));
		$list->add(new Item("butter", 250, "grams", "25/12/2014"));
		$list->add(new Item("peanut butter", 250, "grams", "2/12/2014"));
		$list->add(new Item("mixed salad", 500, "grams", "26/05/2014"));

		// json string
		$jsonRecipes = '
			[
				{
					"name": "grilled cheese on toast",
					"ingredients": [
						{ "item":"bread", "amount":"2", "unit":"slices" },
						{ "item":"cheese", "amount":"2", "unit":"slices" }
					]
				},
				{
					"name": "salad sandwich",
					"ingredients": [
						{ "item":"bread", "amount":"2", "unit":"slices" },
						{ "item":"mixed salad", "amount":"200", "unit":"grams" }
					]
				}
			]
		';

		// initialise crawler
		$this->crawler = new JsonRecipeCrawler($list, $jsonRecipes);
	}

	public function testGetData()
	{
		$recipe = $this->crawler->getSuggestedRecipe();
		$this->assertEquals("salad sandwich", $recipe->name);
	}
}