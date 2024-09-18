<?php

require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';
$dbParams = require \ROOT_DIR . \DIRECTORY_SEPARATOR . 'doctrineConfiguration.php';
$command  = 'mysql -u%s -p%s -P%s -h%s -e "create database if not exists %s"';

$command = sprintf($command, $dbParams['user'], $dbParams['password'], $dbParams['port'], $dbParams['host'], $dbParams['dbname']);

exec($command);