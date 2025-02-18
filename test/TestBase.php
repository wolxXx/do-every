<?php

namespace DoEveryAppTest;

abstract class TestBase extends \PHPUnit\Framework\TestCase
{

    public function setUp(): void
    {
        defined(constant_name: 'ROOT_DIR') || define(constant_name: 'ROOT_DIR', value: __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
        parent::setUp();
    }


    public function __sleep(): array
    {
        return [];
    }

}