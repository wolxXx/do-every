<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class DependencyContainer
{
    protected static DependencyContainer $instance;

    protected \DI\Container $container {
        get {
            return $this->container;
        }
    }

    final private function __construct()
    {
        $this
            ->setContainer(
                container: new \DI\ContainerBuilder()
                    ->useAutowiring(bool: false)
                    ->useAttributes(bool: false)
                    ->build()
            );
    }

    private function setContainer(\DI\Container $container): static
    {
        $this->container = $container;

        return $this;
    }

    public function getEntityManager(): \Doctrine\ORM\EntityManager
    {
        /**
         * defined in doctrineBootstrap
         *
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        if (true === $this->container->has(id: \Doctrine\ORM\EntityManager::class)) {
            return $this->container->get(id: \Doctrine\ORM\EntityManager::class);
        }
        require ROOT_DIR . DIRECTORY_SEPARATOR . 'doctrineBootstrap.php';
        $this->container->set(name: \Doctrine\ORM\EntityManager::class, value: $entityManager);

        return $this->getEntityManager();
    }

    public function getRenderer(): \Slim\Views\PhpRenderer
    {
        return (new \Slim\Views\PhpRenderer(templatePath: \ROOT_DIR . DIRECTORY_SEPARATOR . 'src' . \DIRECTORY_SEPARATOR . 'views', attributes: [], layout: 'layout/main.php'));
    }

    public function getLogger(): \Monolog\Logger
    {
        if (true === $this->container->has(id: \Monolog\Logger::class)) {
            return $this->container->get(id: \Monolog\Logger::class);
        }

        $formatter = new \Monolog\Formatter\LineFormatter(
            null, // Format of message in log, default [%datetime%] %channel%.%level_name%: %message% %context% %extra%\n
            null, // Datetime format
            true, // allowInlineLineBreaks option, default false
            true  // ignoreEmptyContextAndExtra option, default false
        );
        $logger = new \Monolog\Logger(name: 'logger')
            ->pushHandler(
                handler: new \Monolog\Handler\RotatingFileHandler(
                    filename: ROOT_DIR . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'app.log',
                    maxFiles: 10,
                    level: \Monolog\Level::Debug,
                )
                    ->setFormatter(formatter: $formatter)

            )
            ->pushHandler(
                handler: new \Monolog\Handler\StreamHandler('php://stdout', level: \Monolog\Level::Debug)
                    ->setFormatter(formatter: $formatter)
            );
        $this->container->set(name: \Monolog\Logger::class, value: $logger);

        return $this->getLogger();
    }

    public function getValidator(): \Symfony\Component\Validator\Validator\RecursiveValidator
    {
        return new \Symfony\Component\Validator\Validator\RecursiveValidator(
            contextFactory: new \Symfony\Component\Validator\Context\ExecutionContextFactory(
                translator: new class () implements \Symfony\Contracts\Translation\TranslatorInterface {
                    public function trans(string $id, array $parameters = [], ?string $domain = null, ?string $locale = null): string
                    {
                        return DependencyContainer::getInstance()
                            ->getTranslator()
                            ->translate($id, $parameters, $domain, $locale);
                    }

                    public function getLocale(): string
                    {
                        return \DoEveryApp\Util\User\Current::getLanguage();
                    }
                }
            ),
            metadataFactory: new \Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory(loader: new \Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader()),
            validatorFactory: new \Symfony\Component\Validator\ConstraintValidatorFactory(),
        );
    }

    public function getTranslator(): Translator
    {
        return match (\DoEveryApp\Util\User\Current::getLanguage()) {
            Translator::LANGUAGE_GERMAN => new \DoEveryApp\Util\Translator\German(),
            Translator::LANGUAGE_ENGLISH => new \DoEveryApp\Util\Translator\English(),
            Translator::LANGUAGE_MAORI => new \DoEveryApp\Util\Translator\Nothing(),
        };
    }

    public static function getInstance(): static
    {
        if (false === isset(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
