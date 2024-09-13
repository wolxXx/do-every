<?php

namespace DoEveryAppTest;

abstract class TestBase extends \PHPUnit\Framework\TestCase
{

    public function setUp(): void
    {
        defined('ROOT_DIR') || define('ROOT_DIR', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
        parent::setUp();
    }


    public function __sleep(): array
    {
        return [];
    }

}