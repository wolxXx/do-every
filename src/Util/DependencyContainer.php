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



    public function getEventManager(): \MyDMS\Event\Manager
    {
        $container = $this->getContainer();
        $cacheName = \MyDMS\Event\Manager::class;
        if (true === $container->has($cacheName)) {
            return $container->get($cacheName);
        }
        $container->set($cacheName, new \MyDMS\Event\Manager());

        return $this->getEventManager();
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

    public function getValidator(): \Symfony\Component\Validator\Validator\RecursiveValidator
    {
        return new \Symfony\Component\Validator\Validator\RecursiveValidator(
            new \Symfony\Component\Validator\Context\ExecutionContextFactory(
                new class implements \Symfony\Contracts\Translation\TranslatorInterface {

                    public function trans(string $id, array $parameters = [], ?string $domain = null, ?string $locale = null): string
                    {
                        #\var_dump(func_get_args());
                        #throw new \InvalidArgumentException('translate me!');
                        return $id;
                    }


                    public function getLocale(): string
                    {
                        return \MyDMS\Util\User\Current::getLanguage();
                    }
                }
            ),
            new \Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory(new \Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader()),
            new \Symfony\Component\Validator\ConstraintValidatorFactory(),
        );
    }
}
