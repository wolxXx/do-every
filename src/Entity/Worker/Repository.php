<?php

declare(strict_types=1);

namespace DoEveryApp\Entity\Worker;

class Repository extends \Doctrine\ORM\EntityRepository
{
    use \DoEveryApp\Entity\Share\DefaultRepositoryTraits;

    public function findOneByPasswordResetToken(string $token): ?\DoEveryApp\Entity\Worker
    {
        return $this->findOneBy(criteria: ['passwordResetToken' => $token]);
    }

    public function findOneByEmail(string $email): ?\DoEveryApp\Entity\Worker
    {
        return $this->findOneBy(criteria: ['email' => $email]);
    }

    /**
     * @return \DoEveryApp\Entity\Worker[]
     */
    public function findIndexed(): array
    {
        return $this
            ->createQueryBuilder(alias: 'w')
            ->orderBy(sort: 'w.name', order: 'ASC')
            ->getQuery()
            ->execute()
        ;
    }

    public function create(\DoEveryApp\Entity\Worker $entity): static
    {
        $this
            ->onCreateTS(model: $entity)
            ->onCreate(model: $entity)
            ->getEntityManager()
            ->persist(object: $entity)
        ;

        return $this;
    }

    public function update(\DoEveryApp\Entity\Worker $entity): static
    {
        $this
            ->onUpdate(model: $entity)
            ->onUpdateTS(model: $entity)
            ->getEntityManager()
            ->persist(object: $entity)
        ;

        return $this;
    }

    public function delete(\DoEveryApp\Entity\Worker $entity): static
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
     * @return \DoEveryApp\Entity\Worker | null
     */
    public function find($id, $lockMode = null, int|null $lockVersion = null): ?\DoEveryApp\Entity\Worker
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    /**
     * @return \DoEveryApp\Entity\Worker[]
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
     * @return \DoEveryApp\Entity\Worker[]
     */
    public function findBy(array $criteria, array|null $orderBy = null, $limit = null, $offset = null): array
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param array        $criteria
     * @param array | null $orderBy
     *
     * @return \DoEveryApp\Entity\Worker | null
     */
    public function findOneBy(array $criteria, array|null $orderBy = null): ?\DoEveryApp\Entity\Worker
    {
        return parent::findOneBy($criteria, $orderBy);
    }
}
