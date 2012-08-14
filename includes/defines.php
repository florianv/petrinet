<?php
/**
 * @package    Petrinet
 * @copyright  Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Define the path for the Joomla Platform.
if (!defined('JPATH_PLATFORM'))
{
	$platform = getenv('JPLATFORM_HOME');

	if ($platform)
	{
		define('JPATH_PLATFORM', realpath($platform));
	}

	else
	{
		define('JPATH_PLATFORM', realpath(__DIR__ . '/../platform/libraries'));
	}
}

define('JPATH_SITE', realpath(__DIR__ . '/../src'));
define('JPATH_BASE', realpath(__DIR__ . '/../www'));
define('JPATH_ROOT', realpath(__DIR__ . '/..'));