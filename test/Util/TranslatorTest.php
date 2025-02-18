<?php

declare(strict_types=1);

namespace DoEveryAppTest\Util;


class TranslatorTest extends \DoEveryAppTest\TestBase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('translationsTestDataProvider')]
    public function testNothingTranslations($method, $parameters)
    {
        if (0 === \count(value: $parameters)) {
            (new \DoEveryApp\Util\Translator\Nothing())->{$method}();
        }
        if (0 !== \count(value: $parameters)) {
            (new \DoEveryApp\Util\Translator\Nothing())->{$method}(rand(min: 0,max: 1000));
        }
        $this->assertTrue(condition: true);
    }
    #[\PHPUnit\Framework\Attributes\DataProvider('translationsTestDataProvider')]
    public function testGermanTranslations($method, $parameters)
    {
        if (0 === \count(value: $parameters)) {
            (new \DoEveryApp\Util\Translator\German())->{$method}();
        }
        if (0 !== \count(value: $parameters)) {
            (new \DoEveryApp\Util\Translator\German())->{$method}(rand(min: 0,max: 1000));
        }
        $this->assertTrue(condition: true);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('translationsTestDataProvider')]
    public function testEnglishTranslations($method, $parameters)
    {
        if (0 === \count(value: $parameters)) {
            (new \DoEveryApp\Util\Translator\English())->{$method}();
        }
        if (0 !== \count(value: $parameters)) {
            (new \DoEveryApp\Util\Translator\English())->{$method}(rand(min: 0,max: 1000));
        }
        $this->assertTrue(condition: true);
    }


    public static function translationsTestDataProvider()
    {
        $methods           = [];
        $reflection        = new \ReflectionClass(objectOrClass: \DoEveryApp\Util\Translator::class);
        $reflectionMethods = $reflection->getMethods(filter: \ReflectionMethod::IS_PUBLIC);
        foreach ($reflectionMethods as $method) {
            $parameters = [];
            foreach ($method->getParameters() as $parameter) {
                $parameters[$parameter->getName()] = $parameter->getType();
            }
            $methods[] = [$method->getName(), $parameters];
        }

        return $methods;
    }


    public function testGermanInstantiation()
    {
        $translator = new \DoEveryApp\Util\Translator\German();
        $this->assertInstanceOf(expected: \DoEveryApp\Util\Translator::class, actual: $translator);
        $this->assertInstanceOf(expected: \DoEveryApp\Util\Translator\German::class, actual: $translator);
        $this->assertSame(expected: 'Dashboard', actual: ($translator)->dashboard());
    }


    public function testEnglishInstantiation()
    {
        $translator = new \DoEveryApp\Util\Translator\English();
        $this->assertInstanceOf(expected: \DoEveryApp\Util\Translator::class, actual: $translator);
        $this->assertInstanceOf(expected: \DoEveryApp\Util\Translator\English::class, actual: $translator);
        $this->assertSame(expected: 'dashboard', actual: ($translator)->dashboard());
    }


    public function testNothingInstantiation()
    {
        $translator = new \DoEveryApp\Util\Translator\Nothing();
        $this->assertInstanceOf(expected: \DoEveryApp\Util\Translator::class, actual: $translator);
        $this->assertInstanceOf(expected: \DoEveryApp\Util\Translator\Nothing::class, actual: $translator);
        $this->assertSame(expected: 'dashboard()', actual: ($translator)->dashboard());
    }
}