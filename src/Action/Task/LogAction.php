<?php

namespace DoEveryApp\Action\Task;

#[\DoEveryApp\Attribute\Action\Route(
    path        : '/log',
    methods     : [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
    authRequired: false
)]
class LogAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        return $this->render('action/task/log', [
            'executions' => \DoEveryApp\Entity\Execution::getRepository()->findForIndex(),
        ]);
    }
}