<?php

declare(strict_types=1);

namespace DoEveryApp\Entity\Execution\CheckListItem;

class Repository extends \Doctrine\ORM\EntityRepository
{
    use \DoEveryApp\Entity\Share\Timestampable;
    use \DoEveryApp\Entity\Share\Blameable;


    public function create(\DoEveryApp\Entity\Execution\CheckListItem $entity): static
    {
        $this
            ->onCreateTS($entity)
            ->onCreate($entity)
            ->getEntityManager()
            ->persist($entity)
        ;

        return $this;
    }


    public function update(\DoEveryApp\Entity\Execution\CheckListItem $entity): static
    {
        $this
            ->onUpdate($entity)
            ->onUpdateTS($entity)
            ->getEntityManager()
            ->persist($entity)
        ;

        return $this;
    }


    public function delete(\DoEveryApp\Entity\Execution\CheckListItem $entity): static
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
     * @return \DoEveryApp\Entity\Execution\CheckListItem | null
     */
    public function find($id, $lockMode = null, int|null $lockVersion = null): ?\DoEveryApp\Entity\Execution\CheckListItem
    {
        return parent::find($id, $lockMode, $lockVersion);
    }


    /**
     * @return \DoEveryApp\Entity\Execution\CheckListItem[]
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
     * @return \DoEveryApp\Entity\Execution\CheckListItem[]
     */
    public function findBy(array $criteria, array|null $orderBy = null, $limit = null, $offset = null): array
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }


    /**
     * @param array        $criteria
     * @param array | null $orderBy
     *
     * @return \DoEveryApp\Entity\Execution\CheckListItem | null
     */
    public function findOneBy(array $criteria, array|null $orderBy = null): ?\DoEveryApp\Entity\Execution\CheckListItem
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}
