<?php

namespace DoEveryApp\Action\Task;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/task/delete/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class DeleteAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SingleIdRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $task = \DoEveryApp\Entity\Task::getRepository()->find($this->getArgumentSafe());
        if (false === $task instanceof \DoEveryApp\Entity\Task) {
            \DoEveryApp\Util\FlashMessenger::addDanger('Aufgabe nicht gefunden');

            return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
        }

        $task::getRepository()->delete($task);
        \DoEveryApp\Util\DependencyContainer::getInstance()
                                            ->getEntityManager()
                                            ->flush()
        ;
        \DoEveryApp\Util\FlashMessenger::addSuccess('Aufgabe gelöscht.');

        return $this->redirect(\DoEveryApp\Action\Task\IndexAction::getRoute());
    }
}