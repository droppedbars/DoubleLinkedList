<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 14-08-27
 * Time: 9:09 PM
 */

namespace droppedbars\datastructure;

class LinkedTreeException extends \Exception {}
class ChildPayloadNotLinkedTreeException extends LinkedTreeException {}

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

	protected function setParent(LinkedTree $newParent) {
		if (!is_null($this->parent)) {
			$node = $this->parent->headChild();
			while (!is_null($node) && $node !== $this) {
				$node = $this->parent->nextChild();
			}
			$this->parent->removeChild();
		}
		$this->parent = $newParent;
		$newParent->addChild($this);
	}

	protected function removeParent() {
		$this->parent = null;
	}

	public function addChild(LinkedTree $payload) {
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
			return $this->childIterator->payload();
		}
	}

	public function tailChild() {
		if (is_null($this->children)) {
			return null;
		} else {
			$this->childIterator = $this->children->tail();
			return $this->childIterator->payload();
		}
	}

	public function nextChild() {
		if (is_null($this->children)) {
			return null;
		} else {
			$this->childIterator = $this->children->next();
			return $this->childIterator->payload();
		}
	}

	public function previousChild() {
		if (is_null($this->children)) {
			return null;
		} else {
			$this->childIterator = $this->children->previous();
			return $this->childIterator->payload();
		}
	}

	public function removeChild() {
		if (!is_null($this->childIterator)) {
			if (!is_null($this->childIterator->previous())) {
				$this->childIterator->payload()->parent = null;
				$this->childIterator = $this->childIterator->previous();
				$this->childIterator->removeNext();
			} else if (!is_null($this->childIterator->next())) {
				$this->childIterator->payload()->parent = null;
				$this->childIterator = $this->childIterator->next();
				$this->childIterator->removePrevious();
			} else { // it was an only child
				$this->childIterator = null;
				$this->children = null;
			}
		}
	}

	public function getChild() {
		$payload = $this->childIterator->payload();

		if (!is_null($payload)) {
			if (!is_a($payload, "LinkedTree")) {
				throw new ChildPayloadNotLinkedTreeException();
			}
		}

		return $payload;
	}

	public function payload() {
		return $this->payload;
	}
} 