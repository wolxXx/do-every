<?php

declare(strict_types=1);

namespace DoEveryApp\Entity\Session;

class Repository extends \Doctrine\ORM\EntityRepository
{
    use \DoEveryApp\Entity\Share\Timestampable;
    use \DoEveryApp\Entity\Share\Blameable;

    public function findOneByName(string $name): ?\DoEveryApp\Entity\Session
    {
        return $this->findOneBy(criteria: ['name' => $name]);
    }

    public function garbageCollection(int $maxLifeTime): static
    {
        $sub = \DateInterval::createFromDateString(datetime: $maxLifeTime . ' Seconds');
        $max = (new \DateTime())
            ->sub(interval: $sub)
            ->format(format: 'Y-m-d H:i:s')
        ;
        $this
            ->createQueryBuilder(alias: 's')
            ->delete(delete: \DoEveryApp\Entity\Session::class, alias: 's')
            ->andWhere('s.expires < :max')
            ->setParameter(key: 'max', value: $max)
            ->getQuery()
            ->execute()
        ;

        return $this;
    }

    public function create(\DoEveryApp\Entity\Session $entity): static
    {
        $this
            ->onCreateTS(model: $entity)
            ->onCreate(model: $entity)
            ->getEntityManager()
            ->persist(object: $entity)
        ;

        return $this;
    }

    public function update(\DoEveryApp\Entity\Session $entity): static
    {
        $this
            ->onUpdate(model: $entity)
            ->onUpdateTS(model: $entity)
            ->getEntityManager()
            ->persist(object: $entity)
        ;

        return $this;
    }

    public function delete(\DoEveryApp\Entity\Session $entity): static
    {
        $this
            ->getEntityManager()
            ->remove(object: $entity)
        ;

        return $this;
    }

    /**
     * @param mixed          $id
     * @param integer | null $lockMode
     * @param integer | null $lockVersion
     *
     * @return \DoEveryApp\Entity\Session | null
     */
    public function find($id, $lockMode = null, int|null $lockVersion = null): ?\DoEveryApp\Entity\Session
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    /**
     * @return \DoEveryApp\Entity\Session[]
     */
    public function findAll(): array
    {
        return parent::findAll();
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     *
     * @return \DoEveryApp\Entity\Session[]
     */
    public function findBy(array $criteria, array|null $orderBy = null, $limit = null, $offset = null): array
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param array        $criteria
     * @param array | null $orderBy
     *
     * @return \DoEveryApp\Entity\Session | null
     */
    public function findOneBy(array $criteria, array|null $orderBy = null): ?\DoEveryApp\Entity\Session
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}
