<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Cms;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/reset-dav',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class ResetDavAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (false === \DoEveryApp\Util\User\Current::get()->isAdmin()) {
            \DoEveryApp\Util\FlashMessenger::addDanger('You are not allowed to do this');

            return $this->redirect(to: ShowSettingsAction::getRoute());
        }
        \DoEveryApp\Util\Registry::getInstance()
                                 ->setDavUser(\Ramsey\Uuid\Uuid::uuid4()
                                                               ->toString())
                                 ->setDavPassword(\Ramsey\Uuid\Uuid::uuid4()
                                                                   ->toString())
        ;

        \DoEveryApp\Util\FlashMessenger::addSuccess(message: \DoEveryApp\Util\DependencyContainer::getInstance()
                                                                                                 ->getTranslator()
                                                                                                 ->settingsSaved());

        return $this->redirect(to: ShowSettingsAction::getRoute());
    }
}
