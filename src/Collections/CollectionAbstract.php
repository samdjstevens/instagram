<?php namespace Spanky\Instagram\Collections;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use ArrayIterator;

abstract class CollectionAbstract implements ArrayAccess, Countable, IteratorAggregate {

	/**
	 * Holds the transformed items in the 
	 * collection.
	 * 
	 * @var array
	 */

	private $items = array();


	/**
	 * Store the pagination object.
	 * 
	 * @var stdClass
	 */

	private $pagination;


	/**
	 * Constructor.
	 *
	 * Transform the array of data into the
	 * desired format and store.
	 * 
	 * @param array $items
	 */

	public function __construct(array $items, $pagination, $api = null) 
	{
		$this->items = array_map(function($item) use ($api) 
		{
			return $this->transformItem($item, $api);

		}, $items);

		// Loop through the items, and transform each
		// one, before assigning to $this->items

		$this->pagination = $pagination;
		// Store the pagination object
	}


	/**
	 * Transform an individual item's data into
	 * another form, like an object.
	 *
	 * Implementation left up to the inheriting
	 * concrete class.
	 * 
	 * @param  mixed $data
	 * @return mixed
	 */

	abstract function transformItem($data, $api = null);


	/**
	 * Retrieve the raw array of items.
	 * 
	 * @return array
	 */

	public function getItems() 
	{
		return $this->items;
	}


	/**
	 * Retrieve the first item in the collection.
	 * 
	 * @return mixed
	 */

	public function first() 
	{
		return count($this->items) ? $this->items[0] : null;
	}


	/**
	 * Retrieve the last item in the collection.
	 * 
	 * @return mixed
	 */

	public function last() 
	{
		return count($this->items) ? end($this->items) : null;
	}


	/**
	 * Pagination.
	 */

	/**
	 * Determine if there are more items to
	 * retrieve for this collection.
	 * 
	 * @return boolean
	 */

	public function hasMoreItems() 
	{
		return isset($this->pagination->next_max_id);
	}


	/**
	 * Get the max id for the next page.
	 * 
	 * @return int
	 */

	public function nextPageMaxId() 
	{
		return isset($this->pagination->next_max_id) ? $this->pagination->next_max_id : false;
	}


	/**
	 * Get the next page url.
	 * 
	 * @return string
	 */

	public function nextPageUrl() 
	{
		return isset($this->pagination->next_url) ? $this->pagination->next_url : false;
	}


	/**
	 * ArrayAccess
	 */
	
	public function offsetExists($offset) 
	{
		return isset($this->items[$offset]);
	}

	public function offsetGet($offset) 
	{
		return $this->items[$offset];
	}

	public function offsetSet($offset, $value) 
	{
		$this->items[$offset] = $value;
	}

	public function offsetUnset($offset) 
	{
		unset($this->items[$offset]);
	}


	/**
	 * Countable
	 */

	public function count() 
	{
		return count($this->items);
	}


	/**
	 * IteratorAggregate
	 */

	public function getIterator() 
	{
		return new ArrayIterator($this->items);
	}
}