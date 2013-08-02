<?php

/*
 * @author: doug@neverfear.org
 */

require(__DIR__ . '/src/Dijkstra/Graph.php');
require(__DIR__ . '/src/Dijkstra/Edge.php');
require(__DIR__ . '/src/Dijkstra/QueueItem.php');
require(__DIR__ . '/src/Dijkstra/PriorityQueue.php');
// better use some autoloader

function runTest() {
	$g = new \Dijkstra\Graph();
	$g->addEdge("a", "b", 4);
	$g->addEdge("a", "d", 1);

	$g->addEdge("b", "a", 74);
	$g->addEdge("b", "a", 4);
	// $g->addEdge("b", "a", -4); // throws exception
	$g->addEdge("b", "c", 2);
	$g->addEdge("b", "e", 12);

	$g->addEdge("c", "b", 12);
	$g->addEdge("c", "j", 12);
	$g->addEdge("c", "f", 74);

	$g->addEdge("d", "g", 22);
	$g->addEdge("d", "e", 32);

	$g->addEdge("e", "h", 33);
	$g->addEdge("e", "d", 66);
	$g->addEdge("e", "f", 76);

	$g->addEdge("f", "j", 21);
	$g->addEdge("f", "i", 11);

	$g->addEdge("g", "c", 12);
	$g->addEdge("g", "h", 10);

	$g->addEdge("h", "g", 2);
	$g->addEdge("h", "i", 72);

	$g->addEdge("i", "j", 7);
	$g->addEdge("i", "f", 31);
	$g->addEdge("i", "h", 18);

	$g->addEdge("j", "f", 8);

	try {
		list($distances, $prev) = $g->getPathsFrom('a');

		$path = $g->getPathsTo($prev, 'i');

		print_r($distances);
		print_r($path);

		echo $g;

	} catch (\Exception $e) {
		printf('%s%s', $e->getMessage(), PHP_EOL);
	}
}

runTest();

