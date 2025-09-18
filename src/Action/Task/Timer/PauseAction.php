<?php

declare(strict_types = 1);

namespace DoEveryApp\Action\Task\Timer;


#[\DoEveryApp\Attribute\Action\Route(
    path   : '/task/timer/pause/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class PauseAction extends
    \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SingleIdRoute;
    use \DoEveryApp\Action\Share\Task;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (false === ($task = $this->getTask()) instanceof \DoEveryApp\Entity\Task) {
            return \DoEveryApp\Util\JsonGateway::Factory(response: $this->getResponse(), data: ['message' => 'task not found'], code: 404);
        }
        \DoEveryApp\Util\QueryLogger::$disabled = true;

        new \DoEveryApp\Util\Timer()->pause(task: $task, worker: \DoEveryApp\Util\User\Current::get());

        return \DoEveryApp\Util\JsonGateway::Factory(response: $this->getResponse());
    }
}
