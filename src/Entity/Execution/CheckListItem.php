<?php


declare(strict_types=1);

namespace DoEveryApp\Entity\Execution;

#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: CheckListItem\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name   : self::TABLE_NAME,
    options: [
        'collate' => 'utf8_general_ci',
        'charset' => 'utf8',
        'engine'  => 'InnoDB',
    ],
)]

class CheckListItem
{
    use \DoEveryApp\Entity\Share\Blame;
    use \DoEveryApp\Entity\Share\Id;
    use \DoEveryApp\Entity\Share\Repository;
    use \DoEveryApp\Entity\Share\Timestamp;

    public const string TABLE_NAME = 'task_execution_check_list_item';


    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: \DoEveryApp\Entity\Execution::class
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: false,
        onDelete: 'CASCADE'
    )]
    protected \DoEveryApp\Entity\Execution $execution;


    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: \DoEveryApp\Entity\Task\CheckListItem::class
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: true,
        onDelete: 'SET NULL'
    )]
    protected ?\DoEveryApp\Entity\Task\CheckListItem $checkListItem = null;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'position',
        type    : \Doctrine\DBAL\Types\Types::INTEGER,
        nullable: false,
        options : [
            "default" => 0,
        ],
    )]
    protected int                                    $position      = 0;

    #[\Doctrine\ORM\Mapping\Column(
        name    : 'name',
        type    : \Doctrine\DBAL\Types\Types::STRING,
        nullable: false
    )]
    protected string                                 $name;


    #[\Doctrine\ORM\Mapping\Column(
        name    : 'note',
        type    : \Doctrine\DBAL\Types\Types::TEXT,
        nullable: true
    )]
    protected ?string $note = null;


    #[\Doctrine\ORM\Mapping\Column(
        name    : 'checked',
        type    : \Doctrine\DBAL\Types\Types::BOOLEAN,
        nullable: false,
        options : [
            "default" => 0,
        ],
    )]
    protected bool $checked = false;


    public static function getRepository(): CheckListItem\Repository
    {
        return static::getRepositoryByClassName();
    }


    public function getExecution(): \DoEveryApp\Entity\Execution
    {
        return $this->execution;
    }


    public function setExecution(\DoEveryApp\Entity\Execution $execution): static
    {
        $this->execution = $execution;

        return $this;
    }


    public function getCheckListItem(): ?\DoEveryApp\Entity\Task\CheckListItem
    {
        return $this->checkListItem;
    }


    public function setCheckListItem(?\DoEveryApp\Entity\Task\CheckListItem $checkListItem): static
    {
        $this->checkListItem = $checkListItem;

        return $this;
    }


    public function getPosition(): int
    {
        return $this->position;
    }


    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }


    public function getNote(): ?string
    {
        return $this->note;
    }


    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }


    public function isChecked(): bool
    {
        return $this->checked;
    }


    public function setChecked(bool $checked): static
    {
        $this->checked = $checked;

        return $this;
    }
}
