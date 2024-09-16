<?php

namespace DoEveryApp\Action\Group;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/group/show/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class ShowAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SingleIdRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $group = \DoEveryApp\Entity\Group::getRepository()->find($this->getArgumentSafe());
        if (false === $group instanceof \DoEveryApp\Entity\Group) {
            \DoEveryApp\Util\FlashMessenger::addDanger(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->groupNotFound());

            return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
        }

        return $this->render('action/group/show', [
            'group' => $group,
        ]);
    }
}