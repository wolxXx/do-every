<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Worker;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/worker/unset-passkey/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class UnsetPasskeyAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\Worker;
    use \DoEveryApp\Action\Share\SingleIdRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (false === ($worker = $this->getWorker()) instanceof \DoEveryApp\Entity\Worker) {
            return $worker;
        }
        if (false === $worker->isAdmin() || $worker->getId() !== \DoEveryApp\Util\User\Current::get()->getId()) {
            \DoEveryApp\Util\FlashMessenger::addDanger(message: $this->translator->itIsNotYou());

            return $this->redirect(to: \DoEveryApp\Action\Worker\IndexAction::getRoute());
        }
        $credential = $worker->getPasskeyCredential();
        if (true === $credential instanceof \DoEveryApp\Entity\Worker\Credential) {
            $credential::getRepository()->delete($credential);
            $this
                ->entityManager
                ->flush()
            ;
        }

        \DoEveryApp\Util\FlashMessenger::addSuccess(message: $this->translator->passkeyDeleted());

        return $this->redirect(to: \DoEveryApp\Action\Worker\IndexAction::getRoute());
    }
}
