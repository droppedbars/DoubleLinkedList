<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 14-08-27
 * Time: 9:09 PM
 */

namespace droppedbars\datastructure;


class LinkedTree {
	protected $parent;
	protected $children;
	protected $payload;
	protected $childIterator;

	public function __construct($payload) {
		$this->parent = null;
		$this->children = null;
		$this->payload = $payload;
	}

	protected function addParent(LinkedTree $newParent) {
		$this->parent = $newParent;
		// TODO: deal with linkages
	}

	protected function removeParent() {
		$this->parent = null;
		// TODO: deal with linkages
	}

	public function addChild($payload) {
		if (is_null($this->children)) {
			$this->children = new DoubleLinkedList($payload);
		} else {
			$this->children->tail()->insertAfter($payload);
		}
	}

	public function headChild() {
		if (is_null($this->children)) {
			return null;
		} else {
			$this->childIterator = $this->children->head();
			return $this->childIterator;
		}
	}

	public function tailChild() {
		if (is_null($this->children)) {
			return null;
		} else {
			$this->childIterator = $this->children->tail();
			return $this->childIterator;
		}
	}

	public function nextChild() {
		if (is_null($this->children)) {
			return null;
		} else {
			$this->childIterator = $this->children->next();
			return $this->childIterator;
		}
	}

	public function previousChild() {
		if (is_null($this->children)) {
			return null;
		} else {
			$this->childIterator = $this->children->previous();
			return $this->childIterator;
		}
	}

	public function removeChild() {
		// TODO: must deal with linkages inside the payloads
		// TODO: probably throw exceptions if the payloads are not LinkedTree types
		if (!is_null($this->childIterator)) {
			if (!is_null($this->childIterator->previous())) {
				$this->childIterator = $this->childIterator->previous();
				$this->childIterator->removeNext();
			} else if (!is_null($this->childIterator->next())) {
				$this->childIterator = $this->childIterator->next();
				$this->childIterator->removePrevious();
			} else { // it was the only child left
				$this->childIterator = null;
				$this->children = null;
			}
		}
	}

	public function getChild() {
		// TODO: check type, throw exception if wrong
		return $this->childIterator->payload();
	}

	public function payload() {
		return $this->payload;
	}
} 