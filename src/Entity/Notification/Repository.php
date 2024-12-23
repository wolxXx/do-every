<?php

declare(strict_types=1);

namespace DoEveryApp\Entity\Notification;

class Repository extends \Doctrine\ORM\EntityRepository
{
    use \DoEveryApp\Entity\Share\Timestampable;
    use \DoEveryApp\Entity\Share\Blameable;

    /**
     * @return \DoEveryApp\Entity\Notification[]
     */
    public function getForWorker(\DoEveryApp\Entity\Worker $worker): array
    {
        return $this
            ->createQueryBuilder('n')
            ->andWhere('n.worker = :worker')
            ->setParameter('worker', $worker)
            ->orderBy('n.createdAt', 'DESC')
            ->getQuery()
            ->execute()
        ;
    }


    public function getLastForWorker(\DoEveryApp\Entity\Worker $worker): ?\DoEveryApp\Entity\Notification
    {
        return $this
            ->createQueryBuilder('n')
            ->andWhere('n.worker = :worker')
            ->setParameter('worker', $worker)
            ->orderBy('n.createdAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    /**
     * @return \DoEveryApp\Entity\Notification[]
     */
    public function getForWorkerAndTask(\DoEveryApp\Entity\Worker $worker, \DoEveryApp\Entity\Task $task): array
    {
        return $this
            ->createQueryBuilder('n')
            ->andWhere('n.worker = :worker')
            ->setParameter('worker', $worker)
            ->andWhere('n.task = :task')
            ->setParameter('task', $task)
            ->orderBy('n.createdAt', 'DESC')
            ->getQuery()
            ->execute()
        ;
    }


    /**
     * @return \DoEveryApp\Entity\Notification[]
     */
    public function getLastForWorkerAndTask(\DoEveryApp\Entity\Worker $worker, \DoEveryApp\Entity\Task $task): ?\DoEveryApp\Entity\Notification
    {
        return $this
            ->createQueryBuilder('n')
            ->andWhere('n.worker = :worker')
            ->setParameter('worker', $worker)
            ->andWhere('n.task = :task')
            ->setParameter('task', $task)
            ->orderBy('n.createdAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    public function create(\DoEveryApp\Entity\Notification $entity): static
    {
        $this
            ->onCreateTS($entity)
            ->onCreate($entity)
            ->getEntityManager()
            ->persist($entity)
        ;

        return $this;
    }


    public function update(\DoEveryApp\Entity\Notification $entity): static
    {
        $this
            ->onUpdate($entity)
            ->onUpdateTS($entity)
            ->getEntityManager()
            ->persist($entity)
        ;

        return $this;
    }


    public function delete(\DoEveryApp\Entity\Notification $entity): static
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
     * @return \DoEveryApp\Entity\Notification | null
     */
    public function find($id, $lockMode = null, int|null $lockVersion = null): ?\DoEveryApp\Entity\Notification
    {
        return parent::find($id, $lockMode, $lockVersion);
    }


    /**
     * @return \DoEveryApp\Entity\Notification[]
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
     * @return \DoEveryApp\Entity\Notification[]
     */
    public function findBy(array $criteria, array|null $orderBy = null, $limit = null, $offset = null): array
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }


    /**
     * @param array        $criteria
     * @param array | null $orderBy
     *
     * @return \DoEveryApp\Entity\Notification | null
     */
    public function findOneBy(array $criteria, array|null $orderBy = null): ?\DoEveryApp\Entity\Notification
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}
