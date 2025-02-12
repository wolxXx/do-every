<?php

declare(strict_types=1);

namespace DoEveryApp\Entity\Share;

trait Blame
{
    use \Gedmo\Blameable\Traits\BlameableEntity;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'created_by',
        nullable: true
    )]
    #[\Gedmo\Mapping\Annotation\Blameable(on: 'create')]
    protected $createdBy;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'updated_by',
        nullable: true
    )]
    #[\Gedmo\Mapping\Annotation\Blameable(on: 'update')]
    protected $updatedBy;
}
