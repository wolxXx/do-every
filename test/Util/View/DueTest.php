<?php

declare(strict_types=1);

namespace DoEveryAppTest\Util\View;

class DueTest extends \DoEveryAppTest\TestBase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('getTestDataProvider')]
    public function testGet(string $expected, \DoEveryApp\Entity\Task $value): void
    {
        \Carbon\Carbon::setTestNow('2024-01-10 12:00:00');
        $this->assertSame('2024-01-10 12:00:00', \Carbon\Carbon::getTestNow()->format('Y-m-d H:i:s'));
        $this->assertSame('2024-01-10 12:00:00', \Carbon\Carbon::now()->format('Y-m-d H:i:s'));
        $this->assertSame($expected, \DoEveryApp\Util\View\Due::getByTask($value));
    }


    public static function getTestDataProvider(): array
    {
        $nowDueTask = (new \DoEveryApp\Entity\Task())
            ->setName('Test Task')
            ->setIntervalType(\DoEveryApp\Definition\IntervalType::HOUR->value)
            ->setIntervalValue(12)
            ;
        $nowDueTask::getRepository()->create($nowDueTask);

        $inTenDaysTask = (new \DoEveryApp\Entity\Task())
            ->setName('Test Task')
            ->setIntervalType(\DoEveryApp\Definition\IntervalType::DAY->value)
            ->setIntervalValue(12)
        ;
        $inTenDaysTask::getRepository()->create($inTenDaysTask);
        $inTenDaysTaskExecution = (new \DoEveryApp\Entity\Execution())
            ->setTask($inTenDaysTask)
            ->setDate(new \DateTime('2024-01-01 11:00:00'))
            ;
        $inTenDaysTaskExecution::getRepository()->create($inTenDaysTaskExecution);

        \DoEveryApp\Util\DependencyContainer::getInstance()
                                            ->getEntityManager()
                                            ->flush()
        ;


        return [
            ['jetzt fällig', $nowDueTask],
            ['fällig in 2,958 Tagen', $inTenDaysTask],
        ];

    }

}