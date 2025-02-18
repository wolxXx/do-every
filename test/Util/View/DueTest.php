<?php

declare(strict_types=1);

namespace DoEveryAppTest\Util\View;

class DueTest extends \DoEveryAppTest\TestBase
{
    #[\PHPUnit\Framework\Attributes\DataProvider('getTestDataProvider')]
    public function testGet(string $expected, \DoEveryApp\Entity\Task $value): void
    {
        \Carbon\Carbon::setTestNow(testNow: '2024-01-10 12:00:00');
        $this->assertSame(expected: '2024-01-10 12:00:00', actual: \Carbon\Carbon::getTestNow()->format(format: 'Y-m-d H:i:s'));
        $this->assertSame(expected: '2024-01-10 12:00:00', actual: \Carbon\Carbon::now()->format(format: 'Y-m-d H:i:s'));
        $this->assertSame(expected: $expected, actual: \DoEveryApp\Util\View\Due::getByTask(task: $value));
    }


    public static function getTestDataProvider(): array
    {
        $nowDueTask = (new \DoEveryApp\Entity\Task())
            ->setName(name: 'Test Task')
            ->setIntervalType(intervalType: \DoEveryApp\Definition\IntervalType::HOUR->value)
            ->setIntervalValue(intervalValue: 12)
            ;
        $nowDueTask::getRepository()->create(entity: $nowDueTask);

        $inTenDaysTask = (new \DoEveryApp\Entity\Task())
            ->setName(name: 'Test Task')
            ->setIntervalType(intervalType: \DoEveryApp\Definition\IntervalType::DAY->value)
            ->setIntervalValue(intervalValue: 12)
        ;
        $inTenDaysTask::getRepository()->create(entity: $inTenDaysTask);
        $inTenDaysTaskExecution = (new \DoEveryApp\Entity\Execution())
            ->setTask(task: $inTenDaysTask)
            ->setDate(date: new \DateTime(datetime: '2024-01-01 11:00:00'))
            ;
        $inTenDaysTaskExecution::getRepository()->create(entity: $inTenDaysTaskExecution);

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