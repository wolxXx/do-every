<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';
$configuration              = require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'doctrineConfiguration.php';
$host                       = $configuration['host'];
$user                       = $configuration['user'];
$password                   = $configuration['password'];
$dbname                     = $configuration['dbname'];
$port                       = $configuration['port'];
$connection                 = new mysqli($host, $user, $password, $dbname, $port);
$result                     = $connection->query(<<<SQL
DROP SCHEMA IF EXISTS {$dbname}_test;
SQL
);
$result                     = $connection->query(<<<SQL
CREATE SCHEMA {$dbname}_test;
SQL
);
$createStructureDumpCommand = sprintf('mysqldump --column-statistics=0 -d -u%s -p%s -h%s -P%s %s | sed \'s/ AUTO_INCREMENT=[0-9]*//g\' > structure.dump', $user, $password, $host, $port, $dbname);
exec($createStructureDumpCommand);
$applyStructureDumpCommand = sprintf('mysql -u%s -p%s -h%s -P%s %s_test < structure.dump', $user, $password, $host, $port, $dbname);
exec($applyStructureDumpCommand);
#exec('php scripts/fixtures.php --test');