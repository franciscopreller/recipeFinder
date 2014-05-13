<?php

namespace FP\RecipeFinderBundle\Service;

use FP\RecipeFinderBundle\Container\ItemList;

class JsonRecipeCrawler {

	protected $list;
	protected $recipes;
	protected $closestUseByDateRecipe;

	public function __construct(ItemList $list, $jsonRecipe)
	{
		$this->list    = $list;
		$this->recipes = json_decode($jsonRecipe);
	}

	public function getSuggestedRecipe()
	{
		$output = null;
		$closestUseByDate = null;

		foreach ($this->recipes as $recipe) {
			$match = true;
			foreach ($recipe->ingredients as $ingredient) {
				if ($match) {
					$item = $this->list
						->whereAttribute("name", $ingredient->item)
						->whereAttribute("unit", $ingredient->unit)
						->where("amount", ">=", $ingredient->amount)
						->first();
					// if no items were found for criteria or the item found
					// is expired, this recipe is no longer a possible match
					if (!$item || $item->isExpired()) {
						$match = false;
					} else {
						// if there has been no closest use by date set yet, or
						// the current date is lower than the closest use by date
						if (!$closestUseByDate || $closestUseByDate > $item->useByDate) {
							$closestUseByDate = $item->useByDate;
							$this->closestUseByDateRecipe = $recipe;
						}
					}
				}
			}
			if ($match && $closestUseByDate) {
				$output = $this->closestUseByDateRecipe;
			}
		}

		return $output;
	}

}