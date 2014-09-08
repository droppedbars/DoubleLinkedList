<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 14-09-05
 * Time: 10:57 PM
 */

namespace droppedbars\datastructure;

require_once "../Structures/LinkedTree.php";


class LinkedTreeTest extends \PHPUnit_Framework_TestCase {

	public function testPayload() {
		$testValue = "test tree";
		$node = new LinkedTree($testValue);
		$this->assertTrue($testValue === $node->payload());
	}

	public function testChildPayload() {
		$parentNode = new LinkedTree("some parent");

		$testValue = "test tree";
		$childNode = new LinkedTree($testValue);
		$parentNode->addChild($childNode);
		$this->assertTrue($testValue === $parentNode->getChild()->payload());
	}

	public function testAddingChildren() {
		$parentNode = new LinkedTree("the parent");

		$child1 = new LinkedTree("child 1");
		$child2 = new LinkedTree("child 2");
		$child3 = new LinkedTree("child 3");
		$child4 = new LinkedTree("child 4");
		$child5 = new LinkedTree("child 5");

		$parentNode->addChild($child1);
		$parentNode->addChild($child2);
		$parentNode->addChild($child3);
		$parentNode->addChild($child4);
		$parentNode->addChild($child5);

		$parentNode->headChild();
		$this->assertTrue($parentNode->getChild() === $child1);
		$parentNode->nextChild();
		$this->assertTrue($parentNode->getChild() === $child2);
		$parentNode->nextChild();
		$this->assertTrue($parentNode->getChild() === $child3);
		$parentNode->nextChild();
		$this->assertTrue($parentNode->getChild() === $child4);
		$parentNode->nextChild();
		$this->assertTrue($parentNode->getChild() === $child5);
		$parentNode->nextChild();
		$this->assertNull($parentNode->getChild());
	}

	public function testRemovingChild() {
		$parentNode = new LinkedTree("the parent");

		$child1 = new LinkedTree("child 1");
		$child2 = new LinkedTree("child 2");
		$child3 = new LinkedTree("child 3");
		$child4 = new LinkedTree("child 4");
		$child5 = new LinkedTree("child 5");

		$parentNode->addChild($child1);
		$parentNode->addChild($child2);
		$parentNode->addChild($child3);
		$parentNode->addChild($child4);
		$parentNode->addChild($child5);

		$parentNode->removeChild(); // remove child 1;
		$this->assertTrue($parentNode->headChild() === $child2);

		$parentNode->tailChild();
		$parentNode->removeChild(); // remove child 5;
		$this->assertTrue($parentNode->tailChild() === $child4);

		$parentNode->previousChild();
		$parentNode->removeChild(); // remove child 3;

		$parentNode->headChild();
		$this->assertTrue($parentNode->getChild() === $child2);
		$parentNode->nextChild();
		$this->assertTrue($parentNode->getChild() === $child4);
		$parentNode->nextChild();
		$this->assertNull($parentNode->getChild());

		$parentNode->removeChild(); // shouldn't delete anything
		$parentNode->headChild();
		$this->assertTrue($parentNode->getChild() === $child2);
		$parentNode->nextChild();
		$this->assertTrue($parentNode->getChild() === $child4);

		$parentNode->headChild();
		$parentNode->removeChild();
		$this->assertTrue($parentNode->getChild() === $child4);
		$parentNode->removeChild();
		$this->assertNull($parentNode->getChild());
		$parentNode->removeChild();
		$this->assertNull($parentNode->getChild());
	}

	public function testHeadChild() {
		$parentNode = new LinkedTree("the parent");

		$this->assertNull($parentNode->headChild());

		$firstChildNode = new LinkedTree("the first child");
		$parentNode->addChild($firstChildNode);

		$headNode = $parentNode->headChild();
		$this->assertTrue($headNode === $firstChildNode);

		for ($i = 0; $i < 5; $i++) {
			$newNode = new LinkedTree("wombat".$i);
			$parentNode->addChild($newNode);
		}

		$this->assertTrue($headNode === $parentNode->headChild());
	}

	public function testTailChild() {
		$parentNode = new LinkedTree("the parent");

		$this->assertNull($parentNode->tailChild());

		$firstChildNode = new LinkedTree("the first child");
		$parentNode->addChild($firstChildNode);

		$tailNode = $parentNode->tailChild();
		$this->assertTrue($tailNode === $firstChildNode);

		for ($i = 0; $i < 5; $i++) {
			$newNode = new LinkedTree("wombat".$i);
			$parentNode->addChild($newNode);
			$this->assertTrue($newNode === $parentNode->tailChild());
		}
	}

	public function testIteratingChildren() {
		$grandParentNode = new LinkedTree("the grandparent");

		$parentArray = Array();
		$childArray = Array();

		for ($i=0; $i<5; $i++) {
			$parent = new LinkedTree("parent ".$i);
			$parentArray[$i] = $parent;
			$grandParentNode->addChild($parent);

			for ($j=0; $j<5; $j++) {
				$child = new LinkedTree("child of ".$i.":".$j);
				$childArray[$i][$j] = $child;
				$parent->addChild($child);
			}
		}

		// walk around the parent level, hitting both head and tail
		$this->assertTrue($grandParentNode->getChild() === $parentArray[0]);

		$this->assertTrue($grandParentNode->nextChild() === $parentArray[1]);
		$this->assertTrue($grandParentNode->getChild() === $parentArray[1]);

		$this->assertTrue($grandParentNode->nextChild() === $parentArray[2]);
		$this->assertTrue($grandParentNode->getChild() === $parentArray[2]);

		$this->assertTrue($grandParentNode->nextChild() === $parentArray[3]);
		$this->assertTrue($grandParentNode->getChild() === $parentArray[3]);

		$this->assertTrue($grandParentNode->tailChild() === $parentArray[4]);
		$this->assertTrue($grandParentNode->getChild() === $parentArray[4]);

		$this->assertNull($grandParentNode->nextChild());
		$this->assertNull($grandParentNode->getChild());

		$this->assertNull($grandParentNode->nextChild());
		$this->assertNull($grandParentNode->getChild());

		$this->assertTrue($grandParentNode->headChild() === $parentArray[0]);
		$this->assertTrue($grandParentNode->getChild() === $parentArray[0]);

		$this->assertTrue($grandParentNode->nextChild() === $parentArray[1]);
		$this->assertTrue($grandParentNode->getChild() === $parentArray[1]);

		$this->assertTrue($grandParentNode->previousChild() === $parentArray[0]);
		$this->assertTrue($grandParentNode->getChild() === $parentArray[0]);

		$this->assertNull($grandParentNode->previousChild());
		$this->assertNull($grandParentNode->getChild());

		$this->assertNull($grandParentNode->previousChild());
		$this->assertNull($grandParentNode->getChild());

		// walk around the grandchildren

		// delete some grandchildren and walk

		// delete some parents and walk

		// add some parents back and walk

		// add some grandchildren back and walk
	}

}
 