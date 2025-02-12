<?php
define('STARTED', microtime(true));
chdir(dirname(__DIR__));
defined('ROOT_DIR') || define('ROOT_DIR', getcwd());
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'doctrineBootstrap.php';
\DoEveryApp\Util\QueryLogger::$disabled = true;