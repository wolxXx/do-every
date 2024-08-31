<?php

namespace DoEveryApp\Action\Worker;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/worker/admin/{id:[0-9]+}/{admin:[0-1]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class MarkAdminAction extends \DoEveryApp\Action\AbstractAction
{
    public static function getRoute(int $id, bool $admin = true): string
    {
        $reflection = new \ReflectionClass(__CLASS__);
        foreach ($reflection->getAttributes(\DoEveryApp\Attribute\Action\Route::class) as $attribute) {
            $route = '/worker/admin/' . $id;
            $route .= '/' . ($admin ? '1' : '0');

            return $route;
        }
    }


    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $worker = \DoEveryApp\Entity\Worker::getRepository()->find($this->getArgumentSafe());
        if (false === $worker instanceof \DoEveryApp\Entity\Worker) {
            \DoEveryApp\Util\FlashMessenger::addDanger('Worker nicht gefunden');

            return $this->redirect(\DoEveryApp\Action\Worker\IndexAction::getRoute());
        }
        if ($worker->getId() === \DoEveryApp\Util\User\Current::get()->getId()) {
            \DoEveryApp\Util\FlashMessenger::addDanger('Das bist du!');

            return $this->redirect(\DoEveryApp\Action\Worker\IndexAction::getRoute());
        }
        $worker->setIsAdmin('1' === $this->getArgumentSafe('admin'));
        $worker::getRepository()->update($worker);
        \DoEveryApp\Util\FlashMessenger::addSuccess('Admin-Flag erfolgreich gesetzt');

        return $this->redirect(\DoEveryApp\Action\Worker\IndexAction::getRoute());
    }
}