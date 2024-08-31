<?php

namespace DoEveryApp\Action\Task;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/task/active/{id:[0-9]+}/{active:[0-1]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class MarkActiveAction extends \DoEveryApp\Action\AbstractAction
{
    public static function getRoute(int $id, bool $active = true): string
    {
        $reflection = new \ReflectionClass(__CLASS__);
        foreach ($reflection->getAttributes(\DoEveryApp\Attribute\Action\Route::class) as $attribute) {
            $route = '/task/active/' . $id;
            $route .= '/' . ($active ? '1' : '0');

            return $route;
        }
    }


    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $task = \DoEveryApp\Entity\Task::getRepository()->find($this->getArgumentSafe());
        if (false === $task instanceof \DoEveryApp\Entity\Task) {
            \DoEveryApp\Util\FlashMessenger::addDanger('Aufgabe nicht gefunden');

            return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
        }
        $task->setActive('1' === $this->getArgumentSafe('active'));
        \DoEveryApp\Entity\Task::getRepository()->update($task);
        \DoEveryApp\Util\FlashMessenger::addSuccess('Status erfolgreich gesetzt');

        return $this->redirect(\DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()));
    }
}