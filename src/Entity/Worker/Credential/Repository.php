<?php

declare(strict_types=1);

namespace DoEveryApp\Entity\Worker\Credential;

class Repository extends \Doctrine\ORM\EntityRepository
{
    use \DoEveryApp\Entity\Share\Timestampable;
    use \DoEveryApp\Entity\Share\Blameable;

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
