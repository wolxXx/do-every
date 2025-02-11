<?php

declare(strict_types = 1);

namespace DoEveryApp\Entity\Task;

class Repository extends \Doctrine\ORM\EntityRepository
{
    use \DoEveryApp\Entity\Share\Timestampable;
    use \DoEveryApp\Entity\Share\Blameable;

    /**
     * @var \DoEveryApp\Entity\Execution[]
     */
    protected array $map = [];

    public function getDueTasks(): array
    {
        $tasks = $this
            ->createQueryBuilder('t')
            ->leftJoin('t.group', 'g')
            ->leftJoin('t.workingOn', 'w')
            ->leftJoin('t.assignee', 'a')
            ->andWhere('t.active = :active',)
            ->setParameter('active', true,)
            ->getQuery()
            ->execute()
            ;
        return \array_filter($tasks, function(\DoEveryApp\Entity\Task $task,) {
            if (false === $task->isActive()) {
                return false;
            }
            $lastExecution = $this->getLastExecution($task,);
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

            return false;
        },);
    }


    /**
     * @return \DoEveryApp\Entity\Task[]
     */
    public function findForIndex()
    {
        return $this
            ->createQueryBuilder('t',)
            ->addSelect('t, concat(COALESCE(g.name, \'__\'), t.name) as hidden path',)
            ->leftJoin('t.group', 'g',)
            ->leftJoin('t.assignee', 'a')
            ->leftJoin('t.workingOn', 'w')
            ->andWhere('t.active = :active',)
            ->setParameter('active', true,)
            ->orderBy('path',)
            ->getQuery()
            ->execute()
        ;
    }


    /**
     * @return \DoEveryApp\Entity\Task[]
     */
    public function findAllForIndex()
    {
        return $this
            ->createQueryBuilder('t',)
            ->addSelect('t, concat(COALESCE(g.name, \' \'), \'__\', t.name) as hidden path',)
            ->leftJoin('t.group', 'g',)
            ->orderBy('path',)
            ->getQuery()
            ->execute()
        ;
    }


    public function getWorkingOn(): array
    {
        return $this
            ->createQueryBuilder('t',)
            ->leftJoin('t.workingOn', 'w',)
            ->leftJoin('t.assignee', 'a',)
            ->leftJoin('t.group', 'g',)
            ->andWhere('t.workingOn IS NOT NULL',)
            ->getQuery()
            ->execute()
        ;
    }


    public function getLastExecution(\DoEveryApp\Entity\Task $task,): ?\DoEveryApp\Entity\Execution
    {
        if(true === \array_key_exists($task->getId(), $this->map)) {
            return $this->map[$task->getId()];
        }
        $lastExecution = \DoEveryApp\Entity\Execution::getRepository()
                                                       ->createQueryBuilder('e',)
                                                       ->andWhere('e.task = :task',)
                                                       ->setParameter('task', $task,)
                                                       ->orderBy('e.date', 'DESC',)
                                                       ->setMaxResults(1,)
                                                       ->getQuery()
                                                       ->getOneOrNullResult()
        ;

        $this->map[$task->getId()]  = $lastExecution;
        return $lastExecution
        ;
    }


    public function getByGroup(\DoEveryApp\Entity\Group $group, ?bool $active = null,): array
    {
        $queryBuilder = $this
            ->createQueryBuilder('t',)
            ->andWhere('t.group = :group',)
            ->setParameter('group', $group,)
        ;
        if (true === $active) {
            $queryBuilder->andWhere('t.active = true',);
        }
        if (false === $active) {
            $queryBuilder->andWhere('t.active = false',);
        }

        return $queryBuilder
            ->orderBy('t.name', 'ASC',)
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
            ->createQueryBuilder('t',)
            ->andWhere('t.group IS NULL',)
            ->orderBy('t.name', 'ASC',)
            ->getQuery()
            ->execute()
        ;
    }


    public function create(\DoEveryApp\Entity\Task $entity,): static
    {
        $this
            ->onCreateTS($entity,)
            ->onCreate($entity,)
            ->getEntityManager()
            ->persist($entity,)
        ;

        return $this;
    }


    public function update(\DoEveryApp\Entity\Task $entity,): static
    {
        $this
            ->onUpdate($entity,)
            ->onUpdateTS($entity,)
            ->getEntityManager()
            ->persist($entity,)
        ;

        return $this;
    }


    public function delete(\DoEveryApp\Entity\Task $entity,): static
    {
        $this
            ->getEntityManager()
            ->remove($entity,)
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
    public function find($id, $lockMode = null, int|null $lockVersion = null,): ?\DoEveryApp\Entity\Task
    {
        return parent::find($id, $lockMode, $lockVersion,);
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
    public function findBy(array $criteria, array|null $orderBy = null, $limit = null, $offset = null,): array
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset,);
    }


    /**
     * @param array        $criteria
     * @param array | null $orderBy
     *
     * @return \DoEveryApp\Entity\Task | null
     */
    public function findOneBy(array $criteria, array|null $orderBy = null,): ?\DoEveryApp\Entity\Task
    {
        return parent::findOneBy($criteria, $orderBy,);
    }
}
