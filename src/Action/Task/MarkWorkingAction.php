<?php

namespace DoEveryApp\Action\Task;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/task/working/{id:[0-9]+}[/{worker:[0-9]+}]',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class MarkWorkingAction extends \DoEveryApp\Action\AbstractAction
{
    public static function getRoute(int $id, ?int $workingOn = null): string
    {
        $reflection = new \ReflectionClass(__CLASS__);
        foreach ($reflection->getAttributes(\DoEveryApp\Attribute\Action\Route::class) as $attribute) {
            $route = '/task/working/' . $id;
            if (null !== $workingOn) {
                $route .= '/' . $workingOn;
            }

            return $route;
        }

        throw new \RuntimeException('Could not determine route path');
    }


    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $task = \DoEveryApp\Entity\Task::getRepository()->find($this->getArgumentSafe());
        if (false === $task instanceof \DoEveryApp\Entity\Task) {
            \DoEveryApp\Util\FlashMessenger::addDanger('Aufgabe nicht gefunden');

            return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
        }
        try {
            $worker = \DoEveryApp\Entity\Worker::getRepository()->find($this->getArgumentSafe('worker'));
            if (false === $worker instanceof \DoEveryApp\Entity\Worker) {
                \DoEveryApp\Util\FlashMessenger::addDanger('Mitarbeiter nicht gefunden');

                return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
            }
            $task->setWorkingOn($worker);
            \DoEveryApp\Entity\Task::getRepository()->update($task);
            \DoEveryApp\Util\FlashMessenger::addSuccess('Mitarbeiter erfolgreich zugewiesen');
        } catch (\DoEveryApp\Exception\ArgumentNoSet $exception) {
            // ok, argument was not set...
            $task->setWorkingOn(null);
            \DoEveryApp\Entity\Task::getRepository()->update($task);
            \DoEveryApp\Util\FlashMessenger::addSuccess('Markierung erfolgreich entfernt');
        }
        return $this->redirect(\DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()));
    }
}