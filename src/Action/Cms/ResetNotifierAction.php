<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Cms;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/reset-notifier',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class ResetNotifierAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (false === \DoEveryApp\Util\User\Current::get()->isAdmin()) {
            \DoEveryApp\Util\FlashMessenger::addDanger(message:'You are not allowed to do this');

            return $this->redirect(to: ShowSettingsAction::getRoute());
        }
        \DoEveryApp\Util\Registry::getInstance()
                                 ->setNotifierLastRun(notifierLastRun: \Carbon\Carbon::now()->subYear())
                                 ->setNotifierRunning(notifierRunning: false)
        ;

        return $this->redirect(to: DebugAction::getRoute());
    }
}
