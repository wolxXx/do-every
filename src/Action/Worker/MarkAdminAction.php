<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Worker;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/worker/admin/{id:[0-9]+}/{admin:[0-1]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class MarkAdminAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\Worker;
    public static function getRoute(int $id, bool $admin = true): string
    {
        $reflection = new \ReflectionClass(__CLASS__);
        foreach ($reflection->getAttributes(\DoEveryApp\Attribute\Action\Route::class) as $attribute) {
            $route = '/worker/admin/' . $id;
            $route .= '/' . ($admin ? '1' : '0');

            return $route;
        }

        throw new \RuntimeException('Could not determine route path');
    }


    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (false === ($worker = $this->getWorker()) instanceof \DoEveryApp\Entity\Worker) {
            return $worker;
        }
        if ($worker->getId() === \DoEveryApp\Util\User\Current::get()->getId()) {
            \DoEveryApp\Util\FlashMessenger::addDanger($this->translator->itIsYou());

            return $this->redirect(\DoEveryApp\Action\Worker\IndexAction::getRoute());
        }
        $worker->setIsAdmin('1' === $this->getArgumentSafe('admin'));
        $worker::getRepository()->update($worker);
        $this
            ->entityManager
            ->flush()
        ;
        \DoEveryApp\Util\FlashMessenger::addSuccess($this->translator->setAdminFlag());

        return $this->redirect(\DoEveryApp\Action\Worker\IndexAction::getRoute());
    }
}