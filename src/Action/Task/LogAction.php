<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Task;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/log',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ]
)]
class LogAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        return $this->render(script: 'action/task/log', data: [
            'executions' => \DoEveryApp\Entity\Execution::getRepository()->findForIndex(),
        ]);
    }
}
