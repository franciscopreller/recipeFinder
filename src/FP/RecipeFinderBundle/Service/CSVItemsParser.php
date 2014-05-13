<?php

namespace FP\RecipeFinderBundle\Service;

class CSVItemsParser {
	
	protected $data;
	protected $columns;

	public function __construct($data)
	{
		$this->data = $data;
	}

	/**
	 * Gets the columns
	 *
	 * @return array The CSV sheet's columns
	 */
	public function getColumns() {
	    return $this->columns;
	}
	
	/**
	 * Sets the columns
	 *
	 * @param Array $newcolumns The CSV sheet's columns
	 */
	public function setColumns($columns) {
	    $this->columns = $columns;
	
	    return $this;
	}

	/**
	 * Gets the plain data from the csv
	 *
	 * @return array The plain data
	 */
	public function getPlainData()
	{
		$rows = array_filter(explode(PHP_EOL, $this->data));
		$data = array();
		foreach ($rows as $i => $row) {
			$data[] = explode(",", $row);
		}

		return $data;
	}

	/**
	 * Gets the formatted data from the csv
	 *
	 * @return 
	 */
	public function getFormattedData()
	{
		if ($this->columns) {
			$data = array();
			$rows = $this->getPlainData();
			foreach($rows as $row) {
				$data[] = (object) array_combine($this->columns, $row);
			}

			return $data;
		} else {

		}
	}


}