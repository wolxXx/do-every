<?php

namespace DoEveryApp\Action\Cms;

#[\DoEveryApp\Attribute\Action\Route(
    path        : '/help',
    methods     : [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class HelpAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        return $this->render('action/cms/help');
    }
}