<?php

namespace DoEveryApp\Action\Worker;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/worker/log/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class LogAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SingleIdRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $worker = \DoEveryApp\Entity\Worker::getRepository()->find($this->getArgumentSafe());
        if (false === $worker instanceof \DoEveryApp\Entity\Worker) {
            \DoEveryApp\Util\FlashMessenger::addDanger('Worker nicht gefunden');

            return $this->redirect(\DoEveryApp\Action\Worker\IndexAction::getRoute());
        }


        return $this->render(
            'action/worker/log',
            [
                'worker' => $worker,
                'data' => \DoEveryApp\Entity\Execution::getRepository()->findForWorker($worker)
            ]);
    }
}