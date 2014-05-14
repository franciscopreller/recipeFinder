<?php

namespace FP\RecipeFinderBundle\Service;

use FP\RecipeFinderBundle\Model\Item;
use FP\RecipeFinderBundle\Container\ItemList;

class CSVItemsParser {
	
	protected $data;
	protected $columns;

	public function __construct($data)
	{
		$this->data = $data;
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
	 * @param array $columns An array of column names
	 *
	 * @return object A data object
	 */
	public function getFormattedData($columns)
	{
		$data = array();
		$rows = $this->getPlainData();
		foreach($rows as $row) {
			$data[] = (object) array_combine($columns, $row);
		}

		return $data;
	}

	public function getItemList(ItemList $list)
	{
		// Just going to hard code columns here due to time constraint,
		// but personally I'd rather get them directly from the Items 
		// model dynamically in the real world
		$columns = array(
			"name",
			"amount",
			"unit",
			"useByDate"
		);

		$data = $this->getFormattedData($columns);
		foreach ($data as $item) {
			$list->add(new Item(
				$item->name,
				$item->amount,
				$item->unit,
				$item->useByDate
			));
		}

		return $list;
	}
}