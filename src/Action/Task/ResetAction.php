<?php

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

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $task = \DoEveryApp\Entity\Task::getRepository()->find($this->getArgumentSafe());
        if (false === $task instanceof \DoEveryApp\Entity\Task) {
            \DoEveryApp\Util\FlashMessenger::addDanger('Aufgabe nicht gefunden');

            return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
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
        \DoEveryApp\Util\FlashMessenger::addSuccess('Aufgabe zurückgesetzt.');

        return $this->redirect(\DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()));
    }
}