<?php

namespace Dijkstra;

/*
 * @author: doug@neverfear.org
 */

class Edge
{
	public $start;
	public $end;
	public $weight;

	public function __construct($start, $end, $weight)
	{
		$this->start = $start;
		$this->end = $end;
		$this->weight = $weight;
	}
}