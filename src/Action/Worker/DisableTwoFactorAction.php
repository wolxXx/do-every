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
    use \DoEveryApp\Action\Share\Worker;
    use \DoEveryApp\Action\Share\SingleIdRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (false === ($worker = $this->getWorker()) instanceof \DoEveryApp\Entity\Worker) {
            return $worker;
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
        $this
            ->entityManager
            ->flush()
        ;
        \DoEveryApp\Util\FlashMessenger::addSuccess($this->translator->twoFactorDisabled());

        return $this->redirect(\DoEveryApp\Action\Worker\IndexAction::getRoute());
    }
}

