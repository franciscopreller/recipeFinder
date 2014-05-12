<?php

namespace FP\RecipeFinderBundle\Model;

class Item
{
	// ==================================================================
	//
	// PROPERTIES
	//
	// ------------------------------------------------------------------

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
	    $this->amount = (int) $amount;
	
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
	    $this->unit = $unit;
	
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
		}
	
	    return $this;
	}

	// ==================================================================
	//
	// METHODS
	//
	// ------------------------------------------------------------------

	public function __construct(
		$name      = null, 
		$amount    = null, 
		$unit      = null, 
		$useByDate = null
	)
	{
		$this
			->setName($name)
			->setAmount($amount)
			->setUnit($unit)
			->setUseByDate($useByDate);
	}
	
}