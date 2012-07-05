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
$net = PNElementPetrinet::getInstance('test');

$start = $net->createPlace()->addToken(new stdClass)->addToken(new stdClass);
$stop = $net->createPlace();
$node1 = $net->createPlace();
$node2 = $net->createPlace();

$split = $net->createTransition();
$merge = $net->createTransition();

$net->connect($start, $split);
$net->connect($split, $node1);
$net->connect($split, $node2);
$net->connect($node1, $merge);
$net->connect($node2, $merge);
$net->connect($merge, $stop);

// Get an engine instance
$engine = PNEngine::getInstance();
$engine->setNet($net);

// Start the execution.
$engine->start();

// The engine has ended state.
var_dump($engine->getState());

// there is one token in the stop place (the two transitions are correctly fired)
var_dump($stop->getTokenCount());
