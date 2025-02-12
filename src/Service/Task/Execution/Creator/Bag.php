<?php

declare(strict_types=1);

namespace DoEveryApp\Service\Task\Execution\Creator;

class Bag
{
    protected \DoEveryApp\Entity\Task    $task;

    protected \DateTime                  $date;

    protected ?\DoEveryApp\Entity\Worker $worker   = null;

    protected ?int                       $duration = null;

    protected ?string                    $note     = null;

    public function getTask(): \DoEveryApp\Entity\Task
    {
        return $this->task;
    }

    public function setTask(\DoEveryApp\Entity\Task $task): static
    {
        $this->task = $task;

        return $this;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getWorker(): ?\DoEveryApp\Entity\Worker
    {
        return $this->worker;
    }

    public function setWorker(?\DoEveryApp\Entity\Worker $worker): static
    {
        $this->worker = $worker;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): static
    {
        $this->duration = $duration;

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
}
