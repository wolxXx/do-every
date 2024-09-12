<?php

declare(strict_types=1);


namespace DoEveryApp\Action\Worker;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/worker/disable-two-factor/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class DisableTwoFactorAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SingleIdRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $worker = \DoEveryApp\Entity\Worker::getRepository()->find($this->getArgumentSafe());
        if (false === $worker instanceof \DoEveryApp\Entity\Worker) {
            \DoEveryApp\Util\FlashMessenger::addDanger('Worker nicht gefunden');

            return $this->redirect(\DoEveryApp\Action\Worker\IndexAction::getRoute());
        }

        $worker
            ->setTwoFactorSecret(null)
            ->setTwoFactorRecoverCode1(null)
            ->setTwoFactorRecoverCode2(null)
            ->setTwoFactorRecoverCode3(null)
            ->setTwoFactorRecoverCode1UsedAt(null)
            ->setTwoFactorRecoverCode2UsedAt(null)
            ->setTwoFactorRecoverCode3UsedAt(null)
        ;
        $worker::getRepository()->update($worker);
        \DoEveryApp\Util\DependencyContainer::getInstance()
                                            ->getEntityManager()
                                            ->flush()
        ;
        \DoEveryApp\Util\FlashMessenger::addSuccess('Zwei-Faktor-Authentifizierung erfolgreich entfernt.');

        return $this->redirect(\DoEveryApp\Action\Worker\IndexAction::getRoute());
    }
}

