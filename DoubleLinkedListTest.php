<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 14-08-13
 * Time: 9:24 PM
 */

namespace droppedbars\datastructure;

require_once "./DoubleLinkedList.php";

class DoubleLinkedListTest extends \PHPUnit_Framework_TestCase {

	public function testValue() {
		$testValue = "This is a Test Value";

		$node = new DoubleLinkedList($testValue);

		$this->assertTrue($testValue === $node->payload());
	}

	public function testAddingNext() {
		$node = new DoubleLinkedList("headNode");

		for ($i = 0; $i < 10; $i++) {
			$node->insertAfter("Node #".$i);
			$node = $node->tail();
		}
		$this->assertTrue($i+1 == $node->count());
	}

}
 