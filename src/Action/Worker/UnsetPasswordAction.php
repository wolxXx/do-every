<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Worker;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/worker/unset-password/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class UnsetPasswordAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\Worker;
    use \DoEveryApp\Action\Share\SingleIdRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (false === ($worker = $this->getWorker()) instanceof \DoEveryApp\Entity\Worker) {
            return $worker;
        }
        if ($worker->getId() === \DoEveryApp\Util\User\Current::get()->getId()) {
            \DoEveryApp\Util\FlashMessenger::addDanger($this->translator->itIsYou());

            return $this->redirect(\DoEveryApp\Action\Worker\IndexAction::getRoute());
        }
        $worker
            ->setPassword(null)
            ->setLastPasswordChange(null)
        ;
        $worker::getRepository()->update($worker);
        $this
            ->entityManager
            ->flush()
        ;
        \DoEveryApp\Util\FlashMessenger::addSuccess($this->translator->passwordDeleted());

        return $this->redirect(\DoEveryApp\Action\Worker\IndexAction::getRoute());
    }
}
