<?php

declare(strict_types=1);

namespace DoEveryApp\Entity\Task;

class Repository extends \Doctrine\ORM\EntityRepository
{
    use \DoEveryApp\Entity\Share\Timestampable;
    use \DoEveryApp\Entity\Share\Blameable;

    public function getDueTasks(): array
    {
        $tasks = $this->findAll();
        $tasks = \array_filter($tasks, function (\DoEveryApp\Entity\Task $task) {
            $lastExecution = $this->getLastExecution($task);
            if (null === $lastExecution) {
                return true;
            }
            $dueValue = $task->getDueValue();
            if (null === $dueValue) {
                return true;
            }
            if ($dueValue < 1) {
                return true;
            }
        });

        return $tasks;
    }


    /**
     * @return \DoEveryApp\Entity\Task[]
     */
    public function findForIndex()
    {
        return $this
            ->createQueryBuilder('t')
            ->select('t, concat(COALESCE(g.name, \'__\'), t.name) as hidden path')
            ->leftJoin('t.group', 'g')
            ->orderBy('path')
            #->addOrderBy('c.group is null')
            ->getQuery()
            ->execute()
        ;
    }


    public function getWorkingOn(): array
    {
        return $this
            ->createQueryBuilder('t')
            ->andWhere('t.workingOn IS NOT NULL')
            ->getQuery()
            ->execute()
        ;
    }


    public function getLastExecution(\DoEveryApp\Entity\Task $task): ?\DoEveryApp\Entity\Execution
    {
        return \DoEveryApp\Entity\Execution::getRepository()
                                           ->createQueryBuilder('e')
                                           ->andWhere('e.task = :task')
                                           ->setParameter('task', $task)
                                           ->orderBy('e.date', 'DESC')
                                           ->setMaxResults(1)
                                           ->getQuery()
                                           ->getOneOrNullResult()
        ;
    }


    public function getByGroup(\DoEveryApp\Entity\Group $group, ?bool $active = null): array
    {
        $queryBuilder = $this
            ->createQueryBuilder('t')
            ->andWhere('t.group = :group')
            ->setParameter('group', $group)
        ;
        if (true === $active) {
            $queryBuilder->andWhere('t.active = true');
        }
        if (false === $active) {
            $queryBuilder->andWhere('t.active = false');
        }

        return $queryBuilder
            ->orderBy('t.name', 'ASC')
            ->getQuery()
            ->execute()
        ;
    }


    /**
     * @return \DoEveryApp\Entity\Task[]
     */
    public function getWithoutGroup(): array
    {
        return $this
            ->createQueryBuilder('t')
            ->andWhere('t.group IS NULL')
            ->orderBy('t.name', 'ASC')
            ->getQuery()
            ->execute()
        ;
    }


    public function create(\DoEveryApp\Entity\Task $entity): static
    {
        $this
            ->onCreateTS($entity)
            ->onCreate($entity)
            ->getEntityManager()
            ->persist($entity)
        ;

        return $this;
    }


    public function update(\DoEveryApp\Entity\Task $entity): static
    {
        $this
            ->onUpdate($entity)
            ->onUpdateTS($entity)
            ->getEntityManager()
            ->persist($entity)
        ;

        return $this;
    }


    public function delete(\DoEveryApp\Entity\Task $entity): static
    {
        $this
            ->getEntityManager()
            ->remove($entity)
        ;

        return $this;
    }


    /**
     * @param mixed          $id
     * @param integer | null $lockMode
     * @param integer | null $lockVersion
     *
     * @return \DoEveryApp\Entity\Task | null
     */
    public function find($id, $lockMode = null, int|null $lockVersion = null): ?\DoEveryApp\Entity\Task
    {
        return parent::find($id, $lockMode, $lockVersion);
    }


    /**
     * @return \DoEveryApp\Entity\Task[]
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
     * @return \DoEveryApp\Entity\Task[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }


    /**
     * @param array        $criteria
     * @param array | null $orderBy
     *
     * @return \DoEveryApp\Entity\Task | null
     */
    public function findOneBy(array $criteria, array $orderBy = null): ?\DoEveryApp\Entity\Task
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}
