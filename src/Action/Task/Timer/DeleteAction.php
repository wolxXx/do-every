<?php

declare(strict_types = 1);

namespace DoEveryApp\Action\Task\Timer;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/task/timer/delete/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class DeleteAction extends
    \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SingleIdRoute;
    use \DoEveryApp\Action\Share\Task;

    public function run(): \Psr\Http\Message\ResponseInterface
    {

        $timer = \DoEveryApp\Entity\Task\Timer::getRepository()->find(id: $this->getArgumentSafe());

        if (false === $timer instanceof \DoEveryApp\Entity\Task\Timer) {
            return $this->redirect(IndexAction::getRoute());
        }
        \DoEveryApp\Util\QueryLogger::$disabled = true;

        $timer::getRepository()->delete(entity: $timer);

        $this
            ->entityManager
            ->flush()
            ;

        \DoEveryApp\Util\FlashMessenger::addSuccess(message: \DoEveryApp\Util\DependencyContainer::getInstance()
                                                                                                 ->getTranslator()
                                                                                                 ->timerDeleted())
        ;



        return $this->redirect(IndexAction::getRoute());
    }
}
