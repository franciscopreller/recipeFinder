<?php

namespace FP\RecipeFinderBundle\Exception;

class InvalidAmountException extends \Exception implements InvalidAmountExceptionInterface
{
	public function __construct($message, $code = 0, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}