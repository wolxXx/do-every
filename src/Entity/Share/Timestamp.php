<?php

declare(strict_types=1);

namespace DoEveryApp\Entity\Share;

trait Timestamp
{
    use \Gedmo\Timestampable\Traits\TimestampableEntity;

    #[\Gedmo\Mapping\Annotation\Timestampable(
        on: 'create'
    )]
    #[\Doctrine\ORM\Mapping\Column(
        name    : 'created_at',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected $createdAt;

    #[\Gedmo\Mapping\Annotation\Timestampable(
        on: 'update'
    )]
    #[\Doctrine\ORM\Mapping\Column(
        name    : 'updated_at',
        type    : \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE,
        nullable: true
    )]
    protected $updatedAt;
}
