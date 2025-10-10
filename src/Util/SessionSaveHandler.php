<?php

declare(strict_types=1);

namespace DoEveryApp\Util;

class SessionSaveHandler implements \SessionHandlerInterface
{
    public static bool                    $SHALL_RUN = true;

    protected \Doctrine\ORM\EntityManager $entityManager;


    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->gc(max_lifetime: 60 * 60);
    }


    protected function findByName(string $name): ?\DoEveryApp\Entity\Session
    {
        return \DoEveryApp\Entity\Session::getRepository()->findOneByName(name: $name);
    }


    #[\Override]
    public function close(): bool
    {
        return true;
    }


    #[\Override]
    public function destroy(string $id): bool
    {
        $entity = $this->findByName(name: $id);
        if (null !== $entity) {
            \DoEveryApp\Entity\Session::getRepository()->delete(entity: $entity);
            $this
                ->entityManager
                ->flush()
            ;
        }

        return true;
    }


    #[\Override]
    public function gc(int $max_lifetime): int|false
    {
        \DoEveryApp\Entity\Session::getRepository()->garbageCollection(maxLifeTime: $max_lifetime);

        return 1;
    }


    #[\Override]
    public function open(string $path, string $name): bool
    {
        return true;
    }


    #[\Override]
    public function read(string $id): string|false
    {
        $existing = $this->findByName(name: $id);
        if (null === $existing) {
            return '';
        }

        return $existing->getContent();
    }

    public function write(string $id, string $data): bool
    {
        if (false === static::$SHALL_RUN) {
            return true;
        }
        try {
            $existing = $this->findByName(name: $id);
            if (null === $existing) {
                $existing = new \DoEveryApp\Entity\Session();
                $existing::getRepository()->create(entity: $existing);
            }
            $existing
                ->setName(name: $id)
                ->setContent(content: $data)
                ->setExpires(expires: new \DateTime()
                                          ->add(interval: new \DateInterval(duration: 'PT1H'))->format(format: 'Y-m-d H:i:s'))
                ->setExpires(expires: new \DateTime()->format(format: 'Y-m-d H:i:s'))
            ;
            $existing::getRepository()->update(entity: $existing);
            $this
                ->entityManager
                ->flush()
            ;
            return true;
        } catch (\Exception $exception) {
            DependencyContainer::getInstance()->getLogger()->emergency(message: 'cannot save session: ' . $exception->getMessage() . ' ' . $exception->getTraceAsString());
            return false;
        }
    }
}
