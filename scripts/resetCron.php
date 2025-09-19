<?php
defined(constant_name: 'DISABLE_DOCTRINE_TOOLS') || define(constant_name: 'DISABLE_DOCTRINE_TOOLS', value: true);
require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

\DoEveryApp\Util\Registry::getInstance()
    ->setCronRunning(cronRunning: false)
    ->setNotifierRunning(notifierRunning: false)
;
