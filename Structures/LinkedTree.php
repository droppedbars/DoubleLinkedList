<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 14-08-27
 * Time: 9:09 PM
 */

namespace droppedbars\datastructure;

require_once "DoubleLinkedList.php";


class LinkedTreeException extends \Exception {}
class ChildPayloadNotLinkedTreeException extends LinkedTreeException {}

/**
 * Class LinkedTree
 * @package droppedbars\datastructure
 */
class LinkedTree {
	protected $parent;
	protected $children;
	protected $payload;
	protected $childIterator;

	/**
	 * @param $payload
	 */
	public function __construct($payload) {
		$this->parent = null;
		$this->children = null;
		$this->payload = $payload;
	}

	/**
	 * @param LinkedTree $newParent
	 */
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

	/**
	 *
	 */
	protected function removeParent() {
		$this->parent = null;
	}

	/**
	 * @param LinkedTree $payload
	 */
	public function addChild(LinkedTree $payload) {
		if (is_null($this->children)) {
			$this->children = new DoubleLinkedList($payload);
			$this->childIterator = $this->children;
		} else {
			$this->children->tail()->insertAfter($payload);
		}
	}

	/**
	 * @return null|LinkedTree
	 */
	public function headChild() {
		if (is_null($this->children)) {
			return null;
		} else {
			$this->childIterator = $this->children->head();
			return $this->childIterator->payload();
		}
	}

	/**
	 * @return null|LinkedTree
	 */
	public function tailChild() {
		if (is_null($this->children)) {
			return null;
		} else {
			$this->childIterator = $this->children->tail();
			return $this->childIterator->payload();
		}
	}

	/**
	 * @return null|LinkedTree
	 */
	public function nextChild() {
		if (is_null($this->children)) {
			return null;
		} else {
			if (is_null($this->childIterator)) {
				return null;
			}
			$this->childIterator = $this->childIterator->next();
			if (is_null($this->childIterator)) {
				return null;
			} else {
				return $this->childIterator->payload();
			}
		}
	}

	/**
	 * @return null|LinkedTree
	 */
	public function previousChild() {
		if (is_null($this->children)) {
			return null;
		} else {
			if (is_null($this->childIterator)) {
				return null;
			}
			$this->childIterator = $this->childIterator->previous();
			if (is_null($this->childIterator)) {
				return null;
			} else {
				return $this->childIterator->payload();
			}
		}
	}

	public function removeChild() {
		if (!is_null($this->childIterator)) {
			if ($this->childIterator === $this->children) {
				$this->children = $this->childIterator->next();
			}
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

	/**
	 * @return null|LinkedTree
	 * @throws ChildPayloadNotLinkedTreeException
	 */
	public function getChild() {
		if (!is_null($this->childIterator)) {
			$payload = $this->childIterator->payload();

			if (!is_null($payload)) {
				if (!$payload instanceof LinkedTree) {
					throw new ChildPayloadNotLinkedTreeException();
				}
			}

			return $payload;

		} else {
			return null;
		}
	}

	/**
	 * @return mixed
	 */
	public function payload() {
		return $this->payload;
	}
} 