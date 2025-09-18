<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Task;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/task/working/{id:[0-9]+}[/{worker:[0-9]+}]',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class MarkWorkingAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\Task;

    public static function getRoute(int $id, ?int $workingOn = null): string
    {
        $reflection = new \ReflectionClass(objectOrClass: __CLASS__);
        foreach ($reflection->getAttributes(name: \DoEveryApp\Attribute\Action\Route::class) as $attribute) {
            $route = '/task/working/' . $id;
            if (null !== $workingOn) {
                $route .= '/' . $workingOn;
            }

            return $route;
        }

        throw new \RuntimeException(message: 'Could not determine route path');
    }

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (false === ($task = $this->getTask()) instanceof \DoEveryApp\Entity\Task) {
            return $task;
        }
        try {
            $worker = \DoEveryApp\Entity\Worker::getRepository()->find(id: $this->getArgumentSafe(argumentName: 'worker'));
            if (false === $worker instanceof \DoEveryApp\Entity\Worker) {
                \DoEveryApp\Util\FlashMessenger::addDanger(message: $this->translator->workerNotFound());

                return $this->redirect(to: \DoEveryApp\Action\Cms\IndexAction::getRoute());
            }
            $task->setWorkingOn(workingOn: $worker);
            \DoEveryApp\Entity\Task::getRepository()->update(entity: $task);
            \DoEveryApp\Util\FlashMessenger::addSuccess(message: $this->translator->workerAssigned());
        } catch (\DoEveryApp\Exception\ArgumentNoSet $exception) {
            // ok, argument was not set...
            $task->setWorkingOn(workingOn: null);
            \DoEveryApp\Entity\Task::getRepository()->update(entity: $task);
            \DoEveryApp\Util\FlashMessenger::addSuccess(message: $this->translator->assignmentRemoved());
        }
        $this
            ->entityManager
            ->flush()
        ;

        return $this->redirect(to: \DoEveryApp\Action\Task\ShowAction::getRoute(id: $task->getId()));
    }
}
