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
	 * Constructor.
	 *
	 * Transform the array of data into the
	 * desired format and store.
	 * 
	 * @param array $items
	 */

	public function __construct(array $items) 
	{
		$this->items = array_map(function($item) 
		{
			return $this->transformItem($item);

		}, $items);

		// Loop through the items, and transform each
		// one, before assigning to $this->items
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

	abstract function transformItem($data);


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