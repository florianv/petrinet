<?php
/**
 * @package    Petrinet
 * @copyright  Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

define('_JEXEC', 1);

require_once dirname(__FILE__) . '/../includes/defines.php';
require_once JPATH_ROOT . '/includes/bootstrap.php';

// Example
// Create a petri net named "test".
/*$net = PNElementPetrinet::getInstance('test');

// Create the places

// Create the start place and add two tokens in it.
$start = $net->createPlace()->addToken(new stdClass)->addToken(new stdClass);

// Create the other places.
$node1 = $net->createPlace();
$node2 = $net->createPlace();
$stop = $net->createPlace();

// Create two Transitions.
$split = $net->createTransition();
$merge = $net->createTransition();

// Connect the graph.
$net->connect($start, $split);

$net->connect($split, $node1);
$net->connect($split, $node2);

$net->connect($node1, $merge);
$net->connect($node2, $merge);

$net->connect($merge, $stop);

// Get an engine instance
$engine = PNEngine::getInstance();

// Pass the Petri net object to the engine
$engine->setNet($net);

// Start the execution : here all transitions are fired until the end (there is no waiting state)
$engine->start();

// The engine has ended state.
var_dump($engine->getState());

// One token has been produced in the stop place and the other places are empty.
var_dump($stop->getTokenCount());*/
