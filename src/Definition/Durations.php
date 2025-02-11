<?php


declare(strict_types=1);

namespace DoEveryApp\Definition;

class Durations
{
    protected int   $total       = 0;

    protected int   $average     = 0;

    protected array $durations   = [];

    protected array $withoutDate = [];

    protected array $years       = [];

    protected array $months      = [];

    protected int   $day         = 0;

    protected int   $lastDay     = 0;

    protected int   $week        = 0;

    protected int   $lastWeek    = 0;

    protected int   $month       = 0;

    protected int   $lastMonth   = 0;

    protected int   $year        = 0;

    protected int   $lastYear    = 0;


    protected static function byTasks(array $tasks): static
    {
        $instance = new static();
        foreach ($tasks as $task) {
            $executions = $task->getExecutions();
            foreach ($executions as $execution) {
                $instance->addExecution($execution);
            }
        }

        return $instance->finalize();
    }


    protected function finalize(): static
    {
        if (0 !== count($this->durations)) {
            $this->average = (int)\ceil(\array_sum($this->durations) / count($this->durations));
        }
        if (0 !== count($this->years)) {
            $firstYear = \array_key_last($this->years);
            $lastYear  = \array_key_first($this->years);
            if (true === \DoEveryApp\Util\Registry::getInstance()->doFillTimeLine()) {
                foreach (range($firstYear, $lastYear) as $year) {
                    if (false === \array_key_exists($year, $this->years)) {
                        $this->years[$year] = 0;
                    }
                }
            }
            \ksort($this->years, \SORT_DESC);
            $this->years = \array_reverse($this->years, true);
        }

        if (0 !== count($this->months)) {
            $firstYearMonth = \explode('/', \array_key_last($this->months));
            $lastYearMonth  = explode('/', \array_key_first($this->months));
            $begin          = \Carbon\Carbon::now()->year((int)$firstYearMonth[0])->month((int)$firstYearMonth[1]);
            $end            = \Carbon\Carbon::now()->year((int)$lastYearMonth[0])->month((int)$lastYearMonth[1]);
            if (true === \DoEveryApp\Util\Registry::getInstance()->doFillTimeLine()) {
                while ($begin <= $end) {
                    $yearMonthFormatted = $begin->format('Y') . ' / ' . $begin->format('m');

                    if (false === array_key_exists($yearMonthFormatted, $this->months)) {
                        $this->months[$yearMonthFormatted] = 0;
                    }
                    $begin->addMonth();
                }
            }
            \uksort($this->months, static function ($a, $b) {
                $firstYearMonth = \explode('/', $a);
                $lastYearMonth  = explode('/', $b);
                $begin          = \Carbon\Carbon::now()->year((int)$firstYearMonth[0])->month((int)$firstYearMonth[1]);
                $end            = \Carbon\Carbon::now()->year((int)$lastYearMonth[0])->month((int)$lastYearMonth[1]);

                return $begin <= $end ? 1 : -1;
            });
        }

        return $this;
    }


    protected function addExecution(\DoEveryApp\Entity\Execution $execution): static
    {
        $tomorrow          = \Carbon\Carbon::now()->startOfDay()->addDay();
        $today             = \Carbon\Carbon::now()->startOfDay();
        $yesterday         = \Carbon\Carbon::now()->startOfDay()->subDay();
        $startOfWeek       = \Carbon\Carbon::now()->startOfWeek();
        $startOfLastWeek   = \Carbon\Carbon::now()->startOfWeek()->subWeek();
        $startOfMonth      = \Carbon\Carbon::now()->startOfMonth();
        $startOfLastMonth  = \Carbon\Carbon::now()->startOfMonth()->subMonth();
        $startOfYear       = \Carbon\Carbon::now()->startOfYear();
        $startOfLastYear   = \Carbon\Carbon::now()->startOfYear()->subYear();
        $this->total       += $execution->getDuration();
        $this->durations[] = $execution->getDuration();
        if (null === $execution->getDate()) {
            return $this;
        }

        $yearFormatted      = $execution->getDate()->format('Y');
        $yearMonthFormatted = $execution->getDate()->format('Y') . ' / ' . $execution->getDate()->format('m');
        if (false === array_key_exists($yearFormatted, $this->years)) {
            $this->years[$yearFormatted] = 0;
        }
        if (false === array_key_exists($yearMonthFormatted, $this->months)) {
            $this->months[$yearMonthFormatted] = 0;
        }
        $this->years[$yearFormatted]       += $execution->getDuration();
        $this->months[$yearMonthFormatted] += $execution->getDuration();

        if ($execution->getDate() >= $today && $execution->getDate() <= $tomorrow) {
            $this->day += $execution->getDuration();
        }
        if ($execution->getDate() >= $yesterday && $execution->getDate() < $today) {
            $this->lastDay += $execution->getDuration();
        }
        if ($execution->getDate() >= $startOfWeek) {
            $this->week += $execution->getDuration();
        }
        if ($execution->getDate() >= $startOfLastWeek && $execution->getDate() < $startOfWeek) {
            $this->lastWeek += $execution->getDuration();
        }
        if ($execution->getDate() >= $startOfMonth) {
            $this->month += $execution->getDuration();
        }
        if ($execution->getDate() >= $startOfLastMonth && $execution->getDate() < $startOfMonth) {
            $this->lastMonth += $execution->getDuration();
        }
        if ($execution->getDate() >= $startOfYear) {
            $this->year += $execution->getDuration();
        }
        if ($execution->getDate() >= $startOfLastYear && $execution->getDate() < $startOfYear) {
            $this->lastYear += $execution->getDuration();
        }

        return $this;
    }


    public static function FactoryForGlobal(): static
    {
        return (static::byTasks(\DoEveryApp\Entity\Task::getRepository()->findAll()))
            ->finalize()
        ;
    }


    public static function FactoryByTask(\DoEveryApp\Entity\Task $task): static
    {
        return (static::byTasks([$task]))
            ->finalize()
        ;
    }


    public static function FactoryByGroup(\DoEveryApp\Entity\Group $group): static
    {
        return (static::byTasks($group->getTasks()))
            ->finalize()
        ;
    }


    public static function FactoryByWorker(\DoEveryApp\Entity\Worker $worker): static
    {
        $instance = new static();
        foreach (\DoEveryApp\Entity\Execution::getRepository()->findForWorker($worker) as $execution) {
            $instance->addExecution($execution);
        }

        return $instance->finalize();
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


    public function getWithoutDate(): array
    {
        return $this->withoutDate;
    }


    public function getYears(): array
    {
        return $this->years;
    }


    public function getMonths(): array
    {
        return $this->months;
    }
}