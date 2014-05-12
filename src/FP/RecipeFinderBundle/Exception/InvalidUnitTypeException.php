<?php

namespace FP\RecipeFinderBundle\Exception;

class InvalidUnitTypeException extends \Exception implements InvalidUnitTypeExceptionInterface
{
	public function __construct($message, $code = 0, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}