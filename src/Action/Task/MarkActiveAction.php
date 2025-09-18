<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Task;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/task/active/{id:[0-9]+}/{active:[0-1]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class MarkActiveAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\Task;

    public static function getRoute(int $id, bool $active = true): string
    {
        $reflection = new \ReflectionClass(objectOrClass: __CLASS__);
        foreach ($reflection->getAttributes(name: \DoEveryApp\Attribute\Action\Route::class) as $attribute) {
            $route = '/task/active/' . $id;
            $route .= '/' . ($active ? '1' : '0');

            return $route;
        }

        throw new \RuntimeException(message: 'Could not determine route path');
    }

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (false === ($task = $this->getTask()) instanceof \DoEveryApp\Entity\Task) {
            return $task;
        }
        $task->setActive(active: '1' === $this->getArgumentSafe(argumentName: 'active'));
        \DoEveryApp\Entity\Task::getRepository()->update(entity: $task);
        \DoEveryApp\Util\DependencyContainer::getInstance()
                                            ->getEntityManager()
                                            ->flush()
        ;
        \DoEveryApp\Util\FlashMessenger::addSuccess(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->statusSet());

        if (null !== $this->getReferrer()) {
            return $this->redirect(to: $this->getReferrer());
        }

        return $this->redirect(to: \DoEveryApp\Action\Task\ShowAction::getRoute(id: $task->getId()));
    }
}
