<?php
define(constant_name: 'STARTED', value: microtime(as_float: true));
chdir(directory: dirname(path: __DIR__));
defined(constant_name: 'ROOT_DIR') || define(constant_name: 'ROOT_DIR', value: getcwd());
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'doctrineBootstrap.php';
\DoEveryApp\Util\QueryLogger::$disabled = true;