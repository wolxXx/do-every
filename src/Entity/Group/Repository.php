<?php

declare(strict_types=1);

namespace DoEveryApp\Entity\Group;

class Repository extends \Doctrine\ORM\EntityRepository
{
    use \DoEveryApp\Entity\Share\Timestampable;
    use \DoEveryApp\Entity\Share\Blameable;

    /**
     * @return \DoEveryApp\Entity\Group[]
     */
    public function findIndexed(): array
    {
        return $this
            ->createQueryBuilder(alias: 'g')
            ->orderBy(sort: 'g.name', order: 'ASC')
            ->getQuery()
            ->execute()
        ;
    }

    public function create(\DoEveryApp\Entity\Group $entity): static
    {
        $this
            ->onCreateTS(model: $entity)
            ->onCreate(model: $entity)
            ->getEntityManager()
            ->persist(object: $entity)
        ;

        return $this;
    }

    public function update(\DoEveryApp\Entity\Group $entity): static
    {
        $this
            ->onUpdate(model: $entity)
            ->onUpdateTS(model: $entity)
            ->getEntityManager()
            ->persist(object: $entity)
        ;

        return $this;
    }

    public function delete(\DoEveryApp\Entity\Group $entity): static
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
     * @return \DoEveryApp\Entity\Group | null
     */
    public function find($id, $lockMode = null, int|null $lockVersion = null): ?\DoEveryApp\Entity\Group
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    /**
     * @return \DoEveryApp\Entity\Group[]
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
     * @return \DoEveryApp\Entity\Group[]
     */
    public function findBy(array $criteria, array|null $orderBy = null, $limit = null, $offset = null): array
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param array        $criteria
     * @param array | null $orderBy
     *
     * @return \DoEveryApp\Entity\Group | null
     */
    public function findOneBy(array $criteria, array|null $orderBy = null): ?\DoEveryApp\Entity\Group
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}
