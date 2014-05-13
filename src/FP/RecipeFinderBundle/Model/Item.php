<?php

namespace FP\RecipeFinderBundle\Model;

use FP\RecipeFinderBundle\Exception\InvalidDateFormatException;
use FP\RecipeFinderBundle\Exception\InvalidUnitTypeException;
use FP\RecipeFinderBundle\Exception\InvalidAmountException;

/**
 * I have chosen to use plain PHP objects for data storage for this application
 * although this could obviously also be achieved using Doctrine or another ORM.
 */
class Item
{
	/**
	 * Gets the name of the item
	 *
	 * @return string The name of the ingredient
	 */
	public function getName() 
	{
	    return $this->name;
	}
	
	/**
	 * Sets the name of the item
	 *
	 * @param String $newname The name of the ingredient
	 */
	public function setName($name) 
	{
	    $this->name = $name;
	
	    return $this;
	}

	/**
	 * Gets the amount of the item
	 *
	 * @return int The amount of the ingredient
	 */
	public function getAmount() 
	{
	    return $this->amount;
	}
	
	/**
	 * Sets the amount of the item
	 *
	 * @param Int $newamount The amount of the ingredient
	 */
	public function setAmount($amount) 
	{
		if (is_numeric($amount)) {
	    	$this->amount = (int) $amount;
		} else {
			throw new InvalidAmountException("Invalid amount passed. Please use a numeric value.");
		}
	
	    return $this;
	}

	/**
	 * Gets the unit of the item
	 *
	 * @return string The unit of measure of the ingredient
	 */
	public function getUnit() 
	{
	    return $this->unit;
	}
	
	/**
	 * Sets the unit of the item
	 *
	 * @param String $newunit The unit of measure of the ingredient
	 */
	public function setUnit($unit) 
	{
		// check for allowed types here, or throw exception
		$allowedUnitTypes = array("of", "grams", "ml", "slices");
		if (in_array($unit, $allowedUnitTypes)) {
	    	$this->unit = $unit;
		} else {
			throw new InvalidUnitTypeException("Invalid unit passed. Must one of the following: (of, grams, ml, slices)");
		}
	
	    return $this;
	}

	/**
	 * The use by date of the ingredient (dd/mm/yyyy)
	 *
	 * @return string The use-by-date of the ingredient
	 */
	public function getUseByDate() 
	{
	    return $this->useByDate->format("d/m/Y");
	}
	
	/**
	 * Sets the use by date of the ingredient
	 *
	 * @param string $newuseByDate The use-by-date of the ingredient
	 */
	public function setUseByDate($useByDate) 
	{
		// regex check for date format
		if (preg_match("^\d{1,2}/\d{1,2}/\d{4}^", $useByDate)) {
			$dateArray = explode('/', $useByDate);
			// format date to yyyy-mm-dd
			$date = sprintf("%d-%d-%d", $dateArray[2], $dateArray[1], $dateArray[0]);

			$this->useByDate = new \DateTime($date);
		} else {
			throw new InvalidDateFormatException("Invalid date passed. Please use (dd/mm/yyyy)");
		}
	
	    return $this;
	}

	public function __construct(
		$name      = null, 
		$amount    = null, 
		$unit      = null, 
		$useByDate = null
	)
	{
		// only add properties if they aren't null
		if ($name) {
			$this->setName($name);
		}
		if ($amount) {
			$this->setAmount($amount);
		}
		if ($unit) {
			$this->setUnit($unit);
		}
		if ($useByDate) {
			$this->setUseByDate($useByDate);
		}
	}

	public function isExpired()
	{
		return ($this->useByDate < new \DateTime());
	}
	
}