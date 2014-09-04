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
			$this->parent->removeChild($this); // TODO dangerous, would be stuck with no references left
			// TODO: remove $this->parent's reference to this child
			// TODO: remove old references
		}
		$this->parent = $newParent;
		$newParent->addChild($this);
	}

	protected function removeParent() {
		$this->parent->removeChild($this);
		$this->parent = null;
		// TODO: deal with linkages
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

	public function removeChild(LinkedTree $child = null) {
		// TODO: must deal with linkages inside the payloads
		// TODO: probably throw exceptions if the payloads are not LinkedTree types
		if (is_null($child)) {
			if (!is_null($this->childIterator)) {
				if (!is_null($this->childIterator->previous())) {
					$this->childIterator = $this->childIterator->previous();
					$this->childIterator->removeNext();
				} else if (!is_null($this->childIterator->next())) {
					$this->childIterator = $this->childIterator->next();
					$this->childIterator->removePrevious();
				} else { // it was an only child
					$this->childIterator = null;
					$this->children = null;
				}
			}
		} else {
			if (!is_null($this->children)) {
				$element = null;
				$nextElement = $this->headChild();
				while (!(is_null($nextElement)) && !($nextElement->payload() === $child)) {
					$element = $nextElement;
					$nextElement = $nextElement->next();
				}
				if ($nextElement->payload() === $child) {
					if (!is_null($element)) {
						$element->removeNext();
					} else {
						$element = $nextElement;
						$nextElement = $nextElement->next();
						if (!is_null($nextElement)) {
							$nextElement->removePrevious();
						} else { // it was an only child
							$nextElement = null;
							$this->children = null;
						}
					}
				}
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

		return $this->childIterator->payload();
	}

	public function payload() {
		return $this->payload;
	}
} 