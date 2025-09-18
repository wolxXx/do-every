<?php

declare(strict_types=1);

namespace DoEveryApp\Entity\Task;

class Repository extends \Doctrine\ORM\EntityRepository
{
    use \DoEveryApp\Entity\Share\Timestampable;
    use \DoEveryApp\Entity\Share\Blameable;

    /**
     * @var \DoEveryApp\Entity\Execution[]
     */
    protected array $map = [];

    /**
     * @return \DoEveryApp\Entity\Task[]
     */
    public function getDueTasks(): array
    {
        $tasks = $this
            ->createQueryBuilder(alias: 't')
            ->leftJoin(join: 't.group', alias: 'g')
            ->leftJoin(join: 't.workingOn', alias: 'w')
            ->leftJoin(join: 't.assignee', alias: 'a')
            ->andWhere('t.active = :active')
            ->setParameter(key: 'active', value: true)
            ->getQuery()
            ->execute()
        ;

        return \array_filter(array: $tasks, callback: function (\DoEveryApp\Entity\Task $task) {
            if (false === $task->isActive()) {
                return false;
            }
            $lastExecution = $this->getLastExecution(task: $task);
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
            ->createQueryBuilder(alias: 't')
            ->addSelect('t, concat(COALESCE(g.name, \'__\'), t.name) as hidden path')
            ->leftJoin(join: 't.group', alias: 'g')
            ->leftJoin(join: 't.assignee', alias: 'a')
            ->leftJoin(join: 't.workingOn', alias: 'w')
            ->andWhere('t.active = :active')
            ->setParameter(key: 'active', value: true)
            ->orderBy(sort: 'path')
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
            ->createQueryBuilder(alias: 't')
            ->addSelect('t, concat(COALESCE(g.name, \' \'), \'__\', t.name) as hidden path')
            ->leftJoin(join: 't.group', alias: 'g')
            ->orderBy(sort: 'path')
            ->getQuery()
            ->execute()
        ;
    }

    public function getWorkingOn(): array
    {
        return $this
            ->createQueryBuilder(alias: 't')
            ->leftJoin(join: 't.workingOn', alias: 'w')
            ->leftJoin(join: 't.assignee', alias: 'a')
            ->leftJoin(join: 't.group', alias: 'g')
            ->andWhere('t.workingOn IS NOT NULL')
            ->getQuery()
            ->execute()
        ;
    }

    public function getLastExecution(\DoEveryApp\Entity\Task $task): ?\DoEveryApp\Entity\Execution
    {
        if (true === \array_key_exists(key: $task->getId(), array: $this->map)) {
            return $this->map[$task->getId()];
        }
        $lastExecution = \DoEveryApp\Entity\Execution::getRepository()
                                                     ->createQueryBuilder(alias: 'e')
                                                     ->andWhere('e.task = :task')
                                                     ->setParameter(key: 'task', value: $task)
                                                     ->orderBy(sort: 'e.date', order: 'DESC')
                                                     ->setMaxResults(maxResults: 1)
                                                     ->getQuery()
                                                     ->getOneOrNullResult()
        ;

        $this->map[$task->getId()] = $lastExecution;

        return $lastExecution;
    }

    public function getByGroup(\DoEveryApp\Entity\Group $group, ?bool $active = null): array
    {
        $queryBuilder = $this
            ->createQueryBuilder(alias: 't')
            ->andWhere('t.group = :group')
            ->setParameter(key: 'group', value: $group)
        ;
        if (true === $active) {
            $queryBuilder->andWhere('t.active = true');
        }
        if (false === $active) {
            $queryBuilder->andWhere('t.active = false');
        }

        return $queryBuilder
            ->orderBy(sort: 't.name', order: 'ASC')
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
            ->createQueryBuilder(alias: 't')
            ->andWhere('t.group IS NULL')
            ->orderBy(sort: 't.name', order: 'ASC')
            ->getQuery()
            ->execute()
        ;
    }

    public function create(\DoEveryApp\Entity\Task $entity): static
    {
        $this
            ->onCreateTS(model: $entity)
            ->onCreate(model: $entity)
            ->getEntityManager()
            ->persist(object: $entity)
        ;

        return $this;
    }

    public function update(\DoEveryApp\Entity\Task $entity): static
    {
        $this
            ->onUpdate(model: $entity)
            ->onUpdateTS(model: $entity)
            ->getEntityManager()
            ->persist(object: $entity)
        ;

        return $this;
    }

    public function delete(\DoEveryApp\Entity\Task $entity): static
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
    public function findBy(array $criteria, array|null $orderBy = null, $limit = null, $offset = null): array
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param array        $criteria
     * @param array | null $orderBy
     *
     * @return \DoEveryApp\Entity\Task | null
     */
    public function findOneBy(array $criteria, array|null $orderBy = null): ?\DoEveryApp\Entity\Task
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}
