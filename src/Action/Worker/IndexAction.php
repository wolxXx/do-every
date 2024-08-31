<?php

namespace DoEveryApp\Action\Worker;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/workers',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class IndexAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        return $this->render('action/worker/index');
    }
}