<?php

declare(strict_types=1);

namespace DoEveryAppTest\Util;


class TranslatorTest extends \DoEveryAppTest\TestBase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('translationsTestDataProvider')]
    public function testNothingTranslations($method)
    {
        (new \DoEveryApp\Util\Translator\Nothing())->{$method}();
        $this->assertTrue(true);
    }
    #[\PHPUnit\Framework\Attributes\DataProvider('translationsTestDataProvider')]
    public function testGermanTranslations($method)
    {
        (new \DoEveryApp\Util\Translator\German())->{$method}();
        $this->assertTrue(true);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('translationsTestDataProvider')]
    public function testEnglishTranslations($method)
    {
        (new \DoEveryApp\Util\Translator\English())->{$method}();
        $this->assertTrue(true);
    }


    public static function translationsTestDataProvider()
    {
        $methods           = [];
        $reflection        = new \ReflectionClass(\DoEveryApp\Util\Translator::class);
        $reflectionMethods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        foreach ($reflectionMethods as $method) {
            $methods[] = [$method->getName()];
        }

        return $methods;
    }


    public function testGermanInstantiation()
    {
        $translator = new \DoEveryApp\Util\Translator\German();
        $this->assertInstanceOf(\DoEveryApp\Util\Translator::class, $translator);
        $this->assertInstanceOf(\DoEveryApp\Util\Translator\German::class, $translator);
        $this->assertSame('Dashboard', ($translator)->dashboard());
    }


    public function testEnglishInstantiation()
    {
        $translator = new \DoEveryApp\Util\Translator\English();
        $this->assertInstanceOf(\DoEveryApp\Util\Translator::class, $translator);
        $this->assertInstanceOf(\DoEveryApp\Util\Translator\English::class, $translator);
        $this->assertSame('dashboard', ($translator)->dashboard());
    }


    public function testNothingInstantiation()
    {
        $translator = new \DoEveryApp\Util\Translator\Nothing();
        $this->assertInstanceOf(\DoEveryApp\Util\Translator::class, $translator);
        $this->assertInstanceOf(\DoEveryApp\Util\Translator\Nothing::class, $translator);
        $this->assertSame('..', ($translator)->dashboard());
    }
}