<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class DependencyContainer
{
    protected static DependencyContainer $instance;

    protected \DI\Container              $container;


    final private function __construct()
    {
        $this
            ->setContainer(
                (new \DI\ContainerBuilder())
                    ->useAutowiring(false)
                    ->useAttributes(false)
                    ->build()
            )
        ;
    }


    public static function getInstance(): static
    {
        if (false === isset(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }


    private function setContainer(\DI\Container $container): static
    {
        $this->container = $container;

        return $this;
    }


    public function getContainer(): \DI\Container
    {
        return $this->container;
    }


    public function getEntityManager(): \Doctrine\ORM\EntityManager
    {
        /**
         * defined in doctrineBootstrap
         *
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        if (true === $this->getContainer()->has(\Doctrine\ORM\EntityManager::class)) {
            return $this->getContainer()->get(\Doctrine\ORM\EntityManager::class);
        }
        require ROOT_DIR . DIRECTORY_SEPARATOR . 'doctrineBootstrap.php';
        $this->getContainer()->set(\Doctrine\ORM\EntityManager::class, $entityManager);

        return $this->getEntityManager();
    }


    public function getRenderer(): \Slim\Views\PhpRenderer
    {
        return (new \Slim\Views\PhpRenderer(\ROOT_DIR . DIRECTORY_SEPARATOR . 'src' . \DIRECTORY_SEPARATOR . 'views', [], 'layout/main.php'));
    }

    public function getLogger(): \Monolog\Logger
    {
        if (true === $this->getContainer()->has(\Monolog\Logger::class)) {
            return $this->getContainer()->get(\Monolog\Logger::class);
        }
        $logger = (new \Monolog\Logger('logger'))
            ->pushHandler(new \Monolog\Handler\StreamHandler(ROOT_DIR . DIRECTORY_SEPARATOR . 'app.log', \Monolog\Level::Debug))
        ;
        $this->getContainer()->set(\Monolog\Logger::class, $logger);

        return $this->getLogger();
    }


    public function getTranslator(): Translator
    {
        return match (\DoEveryApp\Util\User\Current::getLanguage()) {
            Translator::LANGUAGE_GERMAN => new \DoEveryApp\Util\Translator\German(),
            Translator::LANGUAGE_ENGLISH => new \DoEveryApp\Util\Translator\English(),
            Translator::LANGUAGE_MAORI => new \DoEveryApp\Util\Translator\Nothing(),
        };
    }


    public function getValidator(): \Symfony\Component\Validator\Validator\RecursiveValidator
    {
        return new \Symfony\Component\Validator\Validator\RecursiveValidator(
            new \Symfony\Component\Validator\Context\ExecutionContextFactory(
                new class implements \Symfony\Contracts\Translation\TranslatorInterface {

                    public function trans(string $id, array $parameters = [], ?string $domain = null, ?string $locale = null): string
                    {
                        return DependencyContainer::getInstance()
                                                  ->getTranslator()
                                                  ->translate($id, $parameters, $domain, $locale)
                        ;
                    }


                    public function getLocale(): string
                    {
                        return \DoEveryApp\Util\User\Current::getLanguage();
                    }
                }
            ),
            new \Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory(new \Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader()),
            new \Symfony\Component\Validator\ConstraintValidatorFactory(),
        );
    }
}
