<?php

namespace Dijkstra;

/*
 * @author: doug@neverfear.org
 */

class Graph
{
	/**
	 * There is no path from start vertex to end vertex
	 *
	 * @var int
	 */
	const NO_PATH = -1;

	protected $nodes = array();
	protected $vertices = array();

	public function addEdge($start, $end, $weight = 0)
	{
		if (!in_array($start, $this->vertices)) {
			$this->vertices[] = $start;
		}
		if (!in_array($end, $this->vertices)) {
			$this->vertices[] = $end;
		}

		if (!isset($this->nodes[$start])) {
			$this->nodes[$start] = array();
		}
		array_push($this->nodes[$start], new Edge($start, $end, $weight));
	}

	public function getVertices()
	{
		return $this->vertices;
	}

	public function removeNode($index)
	{
		array_splice($this->nodes, $index, 1);
	}

	public function getPathsFrom($from) {
		$dist = array();
		$dist[$from] = 0;

		$visited = array();

		$previous = array();

		$queue = new PriorityQueue(array($this, 'compareWeights'));
		$queue->add(array($dist[$from], $from));

		$nodes = $this->nodes;

		while ($queue->size() > 0) {
			list($distance, $u) = $queue->popFirst();

			if (isset($visited[$u])) {
				continue;
			}
			$visited[$u] = true;

			if (!isset($nodes[$u])) {
				throw new \Exception(sprintf('Node "%s" is not found in the node list. There is NO EDGE FROM "%s" VERTEX', $u, $u));
			}

			foreach($nodes[$u] as $edge) {
				$alt = $dist[$u] + $edge->weight;
				$end = $edge->end;
				if (!isset($dist[$end]) || $alt < $dist[$end]) {
					$previous[$end] = $u;
					$dist[$end] = $alt;
					$queue->add(array($dist[$end], $end));
				}
			}
		}
		return array($dist, $previous);
	}

	public function getPathsTo($nodeDestinations, $toNode)
	{
		// unwind the previous nodes for the specific destination node
		$current = $toNode;
		$path = array();

		if (isset($nodeDestinations[$current])) { // only add if there is a path to node
			array_push($path, $toNode);
		}
		while (isset($nodeDestinations[$current])) {
			$nextnode = $nodeDestinations[$current];

			array_push($path, $nextnode);

			$current = $nextnode;
		}

		return array_reverse($path);
	}

	public function getPath($from, $to)
	{
		list($distances, $prev) = $this->getPathsFrom($from);
		return $this->getPathsTo($prev, $to);
	}

	public function getDistanceFromTo($from, $to)
	{
		list($distances, $prev) = $this->getPathsFrom($from);
		$path = $this->getPathsTo($prev, $to);

		if (!isset($distances[end($path)])) {
			return self::NO_PATH;
		}

		return $distances[end($path)];
	}

	public function compareWeights($a, $b)
	{
		return $a->data[0] - $b->data[0];
	}
}
