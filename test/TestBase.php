<?php

namespace DoEveryAppTest\Test;

abstract class TestBase extends \PHPUnit\Framework\TestCase
{

    public function setUp(): void
    {
        defined('ROOT_DIR') || define('ROOT_DIR', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
        parent::setUp();
    }


    /**
     * @return array
     */
    public function __sleep()
    {
        return [];
    }


    protected function getEntityManager(): \Doctrine\ORM\EntityManager
    {
        return \DoEveryApp\Util\DependencyContainer::getInstance()->getEntityManager();
    }
}