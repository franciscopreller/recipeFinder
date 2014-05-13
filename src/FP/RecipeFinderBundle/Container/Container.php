<?php

namespace FP\RecipeFinderBundle\Container;

use FP\RecipeFinderBundle\Exception\InvalidOperatorException;

class Container implements ContainerInterface {

	protected $items;
	protected $results;
	protected $dirty;

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
		if (!$this->dirty) {
			return $this->items;
		}
		$this->dirty = false;

		if ($this->results) {
			return $this->results;
		} else {
			return array();
		}
	}

	public function first()
	{
		if (!$this->dirty) {
			return (!empty($this->items)) ? $this->items[0] : null;
		}
		$this->dirty = false;

		if ($this->results) {
			return array_values($this->results)[0];
		} else {
			return null;
		}
	}

	public function count()
	{
		$this->dirty = false;

		if ($this->results) {
			return count($this->results);
		} else {
			return count($this->items);
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
		$items = $this->getQueryItems();
		$this->results = array_filter(
			$items,
			function ($e) use (&$value, &$attribute) {
				return $e->{$attribute} === $value;
			}
		);

		return $this;
	}

	public function where($attribute, $operator, $value)
	{
		$items = $this->getQueryItems();
		$this->results = array_filter(
			$items,
			function ($e) use (&$attribute, &$operator, &$value) {
				return $this->performOperatorComparison($e->{$attribute}, $operator, $value);
			}
		);

		return $this;
	}

	private function getQueryItems()
	{
		if (!$this->dirty) {
			$this->dirty = true;
			return $this->items;
		} else {
			return $this->results;
		}
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