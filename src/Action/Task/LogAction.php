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
        $query = <<<SQL
select
    count(e.id) executions,
    sum(e.duration) sums,
    t.id as task_id,
    t.name as task_name,
    g.name as group_name,
    g.id as group_id
from
    do_every_task_execution e
    INNER JOIN do_every_task t ON t.id = e.task_id
    left join do_every_task_group g on g.id = t.group_id
where
    e.duration is not null
GROUP BY e.task_id
ORDER BY sums DESC;
SQL;

        $result = \DoEveryApp\Util\DependencyContainer::getInstance()
                                                      ->getEntityManager()
                                                      ->getConnection()
                                                      ->executeQuery(sql: $query)
        ;
        $data   = $result->fetchAllAssociative();

        return $this->render(script: 'action/task/log', data: [
            'executions' => \DoEveryApp\Entity\Execution::getRepository()
                                                        ->findForIndex(),
            'stats'      => $data,
        ]);
    }
}
