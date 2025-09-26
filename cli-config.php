<?php
defined('STARTED') or define(constant_name: 'STARTED', value: microtime(as_float: true));
\DoEveryApp\Util\QueryLogger::$disabled = true;
require_once __DIR__ . DIRECTORY_SEPARATOR .'scripts' . DIRECTORY_SEPARATOR . 'bootstrap.php';



$config = new \Doctrine\Migrations\Configuration\Migration\PhpFile('migrations.php'); // Or use one of the Doctrine\Migrations\Configuration\Configuration\* loaders
$conn = \Doctrine\DBAL\DriverManager::getConnection(['driver' => 'pdo_sqlite', 'memory' => true]);
return \Doctrine\Migrations\DependencyFactory::fromConnection($config, new \Doctrine\Migrations\Configuration\Connection\ExistingConnection($entityManager->getConnection()));

return \Doctrine\Migrations\DependencyFactory::fromEntityManager($entityManager);

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createApplication(new \Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider(entityManager: $entityManager));