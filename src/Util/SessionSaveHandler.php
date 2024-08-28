<?php

declare(strict_types=1);

namespace MyDMS\Util;

class SessionSaveHandler implements \SessionHandlerInterface
{
    public static bool                    $SHALL_RUN = true;

    protected \Doctrine\ORM\EntityManager $entityManager;


    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->gc(60 * 60);
    }


    protected function findByName(string $name): ?\MyDMS\Model\Session
    {
        return \MyDMS\Model\Session::getRepository()->findOneByName($name);
    }


    public function close(): bool
    {
        return true;
    }


    public function destroy(string $id): bool
    {
        $entity = $this->findByName($id);
        if (null !== $entity) {
            \MyDMS\Model\Session::getRepository()->delete($entity);
            $this
                ->entityManager
                ->flush()
            ;
        }

        return true;
    }


    public function gc(int $max_lifetime): int|false
    {
        \MyDMS\Model\Session::getRepository()->garbageCollection($max_lifetime);

        return 1;
    }


    public function open(string $path, string $name): bool
    {
        return true;
    }

    public function read(string $id): string|false
    {
        $existing = $this->findByName($id);
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
            $existing = $this->findByName($id);
            if (null === $existing) {
                $existing = new \MyDMS\Model\Session();
                $existing::getRepository()->create($existing);
            }
            $existing
                ->setName($id)
                ->setContent($data)
                ->setExpires((new \DateTime())->add(new \DateInterval('PT1H'))->format('Y-m-d H:i:s'))
                ->setExpires((new \DateTime())->format('Y-m-d H:i:s'))
            ;
            $existing::getRepository()->update($existing);
            $this
                ->entityManager
                ->flush()
            ;
            return true;
        } catch (\Exception $exception) {
            DependencyContainer::getInstance()->getLogger()->emergency('cannot save session: ' . $exception->getMessage() . ' ' . $exception->getTraceAsString());
            return false;
        }
    }
}