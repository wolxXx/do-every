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
            ->setTwoFactorSecret(twoFactorSecret: null)
            ->setTwoFactorRecoverCode1(twoFactorRecoverCode1: null)
            ->setTwoFactorRecoverCode2(twoFactorRecoverCode2: null)
            ->setTwoFactorRecoverCode3(twoFactorRecoverCode3: null)
            ->setTwoFactorRecoverCode1UsedAt(twoFactorRecoverCode1UsedAt: null)
            ->setTwoFactorRecoverCode2UsedAt(twoFactorRecoverCode2UsedAt: null)
            ->setTwoFactorRecoverCode3UsedAt(twoFactorRecoverCode3UsedAt: null)
        ;
        $worker::getRepository()->update(entity: $worker);
        $this
            ->entityManager
            ->flush()
        ;
        \DoEveryApp\Util\FlashMessenger::addSuccess(message: $this->translator->twoFactorDisabled());

        return $this->redirect(to: \DoEveryApp\Action\Worker\IndexAction::getRoute());
    }
}
