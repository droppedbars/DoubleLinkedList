<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 14-08-13
 * Time: 8:39 PM
 */

namespace droppedbars\datastructure;


class DoubleLinkedList {
	private $previous;
	protected $next;
	protected $payload;

	public function __construct($payload) {
		$this->previous = null;
		$this->next = null;
		$this->payload = $payload;
	}

	public function payload() {
		return $this->payload;
	}

	public function insertBefore($newPayload) {
		$node = new DoubleLinkedList($newPayload);
		$oldPrevious = $this->previous;

		$node->next = $this;
		$this->previous = $node;

		if (!is_null($oldPrevious)) {
			$oldPrevious->next = $node;
			$node->previous = $oldPrevious;
		}
	}

	public function insertAfter($newPayload) {
		$node = new DoubleLinkedList($newPayload);
		$oldNext = $this->next;

		$this->next = $node;
		$node->previous = $this;

		if (!is_null($oldNext)) {
			$oldNext->previous = $node;
			$node->next = $oldNext;
		}
	}

	public function removeNext() {
		$next = $this->next;
		if (!is_null($next)) {
			$nextNext = $next->next;
			$this->next = $nextNext;
			if (!is_null($nextNext)) {
				$nextNext->previous = $this;
			}
			$next->previous = null;
			$next->next = null;
		}
	}

	public function removePrevious() {
		$previous = $this->previous;
		if (!is_null($previous)) {
			$previousPrevious = $previous->previous;
			$this->previous = $previousPrevious;
			if (!is_null($previousPrevious)) {
				$previousPrevious->next = $this;
			}
			$previous->previous = null;
			$previous->next = null;
		}
	}

	public function head() {
		$previous = $this;
		while (!is_null($previous->previous)) {
			$previous = $previous->previous;
		}
		return $previous;
	}

	public function tail() {
		$next = $this;
		while (!is_null($next->next)) {
			$next = $next->next;
		}
		return $next;
	}

	public function count() {
		$node = $this->head();
		$counter = 1;
		while (!is_null($node->next)) {
			$counter++;
			$node = $node->next;
		}
		return $counter;
	}

}