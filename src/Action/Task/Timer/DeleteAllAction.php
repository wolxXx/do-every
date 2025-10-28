<?php

declare(strict_types = 1);

namespace DoEveryApp\Action\Task\Timer;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/task/timer/delete-all',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class DeleteAllAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {

        \DoEveryApp\Util\QueryLogger::$disabled = true;
        \DoEveryApp\Entity\Task\Timer::getRepository()->deleteAll();
        $this
            ->entityManager
            ->flush()
            ;

        \DoEveryApp\Util\FlashMessenger::addSuccess(message: \DoEveryApp\Util\DependencyContainer::getInstance()
                                                                                                 ->getTranslator()
                                                                                                 ->allTimersDeleted())
        ;



        return $this->redirect(IndexAction::getRoute());
    }
}
