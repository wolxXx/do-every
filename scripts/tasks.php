<?php

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';


#[\Symfony\Component\Console\Attribute\AsCommand(name: 'task:list')]
class TaskListCommand extends \Symfony\Component\Console\Command\Command
{
    public function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output): int
    {
        $table = new \Symfony\Component\Console\Helper\Table(output: $output);
        $table->setHeaders(headers: [
                                        'id',
                                        'active',
                                        'group',
                                        'name',
                                        'interval type',
                                        'interval value',
                                        'assignee',
                                        'working on',
                                        'due date',
                                        'due value',
                                        'due unit',
                                        'last execution',
                                    ]);

        $lastGroup = -1;
        $hasGroup = false;
        foreach (\DoEveryApp\Entity\Task::getRepository()->findAllForIndex() as $task) {
            $hasGroup = null !== $task->getGroup();
            if ($hasGroup && $lastGroup !== $task->getGroup()?->getId()) {
                $lastGroup = $task->getGroup()?->getId();
                $table->addRow(row: new \Symfony\Component\Console\Helper\TableSeparator());
            }

            $lastExecution = null;
            foreach (\DoEveryApp\Entity\Execution::getRepository()->findIndexed($task) as $execution) {
                $lastExecution = $execution;
                break;
            }
            $table->addRow(
                row: [
                         $task->getId(),
                         $task->isActive() ? 'yes' : 'no',
                         $task->getGroup()?->getName() ?? '-',
                         $task->getName(),
                         $task->getIntervalType() ?? '-',
                         $task->getIntervalValue() ?? '-',
                         $task->getAssignee()?->getName() ?? '-',
                         $task->getWorkingOn()?->getName() ?? '-',
                         $task->getDueDate()?->format('Y-m-d H:i:s') ?? '-',
                         $task->getDueValue() ?? '-',
                         $task->getDueUnit() ?? '-',
                         $lastExecution?->getDate()->format('Y-m-d H:i:s') ?? '-',
                     ],
            );

        }



        $table->render();
        return 0;
    }
}

$application = new \Symfony\Component\Console\Application(name: 'task', version: '1.0.0');
$application->addCommand(new TaskListCommand());
$application->run();