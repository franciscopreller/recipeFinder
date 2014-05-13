<?php

namespace FP\RecipeFinderBundle\Exception;

class InvalidOperatorException extends \Exception implements InvalidOperatorExceptionInterface
{
	public function __construct($message, $code = 0, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}