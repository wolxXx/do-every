<?php

namespace DoEveryApp\Action\Worker;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/worker/unset-password/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class UnsetPasswordAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SingleIdRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $worker = \DoEveryApp\Entity\Worker::getRepository()->find($this->getArgumentSafe());
        if (false === $worker instanceof \DoEveryApp\Entity\Worker) {
            \DoEveryApp\Util\FlashMessenger::addDanger('Worker nicht gefunden');

            return $this->redirect(\DoEveryApp\Action\Worker\IndexAction::getRoute());
        }
        if($worker->getId() === \DoEveryApp\Util\User\Current::get()->getId()) {
            \DoEveryApp\Util\FlashMessenger::addDanger('Das bist du!');

            return $this->redirect(\DoEveryApp\Action\Worker\IndexAction::getRoute());
        }
        $worker->setPassword(null);
        $worker::getRepository()->update($worker);
        \DoEveryApp\Util\DependencyContainer::getInstance()
                                            ->getEntityManager()
                                            ->flush()
        ;
        \DoEveryApp\Util\FlashMessenger::addSuccess('Passwort gelöscht.');

        return $this->redirect(\DoEveryApp\Action\Worker\IndexAction::getRoute());
    }
}