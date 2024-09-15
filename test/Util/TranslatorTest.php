<?php

declare(strict_types=1);

namespace DoEveryAppTest\Util;


class TranslatorTest extends \DoEveryAppTest\TestBase
{
    public function testGermanInstantiation()
    {
        $translator = new \DoEveryApp\Util\Translator\German();
        $this->assertInstanceOf(\DoEveryApp\Util\Translator::class, $translator);
        $this->assertInstanceOf(\DoEveryApp\Util\Translator\German::class, $translator);
        $this->assertSame('Dashboard', ($translator)->dashboard());
        $reflection = new \ReflectionClass($translator);
        foreach ($reflection->getMethods() as $method) {
            $translator->{$method->getName()}();
        }
    }


    public function testEnglishInstantiation()
    {
        $translator = new \DoEveryApp\Util\Translator\English();
        $this->assertInstanceOf(\DoEveryApp\Util\Translator::class, $translator);
        $this->assertInstanceOf(\DoEveryApp\Util\Translator\English::class, $translator);
        $this->assertSame('dashboard', ($translator)->dashboard());
        $reflection = new \ReflectionClass($translator);
        foreach ($reflection->getMethods() as $method) {
            $translator->{$method->getName()}();
        }
    }
}