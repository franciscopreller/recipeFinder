<?php

namespace FP\RecipeFinderBundle\Container;

interface ContainerInterface
{
	public function add($item);

	public function get();

	public function first();

	public function remove($item);

	public function whereAttribute($attribute, $value);

	public function where($attribute, $operator, $value);

}