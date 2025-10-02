<?php
defined(constant_name: 'STARTED') or define(constant_name: 'STARTED', value: microtime(as_float: true));
\DoEveryApp\Util\QueryLogger::$disabled = true;
require_once __DIR__ . DIRECTORY_SEPARATOR .'scripts' . DIRECTORY_SEPARATOR . 'bootstrap.php';


return \Doctrine\Migrations\DependencyFactory::fromConnection(
    configurationLoader: new \Doctrine\Migrations\Configuration\Migration\PhpFile(file:'migrations.php'),
    connectionLoader: new \Doctrine\Migrations\Configuration\Connection\ExistingConnection(connection: $entityManager->getConnection())
);