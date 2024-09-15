<?php
$dbName = 'do_every';
if (true === defined('IS_IN_TEST_ENV') && true === IS_IN_TEST_ENV) {
    $dbName .= '_test';
}

defined('DISABLE_DOCTRINE_TOOLS') || define('DISABLE_DOCTRINE_TOOLS', false);

return [
    'table_prefix'  => 'do_every_',
    'driver'        => 'pdo_mysql',
    'user'          => 'root',
    'host'          => 'mysql',
    'password'      => 'root',
    'dbname'        => $dbName,
    'port'          => '3306',
    'charset'       => 'utf8',
    'driverOptions' => [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    ],
];