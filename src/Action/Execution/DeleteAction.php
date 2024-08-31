<?php

namespace DoEveryApp\Action\Execution;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/execution/delete/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class DeleteAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SingleIdRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $execution = \DoEveryApp\Entity\Execution::getRepository()->find($this->getArgumentSafe());
        if (false === $execution instanceof \DoEveryApp\Entity\Execution) {
            \DoEveryApp\Util\FlashMessenger::addDanger('Ausführung nicht gefunden');

            return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
        }
        $task = $execution->getTask();
        $execution::getRepository()->delete($execution);
        \DoEveryApp\Util\DependencyContainer::getInstance()
                                            ->getEntityManager()
                                            ->flush()
        ;
        \DoEveryApp\Util\FlashMessenger::addSuccess('Ausführung gelöscht.');

        return $this->redirect(\DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()));
    }
}