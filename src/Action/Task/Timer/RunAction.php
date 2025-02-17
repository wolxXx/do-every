<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Task\Timer;


#[\DoEveryApp\Attribute\Action\Route(
    path   : '/task/timer/run/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class RunAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SingleIdRoute;
    use \DoEveryApp\Action\Share\Task;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (false === ($task = $this->getTask()) instanceof \DoEveryApp\Entity\Task) {
            return $task;
        }
        \DoEveryApp\Util\QueryLogger::$disabled = true;
        new \DoEveryApp\Util\Timer()->startOrContinue($task, \DoEveryApp\Util\User\Current::get());


        return \DoEveryApp\Util\JsonGateway::Factory([], $this->getResponse());
    }
}
