<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Task;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/task/reset/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class ResetAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SingleIdRoute;
    use \DoEveryApp\Action\Share\Task;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (false === ($task = $this->getTask()) instanceof \DoEveryApp\Entity\Task) {
            return $task;
        }
        foreach ($task->getExecutions() as $execution) {
            $execution::getRepository()->delete($execution);
        }
        $task
            ->setActive(true)
            ->setNotify(true)
            ->setWorkingOn(null)
        ;
        \DoEveryApp\Entity\Task::getRepository()->update($task);
        $this
            ->entityManager
            ->flush()
        ;
        \DoEveryApp\Util\FlashMessenger::addSuccess($this->translator->taskReset());

        return $this->redirect(\DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()));
    }
}
