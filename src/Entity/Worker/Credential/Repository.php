<?php

declare(strict_types=1);

namespace DoEveryApp\Entity\Worker\Credential;

class Repository extends \Doctrine\ORM\EntityRepository
{
    use \DoEveryApp\Entity\Share\DefaultRepositoryTraits;

    public function findPasswordForWorker(\DoEveryApp\Entity\Worker $worker): ?\DoEveryApp\Entity\Worker\Credential
    {
        return $this
            ->createQueryBuilder(alias: 'c')
            ->andWhere('c.worker = :worker')
            ->setParameter('worker', $worker)
            ->andWhere('c.password IS NOT NULL')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findPasskeyForWorker(\DoEveryApp\Entity\Worker $worker): ?\DoEveryApp\Entity\Worker\Credential
    {
        return $this
            ->createQueryBuilder(alias: 'c')
            ->andWhere('c.worker = :worker')
            ->setParameter('worker', $worker)
            ->andWhere('c.passkeySecret IS NOT NULL')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function create(\DoEveryApp\Entity\Worker\Credential $entity): static
    {
        $this
            ->onCreateTS(model: $entity)
            ->onCreate(model: $entity)
            ->getEntityManager()
            ->persist(object: $entity)
        ;

        return $this;
    }

    public function update(\DoEveryApp\Entity\Worker\Credential $entity): static
    {
        $this
            ->onUpdate(model: $entity)
            ->onUpdateTS(model: $entity)
            ->getEntityManager()
            ->persist(object: $entity)
        ;

        return $this;
    }

    public function delete(\DoEveryApp\Entity\Worker\Credential $entity): static
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
     * @return \DoEveryApp\Entity\Worker\Credential | null
     */
    public function find($id, $lockMode = null, int|null $lockVersion = null): ?\DoEveryApp\Entity\Worker\Credential
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    /**
     * @return \DoEveryApp\Entity\Worker\Credential[]
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
     * @return \DoEveryApp\Entity\Worker\Credential[]
     */
    public function findBy(array $criteria, array|null $orderBy = null, $limit = null, $offset = null): array
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param array        $criteria
     * @param array | null $orderBy
     *
     * @return \DoEveryApp\Entity\Worker\Credential | null
     */
    public function findOneBy(array $criteria, array|null $orderBy = null): ?\DoEveryApp\Entity\Worker\Credential
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}
