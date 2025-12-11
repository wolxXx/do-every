<?php

declare(strict_types=1);

namespace DoEveryApp\Entity\Execution;

class Repository extends \Doctrine\ORM\EntityRepository
{
    use \DoEveryApp\Entity\Share\DefaultRepositoryTraits;

    public function findForWorker(\DoEveryApp\Entity\Worker $worker)
    {
        return $this
            ->createQueryBuilder(alias: 'e')
            ->andWhere('e.worker = :worker')
            ->setParameter(key: 'worker', value: $worker)
            ->orderBy(sort: 'e.date', order: 'DESC')
            ->getQuery()
            ->execute()
        ;
    }

    public function findForIndex(?int $limit = null)
    {
        $queryBuilder = $this
            ->createQueryBuilder(alias: 'e')
            ->innerJoin(join: 'e.task', alias: 't')
            ->leftJoin(join: 't.group', alias: 'g')
            ->orderBy(sort: 'e.date', order: 'DESC')
        ;
        if (null !== $limit) {
            $queryBuilder->setMaxResults(maxResults: $limit);
        }

        return $queryBuilder
            ->getQuery()
            ->execute()
        ;
    }

    public function findIndexed(\DoEveryApp\Entity\Task $param)
    {
        return $this
            ->createQueryBuilder(alias: 'e')
            ->andWhere('e.task = :task')
            ->setParameter(key: 'task', value: $param)
            ->orderBy(sort: 'e.date', order: 'DESC')
            ->getQuery()
            ->execute()
        ;
    }

    public function create(\DoEveryApp\Entity\Execution $entity): static
    {
        $this
            ->onCreateTS(model: $entity)
            ->onCreate(model: $entity)
            ->getEntityManager()
            ->persist(object: $entity)
        ;

        return $this;
    }

    public function update(\DoEveryApp\Entity\Execution $entity): static
    {
        $this
            ->onUpdate(model: $entity)
            ->onUpdateTS(model: $entity)
            ->getEntityManager()
            ->persist(object: $entity)
        ;

        return $this;
    }

    public function delete(\DoEveryApp\Entity\Execution $entity): static
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
     * @return \DoEveryApp\Entity\Execution | null
     */
    public function find($id, $lockMode = null, int|null $lockVersion = null): ?\DoEveryApp\Entity\Execution
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    /**
     * @return \DoEveryApp\Entity\Execution[]
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
     * @return \DoEveryApp\Entity\Execution[]
     */
    public function findBy(array $criteria, array|null $orderBy = null, $limit = null, $offset = null): array
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param array        $criteria
     * @param array | null $orderBy
     *
     * @return \DoEveryApp\Entity\Execution | null
     */
    public function findOneBy(array $criteria, array|null $orderBy = null): ?\DoEveryApp\Entity\Execution
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}
