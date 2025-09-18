<?php
$dbName = 'do_every';
if (true === defined(constant_name: 'IS_IN_TEST_ENV') && true === IS_IN_TEST_ENV) {
    $dbName .= '_test';
}

return [
    'table_prefix'  => 'do_every_',
    'driver'        => 'pdo_mysql',
    'user'          => 'root',
    'host'          => 'localhost',
    'password'      => 'root',
    'dbname'        => $dbName,
    'port'          => '3306',
    'charset'       => 'utf8',
    'driverOptions' => [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    ],
];