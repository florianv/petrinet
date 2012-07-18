<?php

define('_JEXEC', 1);

// Fix magic quotes.
@ini_set('magic_quotes_runtime', 0);

// Maximise error reporting.
error_reporting(E_ALL & ~E_STRICT);
ini_set('display_errors', 1);

require_once dirname(__FILE__) . '/../includes/defines.php';
require_once JPATH_ROOT . '/includes/bootstrap.php';

// Register the core Joomla test classes.
JLoader::registerPrefix('Test', JPATH_PLATFORM . '/../tests/core');
