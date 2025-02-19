<?php

declare(strict_types=1);

namespace DoEveryAppTest\Util;


class TranslatorTest extends \DoEveryAppTest\TestBase
{

    protected function executeTranslation(\DoEveryApp\Util\Translator $translator, string $method, array $parameters = [])
    {
        if (0 === count($parameters)) {
            $translator->$method();
            return;
        }

        $randomParameters = [];
        foreach ($parameters as $name => $parameterType) {
            if (null === $parameterType) {
                $randomParameters[$name] = 'test';
                continue;
            }
            switch ($parameterType) {
                case 'string':
                {
                    $randomParameters[$name] = 'test string';
                    break;
                }
                case 'int':
                {
                    $randomParameters[$name] = 1337;
                    break;
                }
                case 'DateTime':
                {
                    $randomParameters[$name] = new \DateTime('2021-01-01 00:00:00');
                    break;
                }
                default:
                {
                    throw new \RuntimeException('Unknown parameter type "' . $parameterType . '" for mehtod "' . $method . '"');
                }
            }
        }
        call_user_func_array(array($translator, $method), $randomParameters);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('translationsTestDataProvider')]
    public function testNothingTranslations($method, $parameters)
    {
        $this->executeTranslation(new \DoEveryApp\Util\Translator\Nothing(), $method, $parameters);
        $this->assertTrue(condition: true);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('translationsTestDataProvider')]
    public function testGermanTranslations($method, $parameters)
    {
        $this->executeTranslation(new \DoEveryApp\Util\Translator\German(), $method, $parameters);
        $this->assertTrue(condition: true);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('translationsTestDataProvider')]
    public function testEnglishTranslations($method, $parameters)
    {
        $this->executeTranslation(new \DoEveryApp\Util\Translator\English(), $method, $parameters);
        $this->assertTrue(condition: true);
    }


    /**
     * Provides test data for translation methods by reflecting on public methods of the Translator class.
     *
     * @return array An array of method names along with their parameters and respective types, or null for untyped parameters.
     */
    public static function translationsTestDataProvider(): array
    {
        $methods = [];
        $reflection = new \ReflectionClass(objectOrClass: \DoEveryApp\Util\Translator::class);
        $reflectionMethods = $reflection->getMethods(filter: \ReflectionMethod::IS_PUBLIC);
        foreach ($reflectionMethods as $method) {
            $parameters = [];
            foreach ($method->getParameters() as $parameter) {
                $parameterType = $parameter->getType();
                $parameterName = $parameter->getName();
                if (null === $parameterType) {
                    $parameters[$parameterName] = null;
                    unset($parameterType);
                    continue;
                }
                switch (get_class($parameter->getType())) { #ReflectionNamedType|ReflectionUnionType|ReflectionIntersectionType

                    case \ReflectionNamedType::class:
                    {
                        /**
                         * @var \ReflectionNamedType $parameterType
                         */
                        $parameterTypeName = trim(' ' . $parameterType->getName() . ' ');
                        $parameters[$parameterName] = $parameterTypeName;
                        unset($parameterTypeName);

                        break;
                    }

                    case \ReflectionUnionType::class:
                    {
                        /**
                         * @var \ReflectionUnionType $parameter
                         */
                        throw new \RuntimeException('Union types are not supported');
                        break;
                    }

                    case \ReflectionIntersectionType::class:
                    {
                        /**
                         * @var \ReflectionIntersectionType $parameter
                         */
                        throw new \RuntimeException('Intersection types are not supported');
                    }
                    default:
                    {
                        throw new \RuntimeException('Unknown parameter type "' . get_class($parameter->getType()) . '" for mehtod "' . $method->getName() . '"');
                    }
                }
                unset($parameter);
                unset($parameterType);
            }
            $methods[] = [$method->getName(), $parameters];
            unset($method);
        }

        unset($reflection, $reflectionMethods);

        return $methods;
    }


    public function testGermanInstantiation(): void
    {
        $translator = new \DoEveryApp\Util\Translator\German();
        $this->assertInstanceOf(expected: \DoEveryApp\Util\Translator::class, actual: $translator);
        $this->assertInstanceOf(expected: \DoEveryApp\Util\Translator\German::class, actual: $translator);
        $this->assertSame(expected: 'Dashboard', actual: ($translator)->dashboard());
    }


    public function testEnglishInstantiation(): void
    {
        $translator = new \DoEveryApp\Util\Translator\English();
        $this->assertInstanceOf(expected: \DoEveryApp\Util\Translator::class, actual: $translator);
        $this->assertInstanceOf(expected: \DoEveryApp\Util\Translator\English::class, actual: $translator);
        $this->assertSame(expected: 'dashboard', actual: ($translator)->dashboard());
    }


    public function testNothingInstantiation(): void
    {
        $translator = new \DoEveryApp\Util\Translator\Nothing();
        $this->assertInstanceOf(expected: \DoEveryApp\Util\Translator::class, actual: $translator);
        $this->assertInstanceOf(expected: \DoEveryApp\Util\Translator\Nothing::class, actual: $translator);
        $this->assertSame(expected: 'dashboard()', actual: ($translator)->dashboard());
    }
}