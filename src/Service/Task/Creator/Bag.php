<?php

declare(strict_types=1);

namespace DoEveryApp\Service\Task\Creator;

class Bag
{
    protected ?\DoEveryApp\Entity\Group            $group            = null;

    protected string                               $name;

    protected ?\DoEveryApp\Definition\IntervalType $intervalType     = null;

    protected ?int                                 $intervalValue    = null;

    protected \DoEveryApp\Definition\Priority      $priority         = \DoEveryApp\Definition\Priority::NORMAL;

    protected bool                                 $notify           = true;

    protected bool                                 $active           = true;

    protected bool                                 $elapsingCronType = true;

    protected ?\DoEveryApp\Entity\Worker           $assignee         = null;

    protected ?\DoEveryApp\Entity\Worker           $workingOn        = null;

    protected ?string                              $note             = null;


    public function getGroup(): ?\DoEveryApp\Entity\Group
    {
        return $this->group;
    }


    public function setGroup(?\DoEveryApp\Entity\Group $group): static
    {
        $this->group = $group;

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


    public function getIntervalType(): ?\DoEveryApp\Definition\IntervalType
    {
        return $this->intervalType;
    }


    public function setIntervalType(?\DoEveryApp\Definition\IntervalType $intervalType): static
    {
        $this->intervalType = $intervalType;

        return $this;
    }


    public function getIntervalValue(): ?int
    {
        return $this->intervalValue;
    }


    public function setIntervalValue(?int $intervalValue): static
    {
        $this->intervalValue = $intervalValue;

        return $this;
    }


    public function getPriority(): \DoEveryApp\Definition\Priority
    {
        return $this->priority;
    }


    public function setPriority(\DoEveryApp\Definition\Priority $priority): static
    {
        $this->priority = $priority;

        return $this;
    }


    public function doNotify(): bool
    {
        return $this->notify;
    }


    public function enableNotifications(bool $notify): static
    {
        $this->notify = $notify;

        return $this;
    }


    public function getAssignee(): ?\DoEveryApp\Entity\Worker
    {
        return $this->assignee;
    }


    public function setAssignee(?\DoEveryApp\Entity\Worker $assignee): static
    {
        $this->assignee = $assignee;

        return $this;
    }


    public function getWorkingOn(): ?\DoEveryApp\Entity\Worker
    {
        return $this->workingOn;
    }


    public function setWorkingOn(?\DoEveryApp\Entity\Worker $workingOn): static
    {
        $this->workingOn = $workingOn;

        return $this;
    }


    public function isActive(): bool
    {
        return $this->active;
    }


    public function setActive(bool $active): static
    {
        $this->active = $active;

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


    public function isElapsingCronType(): bool
    {
        return $this->elapsingCronType;
    }


    public function setElapsingCronType(bool $elapsingCronType): static
    {
        $this->elapsingCronType = $elapsingCronType;

        return $this;
    }
}