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

	}

	public function testRemovingChild() {

	}

	public function testHeadChild() {

	}

	public function testTailChild() {

	}

	public function testIteratingChildren() {

	}

}
 