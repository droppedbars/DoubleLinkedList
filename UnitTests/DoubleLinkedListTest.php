<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 14-08-13
 * Time: 9:24 PM
 */

namespace droppedbars\datastructure;

require_once "../Structures/DoubleLinkedList.php";

class DoubleLinkedListTest extends \PHPUnit_Framework_TestCase {

	/**
	 * Creates a node, adds a payload and ensures the correct payload is returned
	 */
	public function testValue() {
		$testValue = "This is a Test Value";

		$node = new DoubleLinkedList($testValue);

		$this->assertTrue($testValue === $node->payload());
	}

	/**
	 * Adds a next nodes and tests that the count is correct
	 */
	public function testSimpleAddNext() {
		$node = new DoubleLinkedList("headNode");

		for ($i = 0; $i < 10; $i++) {
			$node->insertAfter("Node #".$i);
			$node = $node->tail();
		}
		$this->assertTrue($i+1 == $node->count());
	}

	/**
	 * Adds a previous nodes and tests that the count is correct
	 */
	public function testSimpleAddPrevious() {
		$node = new DoubleLinkedList("tailNode");

		for ($i = 0; $i < 10; $i++) {
			$node->insertBefore("Node #".$i);
			$node = $node->head();
		}
		$this->assertTrue($i+1 == $node->count());
	}

	/**
	 * Makes a list of 6 nodes with contents 0,1,2,3,4,5
	 * Then, starting at the head (0), removes alternating nodes, resulting in 0,2,4
	 * Tests the count.
	 */
	public function testSimpleRemoveNext() {
		$node = new DoubleLinkedList(0);

		$node = $node->insertAfter(1);
		$node = $node->insertAfter(2);
		$node = $node->insertAfter(3);
		$node = $node->insertAfter(4);
		$node = $node->insertAfter(5);

		$head = $node->head();

		$head->removeNext(); // 0 removes 1
		$node = $head->next(); // go to 2
		$node->removeNext(); // 2 removes 3
		$node = $node->next(); // go to 4
		$node->removeNext(); // 4 removes 5
		$node->removeNext(); // there should be no node to remove

		$node = $head;
		$this->assertTrue($node->payload() == 0);
		$node = $node->next();
		$this->assertTrue($node->payload() == 2);
		$node = $node->next();
		$this->assertTrue($node->payload() == 4);
		$node = $node->next();
		$this->assertNull($node);

		$this->assertEquals($head->count(), 3);
	}

	/**
	 * Makes a list of 6 nodes with contents 5,4,3,2,1,0
	 * Then, starting at the tail (0), removes alternating nodes, resulting in 4,2,0
	 * Tests the count.
	 */
	public function testSimpleRemovePrev() {
		$node = new DoubleLinkedList(0);

		$node = $node->insertBefore(1);
		$node = $node->insertBefore(2);
		$node = $node->insertBefore(3);
		$node = $node->insertBefore(4);
		$node = $node->insertBefore(5);

		$tail = $node->tail();

		$tail->removePrevious(); // 0 removes 1
		$node = $tail->previous(); // go to 2
		$node->removePrevious(); // 2 removes 3
		$node = $node->previous(); // go to 4
		$node->removePrevious(); // 4 removes 5
		$node->removePrevious(); // there should be no node to remove

		$node = $tail;
		$this->assertTrue($node->payload() == 0);
		$node = $node->previous();
		$this->assertTrue($node->payload() == 2);
		$node = $node->previous();
		$this->assertTrue($node->payload() == 4);
		$node = $node->previous();
		$this->assertNull($node);

		$this->assertEquals($tail->count(), 3);

	}

	/**
	 * Insert a bunch of previous nodes.  Verify the ordering be traversing in both directions and the count.
	 */
	public function testInsertPreviousAndCount() {
		$node = new DoubleLinkedList(0);

		$node = $node->insertBefore(1);
		$node = $node->insertBefore(2);
		$node = $node->insertBefore(3);
		$node = $node->insertBefore(4);
		$node = $node->insertBefore(5);

		$tail = $node->tail();

		$node = $tail;
		$this->assertTrue($node->payload() == 0);
		$node = $node->previous();
		$this->assertTrue($node->payload() == 1);
		$node = $node->previous();
		$this->assertTrue($node->payload() == 2);
		$node = $node->previous();
		$this->assertTrue($node->payload() == 3);
		$node = $node->previous();
		$this->assertTrue($node->payload() == 4);
		$node = $node->previous();
		$this->assertTrue($node->payload() == 5);
		$node = $node->previous();
		$this->assertNull($node);

		$this->assertEquals($tail->count(), 6);

		$node = $tail->head();
		$this->assertTrue($node->payload() == 5);
		$node = $node->next();
		$this->assertTrue($node->payload() == 4);
		$node = $node->next();
		$this->assertTrue($node->payload() == 3);
		$node = $node->next();
		$this->assertTrue($node->payload() == 2);
		$node = $node->next();
		$this->assertTrue($node->payload() == 1);
		$node = $node->next();
		$this->assertTrue($node->payload() == 0);
		$node = $node->next();
		$this->assertNull($node);

		$this->assertEquals($tail->count(), 6);

	}

	/**
	 * Insert a bunch of next nodes.  Verify the ordering be traversing in both directions and the count.
	 */
	public function testInsertAfterAndCount() {
		$node = new DoubleLinkedList(0);

		$node = $node->insertAfter(1);
		$node = $node->insertAfter(2);
		$node = $node->insertAfter(3);
		$node = $node->insertAfter(4);
		$node = $node->insertAfter(5);

		$head = $node->head();

		$node = $head;
		$this->assertTrue($node->payload() == 0);
		$node = $node->next();
		$this->assertTrue($node->payload() == 1);
		$node = $node->next();
		$this->assertTrue($node->payload() == 2);
		$node = $node->next();
		$this->assertTrue($node->payload() == 3);
		$node = $node->next();
		$this->assertTrue($node->payload() == 4);
		$node = $node->next();
		$this->assertTrue($node->payload() == 5);
		$node = $node->next();
		$this->assertNull($node);

		$this->assertEquals($head->count(), 6);

		$node = $head->tail();
		$this->assertTrue($node->payload() == 5);
		$node = $node->previous();
		$this->assertTrue($node->payload() == 4);
		$node = $node->previous();
		$this->assertTrue($node->payload() == 3);
		$node = $node->previous();
		$this->assertTrue($node->payload() == 2);
		$node = $node->previous();
		$this->assertTrue($node->payload() == 1);
		$node = $node->previous();
		$this->assertTrue($node->payload() == 0);
		$node = $node->previous();
		$this->assertNull($node);

		$this->assertEquals($head->count(), 6);

	}

}
 