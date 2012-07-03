<?php
/**
 * Bootstrap file for the Joomla Platform.
 *
 * @package    Petrinet
 * @copyright  Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Allow the application to run as long as is necessary.
ini_set('max_execution_time', 0);

// Note, you would not use these settings in production.
error_reporting(E_ALL);
ini_set('display_errors', true);

// Import the platform(s).
require_once JPATH_PLATFORM . '/import.php';

// Make sure that the Joomla Platform has been successfully loaded.
if (!class_exists('JLoader'))
{
	exit('Joomla Platform not loaded.');
}

// Register the Application prefix.
JLoader::registerPrefix('Petrinet', JPATH_SITE);
