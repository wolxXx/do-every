<?php

declare(strict_types=1);

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
        $execution = \DoEveryApp\Entity\Execution::getRepository()->find(id: $this->getArgumentSafe());
        if (false === $execution instanceof \DoEveryApp\Entity\Execution) {
            \DoEveryApp\Util\FlashMessenger::addDanger(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->executionNotFound());

            return $this->redirect(to: \DoEveryApp\Action\Cms\IndexAction::getRoute());
        }
        $task = $execution->getTask();
        $execution::getRepository()->delete(entity: $execution);
        \DoEveryApp\Util\DependencyContainer::getInstance()
                                            ->getEntityManager()
                                            ->flush()
        ;
        \DoEveryApp\Util\FlashMessenger::addSuccess(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->executionDeleted());

        return $this->redirect(to: \DoEveryApp\Action\Task\ShowAction::getRoute(id: $task->getId()));
    }
}
