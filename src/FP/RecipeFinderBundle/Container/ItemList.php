<?php

namespace FP\RecipeFinderBundle\Container;

use FP\RecipeFinderBundle\Models\Item;

class ItemList extends Container implements ContainerInterface
{
	public function whereAttribute($attribute, $value)
	{
		if ($attribute === "useByDate") {
			$value = $this->parseUseByDate($value);
		}

		return parent::whereAttribute($attribute, $value);
	}

	public function where($attribute, $operator, $value)
	{
		if ($attribute === "useByDate") {
			$value = $this->parseUseByDate($value);
		}

		return parent::where($attribute, $operator, $value);
	}

	private function parseUseByDate($value)
	{
		// Note: Ripped this out of the Items model, normally I would
		//       separate it as a new component, but stretched for time
		if (preg_match("^\d{1,2}/\d{1,2}/\d{4}^", $value)) {
			$dateArray = explode('/', $value);
			return new \DateTime(sprintf("%d-%d-%d", $dateArray[2], $dateArray[1], $dateArray[0]));
		} else {
			throw new InvalidDateFormatException("Invalid date passed. Please use (dd/mm/yyyy)");
		}
	}
}