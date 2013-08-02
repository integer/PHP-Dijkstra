<?php

namespace Dijkstra;

/*
 * @author: doug@neverfear.org
 */

class QueueItem
{
	public $next;
	public $data;

	function __construct(array $data) {
		$this->next = null;
		$this->data = $data;
	}
}
