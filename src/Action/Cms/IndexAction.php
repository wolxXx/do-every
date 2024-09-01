<?php

namespace DoEveryApp\Action\Cms;

#[\DoEveryApp\Attribute\Action\Route(
    path        : '/',
    methods     : [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
    authRequired: false
)]
class IndexAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (false === \DoEveryApp\Util\User\Current::isAuthenticated()) {
            return $this->render('action/cms/index');
        }

        return $this->render('action/cms/dashboard', [
            'executions'        => \DoEveryApp\Entity\Execution::getRepository()->findForIndex(),
            'tasks'             => \DoEveryApp\Entity\Task::getRepository()->findForIndex(),
            'tasksWithoutGroup' => \DoEveryApp\Entity\Task::getRepository()->getWithoutGroup(),
            'groups'            => \DoEveryApp\Entity\Group::getRepository()->findAll(),
            'workers'           => \DoEveryApp\Entity\Worker::getRepository()->findAll(),
            'workingOn'         => \DoEveryApp\Entity\Task::getRepository()->getWorkingOn(),
        ]);
    }
}