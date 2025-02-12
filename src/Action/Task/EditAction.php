<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Task;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/task/edit/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class EditAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Task\Share\AddEdit;
    use \DoEveryApp\Action\Share\SingleIdRoute;
    use \DoEveryApp\Action\Share\Task;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (false === ($task = $this->getTask()) instanceof \DoEveryApp\Entity\Task) {
            return $task;
        }
        if (true === $this->isGetRequest()) {
            $checkListItems = [];
            foreach ($task->getCheckListItems() as $checkListItem) {
                $checkListItems[] = [
                    'id'       => $checkListItem->getId(),
                    'name'     => $checkListItem->getName(),
                    'note'     => $checkListItem->getNote(),
                    'position' => $checkListItem->getPosition(),
                ];
            }

            return $this->render('action/task/edit', [
                'task' => $task,
                'data' => [
                    'checkListItem'       => $checkListItems,
                    'name'                => $task->getName(),
                    'assignee'            => $task->getAssignee()?->getId(),
                    'group'               => $task->getGroup()?->getId(),
                    'intervalType'        => $task->getIntervalType(),
                    'intervalValue'       => $task->getIntervalValue(),
                    'priority'            => $task->getPriority(),
                    'enableNotifications' => $task->isNotify() ? '1' : '0',
                    'elapsingCronType'    => $task->isElapsingCronType() ? '1' : '0',
                    'note'                => $task->getNote(),
                ],
            ]);
        }
        $data = [];
        try {
            $data = $this->getRequest()->getParsedBody();
            $data = $this->filterAndValidate($data);

            $task
                ->setAssignee($data['assignee'] ? \DoEveryApp\Entity\Worker::getRepository()->find($data['assignee']) : null)
                ->setGroup($data['group'] ? \DoEveryApp\Entity\Group::getRepository()->find($data['group']) : null)
                ->setName($data['name'])
                ->setIntervalType($data['intervalType'] ? \DoEveryApp\Definition\IntervalType::from($data['intervalType'])->value : null)
                ->setIntervalValue($data['intervalValue'])
                ->setPriority(\DoEveryApp\Definition\Priority::from($data['priority'])->value)
                ->setNotify('1' === $data['enableNotifications'])
                ->setElapsingCronType('1' === $data['elapsingCronType'])
                ->setNote($data['note'])
            ;
            $task::getRepository()->update($task);

            $this->handleCheckListItems($task, $data);

            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;

            \DoEveryApp\Util\FlashMessenger::addSuccess(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->taskEdited());

            return $this->redirect(\DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()));
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }

        return $this->render(
            'action/task/edit',
            [
                'task' => $task,
                'data' => $data,
            ]
        );
    }
}
