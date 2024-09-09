<?php

namespace DoEveryApp\Action\Task;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/task/add',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class AddAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Task\Share\AddEdit;
    use \DoEveryApp\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (true === $this->isGetRequest()) {
            return $this->render('action/task/add', [
                'data' => [
                    'group' => (int )$this->getFromQuery('group', 0),
                ],
            ]);
        }
        $data = [];
        try {
            $data    = $this->getRequest()->getParsedBody();
            $data    = $this->filterAndValidate($data);
            $newTask = \DoEveryApp\Service\Task\Creator::execute(
                (new \DoEveryApp\Service\Task\Creator\Bag())
                    ->setAssignee($data['assignee'] ? \DoEveryApp\Entity\Worker::getRepository()->find($data['assignee']) : null)
                    ->setGroup($data['group'] ? \DoEveryApp\Entity\Group::getRepository()->find($data['group']) : null)
                    ->setName($data['name'])
                    ->setIntervalType($data['intervalType'] ? \DoEveryApp\Definition\IntervalType::from($data['intervalType']) : null)
                    ->setIntervalValue($data['intervalValue'])
                    ->setElapsingCronType('1' === $data['elapsingCronType'])
                    ->setPriority(\DoEveryApp\Definition\Priority::from($data['priority']))
                    ->enableNotifications('1' === $data['enableNotifications'])
                    ->setActive(true)
                    ->setNote($data['note'])
            );
            $this->handleCheckListItems($newTask, $data);

            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess('Aufgabe erstellt.');

            return $this->redirect(\DoEveryApp\Action\Task\ShowAction::getRoute($newTask->getId()));
        } catch (\Throwable $exception) {
            \var_dump($data);
            #die('');
            throw $exception;
        }


        return $this->render('action/task/add', ['data' => $data]);
    }
}