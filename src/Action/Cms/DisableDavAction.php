<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Cms;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/disable-dav',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class DisableDavAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (false === \DoEveryApp\Util\User\Current::get()->isAdmin()) {
            \DoEveryApp\Util\FlashMessenger::addDanger('You are not allowed to do this');

            return $this->redirect(to: ShowSettingsAction::getRoute());
        }
        \DoEveryApp\Util\Registry::getInstance()
                                 ->setDavUser(davUser: null)
                                 ->setDavPassword(davPassword: null)
        ;

        \DoEveryApp\Util\FlashMessenger::addSuccess(message: \DoEveryApp\Util\DependencyContainer::getInstance()
                                                                                                 ->getTranslator()
                                                                                                 ->settingsSaved());

        return $this->redirect(to: ShowSettingsAction::getRoute());
    }
}
