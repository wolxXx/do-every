<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Group;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/group/delete/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class DeleteAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SingleIdRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $group = \DoEveryApp\Entity\Group::getRepository()->find($this->getArgumentSafe());
        if (false === $group instanceof \DoEveryApp\Entity\Group) {
            \DoEveryApp\Util\FlashMessenger::addDanger(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->groupNotFound());

            return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
        }

        $group::getRepository()->delete($group);

        \DoEveryApp\Util\DependencyContainer::getInstance()
                                            ->getEntityManager()
                                            ->flush()
        ;
        \DoEveryApp\Util\FlashMessenger::addSuccess(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->groupDeleted());

        return $this->redirect(\DoEveryApp\Action\Task\IndexAction::getRoute());
    }
}
