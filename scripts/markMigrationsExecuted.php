#!/usr/bin/env php
<?php
require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$application = new \Symfony\Component\Console\Application('markMigrationsExecuted', '1.0.0');
$application->addCommand(new class extends \Symfony\Component\Console\Command\Command
{
    protected function configure(): void
    {
        $this
            ->setName('markMigrationsExecuted')
            ->setDescription('markMigrationsExecuted')
            ->setHelp('markMigrationsExecuted')
        ;
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output): int
    {
        $entityManager   = \DoEveryApp\Util\DependencyContainer::getInstance()->getEntityManager();
        $connection      = $entityManager->getConnection();
        $createStatement = <<<SQL
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` VARCHAR(191)  NOT NULL PRIMARY KEY ,
  `executed_at` DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  execution_time int          null
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
SQL;
        
        $query           = $connection->prepare($createStatement);
        $query->executeQuery();
        $directoryIterator = new \RecursiveDirectoryIterator(ROOT_DIR . DIRECTORY_SEPARATOR . 'migrations');
        $iterator          = new \RecursiveIteratorIterator($directoryIterator);
        $regexIterator     = new \RegexIterator($iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);
        $query             = $connection->prepare('SELECT * FROM doctrine_migration_versions');
        $result = $query->executeQuery();
        $existing = [];
        foreach ($result->fetchAllAssociative() as $item) {
            $existing[] = $item['version'];
        }
        foreach ($regexIterator as $current) {
            $file = $current[0];
            $file = realpath($file);
            $file = basename($file);
            $file = str_replace('Version', 'DoctrineMigrations\\Version', $file);
            $file = str_replace('.php', '', $file);
            if (true === in_array($file, $existing)) {
                continue;
            }
            $sql   = <<<SQL
INSERT INTO 
doctrine_migration_versions 
  (version, executed_at, execution_time) 
VALUES
  (:version, :executed, 100)
;   
SQL;
            $query = $connection->prepare($sql);
            $query->bindValue('version', $file);
            $now = new \DateTime()->format('Y-m-d H:i:s');
            $query->bindValue('executed', $now);
            $query->executeQuery();
        }
        return 0;
    }
});
$application->setDefaultCommand('markMigrationsExecuted', true);
$application->run();