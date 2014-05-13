<?php

namespace FP\RecipeFinderBundle\Container;

use FP\RecipeFinderBundle\Exception\InvalidOperatorException;

class Container implements ContainerInterface {

	protected $items;
	protected $results;

	public function __construct()
	{
		$this->items   = array();
		$this->results = array();
	}

	public function add($item)
	{
		$this->items[] = $item;
	}

	public function get()
	{
		return ($this->results) ?: $this->items;
	}

	public function first()
	{
		if ($this->results) {
			ksort($this->results);
			return array_values($this->results)[0];
		} else {
			return array_values($this->items)[0];
		}
	}

	public function remove($item)
	{
		$this->results = null;
		$this->items   = array_filter(
			$this->items,
			function ($e) use (&$item) {
				return $e !== $item;
			}
		);
	}

	public function whereAttribute($attribute, $value)
	{
		$this->results = array_filter(
			$this->items,
			function ($e) use (&$value, &$attribute) {
				return $e->{$attribute} === $value;
			}
		);

		return $this;
	}

	public function where($attribute, $operator, $value)
	{
		$this->results = array_filter(
			$this->items,
			function ($e) use (&$attribute, &$operator, &$value) {
				return $this->performOperatorComparison($e->{$attribute}, $operator, $value);
			}
		);

		return $this;
	}

	private function performOperatorComparison($item, $operator, $otherItem)
	{
		switch ($operator)
		{
			case '>':
				return $item > $otherItem;

			case '>=':
				return $item >= $otherItem;

			case '<':
				return $item < $otherItem;

			case '<=':
				return $item <= $otherItem;

			case '=':
				return $item == $otherItem;

			case '!=':
				return $item != $otherItem;

			default:
				throw new InvalidOperatorException("The passed operator '{$operator}' is invalid for this query.");
		}
	}
}