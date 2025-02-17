<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Task\Timer;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/timer/all',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class IndexAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $timers = \DoEveryApp\Entity\Task\Timer::getRepository()
            ->createQueryBuilder('t')
            ->orderBy('t.id', 'DESC')
            ->getQuery()
            ->execute()
        ;

        return $this->render('action/task/timer/index', ['timers' => $timers]);
    }
}
