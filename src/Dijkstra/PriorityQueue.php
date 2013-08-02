<?php

namespace Dijkstra;

/*
 * @author: doug@neverfear.org
 */

class PriorityQueue
{
	private $size;
	private $liststart;
	private $comparator;

	public function __construct($comparator)
	{
		$this->size = 0;
		$this->liststart = null;
		$this->listend = null;
		$this->comparator = $comparator;
	}

	public function add(array $x)
	{
		$this->size = $this->size + 1;

		if ($this->liststart === null) {
			$this->liststart = new QueueItem($x);
		} else {
			$node = $this->liststart;
			$comparator = $this->comparator;
			$newnode = new QueueItem($x);
			$lastnode = null;
			$added = false;
			while ($node) {
                if (call_user_func($comparator, $newnode, $node) < 0) {
					// newnode has higher priority
					$newnode->next = $node;
					if ($lastnode == null) {
						//print "last node is null\n";
						$this->liststart = $newnode;
					} else {
						//print "Debug: " . $newnode->data . " has lower priority than " . $lastnode->data . "\n";
						$lastnode->next = $newnode;
					}
					$added = true;
					break;
				}
				$lastnode = $node;
				$node = $node->next;
			}
			if (!$added) {
				// Lowest priority - add to the very end
				$lastnode->next = $newnode;
			}
		}
		//print "Debug: Appended node. New size=" . $this->size . "\n";
		//$this->debug();
	}

	public function debug()
	{
		$node = $this->liststart;
		$i = 0;
		if (!$node) {
			print "<< No nodes >>\n";
			return;
		}
		while ($node) {
			print "[$i]=" . $node->data[1] . " (" . $node->data[0] . ")\n";
			$node = $node->next;
			$i++;
		}
	}

	public function size()
	{
		return $this->size;
	}

	public function peak()
	{
		return $this->liststart->data;
	}

	public function popFirst()
	{
		$firstElementData = $this->peak();
		$this->size = $this->size - 1;
		$this->liststart = $this->liststart->next;
		//print "Debug: Removed node. New size=" . $this->size . "\n";
		//$this->debug();
		return $firstElementData;
	}
}
