<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$config = \Doctrine\ORM\ORMSetup::createAttributeMetadataConfiguration(
    paths    : [__DIR__ . "/src/Entity"],
    isDevMode: true,
);
$config->addCustomStringFunction('MATCH', \DoctrineExtensions\Query\Mysql\MatchAgainst::class);

$dbParams   = require __DIR__ . DIRECTORY_SEPARATOR . 'doctrineConfiguration.php';
$connection = \Doctrine\DBAL\DriverManager::getConnection($dbParams, $config);

$eventManager = new \Doctrine\Common\EventManager();
$eventManager->addEventListener(
    \Doctrine\ORM\Events::loadClassMetadata, new class {
    public function loadClassMetadata(\Doctrine\ORM\Event\LoadClassMetadataEventArgs $eventArgs)
    {
        $dbParams      = require __DIR__ . DIRECTORY_SEPARATOR . 'doctrineConfiguration.php';
        $prefix        = $dbParams['table_prefix'];
        $classMetadata = $eventArgs->getClassMetadata();

        if (!$classMetadata->isInheritanceTypeSingleTable() || $classMetadata->getName() === $classMetadata->rootEntityName) {
            $classMetadata->setPrimaryTable([
                                                'name' => $prefix . $classMetadata->getTableName(),
                                            ]);
        }

        foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
            if ($mapping['type'] == \Doctrine\ORM\Mapping\ClassMetadata::MANY_TO_MANY && $mapping['isOwningSide']) {
                $mappedTableName                                                     = $mapping['joinTable']['name'];
                $classMetadata->associationMappings[$fieldName]['joinTable']['name'] = $prefix . $mappedTableName;
            }
        }
    }
}
);

// getting the entity manager
$entityManager = new \Doctrine\ORM\EntityManager($connection, $config, $eventManager);
$entityManager->getEventManager()->addEventSubscriber(new \Gedmo\Timestampable\TimestampableListener());
$entityManager->getEventManager()->addEventSubscriber(new \Gedmo\Blameable\BlameableListener());

return $entityManager;