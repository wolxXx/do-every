<?php


declare(strict_types=1);

namespace DoEveryApp\Definition;


class Durations
{
    protected int $total     = 0;

    protected int $average   = 0;

    protected int $day       = 0;

    protected int $lastDay   = 0;

    protected int $week      = 0;

    protected int $lastWeek  = 0;

    protected int $month     = 0;

    protected int $lastMonth = 0;

    protected int $year      = 0;

    protected int $lastYear  = 0;

    protected static function byTasks(array $tasks): static
    {
        $tomorrow         = \Carbon\Carbon::now()->startOfDay()->addDay();
        $today            = \Carbon\Carbon::now()->startOfDay();
        $yesterday        = \Carbon\Carbon::now()->startOfDay()->subDay();
        $startOfWeek      = \Carbon\Carbon::now()->startOfWeek();
        $startOfLastWeek  = \Carbon\Carbon::now()->startOfWeek()->subWeek();
        $startOfMonth     = \Carbon\Carbon::now()->startOfMonth();
        $startOfLastMonth = \Carbon\Carbon::now()->startOfMonth()->subMonth();
        $startOfYear      = \Carbon\Carbon::now()->startOfYear();
        $startOfLastYear  = \Carbon\Carbon::now()->startOfYear()->subYear();
        $instance         = new static();
        $durations        = [];
        foreach ($tasks as $task) {
            $executions = $task->getExecutions();
            foreach ($executions as $execution) {
                $instance->total += $execution->getDuration();
                $durations[]     = $execution->getDuration();
                if (null === $execution->getDate()) {
                    continue;
                }
                if ($execution->getDate() >= $today && $execution->getDate() <= $tomorrow) {
                    $instance->day += $execution->getDuration();
                }
                if ($execution->getDate() >= $yesterday && $execution->getDate() < $today) {
                    $instance->lastDay += $execution->getDuration();
                }
                if ($execution->getDate() >= $startOfWeek) {
                    $instance->week += $execution->getDuration();
                }
                if ($execution->getDate() >= $startOfLastWeek && $execution->getDate() < $startOfWeek) {
                    $instance->lastWeek += $execution->getDuration();
                }
                if ($execution->getDate() >= $startOfMonth) {
                    $instance->month += $execution->getDuration();
                }
                if ($execution->getDate() >= $startOfLastMonth && $execution->getDate() < $startOfMonth) {
                    $instance->lastMonth += $execution->getDuration();
                }
                if ($execution->getDate() >= $startOfYear) {
                    $instance->year += $execution->getDuration();
                }
                if ($execution->getDate() >= $startOfLastYear && $execution->getDate() < $startOfYear) {
                    $instance->lastYear += $execution->getDuration();
                }
            }
        }
        if (0 !== count($durations)) {
            $instance->average = (int)\ceil(\array_sum($durations) / count($durations));
        }

        return $instance;
    }


    public static function FactoryForGlobal(): static
    {
        return static::byTasks(\DoEveryApp\Entity\Task::getRepository()->findAll());
    }

    public static function FactoryByTask(\DoEveryApp\Entity\Task $task): static
    {
        return static::byTasks([$task]);
    }


    public static function FactoryByGroup(\DoEveryApp\Entity\Group $group): static
    {
        return static::byTasks($group->getTasks());
    }


    public static function FactoryByWorker(\DoEveryApp\Entity\Worker $worker): static
    {
        $tasks = [];
        return static::byTasks($group->getTasks());
    }


    public function getTotal(): int
    {
        return $this->total;
    }


    public function getDay(): int
    {
        return $this->day;
    }


    public function getLastDay(): int
    {
        return $this->lastDay;
    }


    public function getWeek(): int
    {
        return $this->week;
    }


    public function getLastWeek(): int
    {
        return $this->lastWeek;
    }


    public function getMonth(): int
    {
        return $this->month;
    }


    public function getLastMonth(): int
    {
        return $this->lastMonth;
    }


    public function getYear(): int
    {
        return $this->year;
    }


    public function getLastYear(): int
    {
        return $this->lastYear;
    }


    public function getAverage(): int
    {
        return $this->average;
    }
}