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
        $reflection = new \ReflectionClass(objectOrClass: __CLASS__);
        foreach ($reflection->getAttributes(name: \DoEveryApp\Attribute\Action\Route::class) as $attribute) {
            $route = '/worker/admin/' . $id;
            $route .= '/' . ($admin ? '1' : '0');

            return $route;
        }

        throw new \RuntimeException(message: 'Could not determine route path');
    }

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (false === ($worker = $this->getWorker()) instanceof \DoEveryApp\Entity\Worker) {
            return $worker;
        }
        if ($worker->getId() === \DoEveryApp\Util\User\Current::get()->getId()) {
            \DoEveryApp\Util\FlashMessenger::addDanger(message: $this->translator->itIsYou());

            return $this->redirect(to: \DoEveryApp\Action\Worker\IndexAction::getRoute());
        }
        $worker->setIsAdmin(admin: '1' === $this->getArgumentSafe(argumentName: 'admin'));
        $worker::getRepository()->update(entity: $worker);
        $this
            ->entityManager
            ->flush()
        ;
        \DoEveryApp\Util\FlashMessenger::addSuccess(message: $this->translator->setAdminFlag());

        return $this->redirect(to: \DoEveryApp\Action\Worker\IndexAction::getRoute());
    }
}
