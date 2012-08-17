<?php
/**
 * @package     Petrinet
 * @subpackage  Visitor
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * A visitor generating a graphviz .dot file for visualizing a Petri Net.
 *
 * @package     Petrinet
 * @subpackage  Visitor
 * @see         http://www.graphviz.org/pdf/dotguide.pdf
 * @since       1.0
 */
class PNVisitorViewer extends PNVisitorGrabber
{
	/**
	 * @var    string  The Petri Net name.
	 * @since  1.0
	 */
	protected $name;

	/**
	 * @var    string  The formatted graph.
	 * @since  1.0
	 */
	protected $graph;

	/**
	 * Perform the visit of a Petri Net.
	 *
	 * @param   PNPetrinet  $net  The Petri net.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function visitPetrinet(PNPetrinet $net)
	{
		$this->name = $net->getName();
	}

	/**
	 * Generate the content of a GraphViz file.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function generateGraph()
	{
		$graph = 'digraph ' . $this->name . ' {';

		// Declaring the nodes (places).
		foreach ($this->places as $key => $place)
		{
			$tokens = $place->getTokenCount();

			$graph .= 'p' . $key . ' [label="p' . $key . ': ' . $tokens;

			$tokens > 1 ? $graph .= ' tokens"];' : $graph .= ' token"];';
		}

		// Declaring the nodes (Transitions).
		foreach ($this->transitions as $key => $transition)
		{
			$graph .= 't' . $key . '[shape=box];';
		}

		// Declaring the edges.
		foreach ($this->arcs as $arc)
		{
			$input = $arc->getInput();

			if ($input instanceof PNPlace)
			{
				$key = array_search($input, $this->places, true);
				$input = 'p' . $key;
			}

			else
			{
				$key = array_search($input, $this->transitions, true);
				$input = 't' . $key;
			}

			$output = $arc->getOutput();

			if ($output instanceof PNPlace)
			{
				$key = array_search($output, $this->places, true);
				$output = 'p' . $key;
			}

			else
			{
				$key = array_search($output, $this->transitions, true);
				$output = 't' . $key;
			}

			$graph .= $input . '->' . $output . ';';
		}

		$graph .= '}';

		$this->graph = $graph;
	}

	/**
	 * Check if a graph has been already generated.
	 *
	 * @return  boolean  True if already generated, false otherwise.
	 *
	 * @since   1.0
	 */
	protected function hasGraph()
	{
		return $this->graph ? true : false;
	}

	/**
	 * Displays the content of a graphviz .dot file.
	 *
	 * @return  string  The file content.
	 *
	 * @since   1.0
	 */
	public function __toString()
	{
		if (!$this->hasGraph())
		{
			$this->generateGraph();
		}

		return $this->graph;
	}

	/**
	 * Write the content into a .dot file.
	 *
	 * @param   string  $filename  The path including file name to create the file.
	 *
	 * @return  boolean  True if sucessful created, false otherwise.
	 *
	 * @since   1.0
	 */
	public function toFile($filename)
	{
		if (!$this->hasGraph())
		{
			$this->generateGraph();
		}

		return is_int(file_put_contents($filename . '.dot', $this->graph)) ? true : false;
	}
}
