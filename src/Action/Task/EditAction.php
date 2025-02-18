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

            return $this->render(script: 'action/task/edit', data: [
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
            $data = $this->filterAndValidate(data: $data);

            $task
                ->setAssignee(assignee: $data['assignee'] ? \DoEveryApp\Entity\Worker::getRepository()->find(id: $data['assignee']) : null)
                ->setGroup(group: $data['group'] ? \DoEveryApp\Entity\Group::getRepository()->find(id: $data['group']) : null)
                ->setName(name: $data['name'])
                ->setIntervalType(intervalType: $data['intervalType'] ? \DoEveryApp\Definition\IntervalType::from(value: $data['intervalType'])->value : null)
                ->setIntervalValue(intervalValue: $data['intervalValue'])
                ->setPriority(priority: \DoEveryApp\Definition\Priority::from(value: $data['priority'])->value)
                ->setNotify(notify: '1' === $data['enableNotifications'])
                ->setElapsingCronType(elapsingCronType: '1' === $data['elapsingCronType'])
                ->setNote(note: $data['note'])
            ;
            $task::getRepository()->update(entity: $task);

            $this->handleCheckListItems(task: $task, data: $data);

            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;

            \DoEveryApp\Util\FlashMessenger::addSuccess(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->taskEdited());

            return $this->redirect(to: \DoEveryApp\Action\Task\ShowAction::getRoute(id: $task->getId()));
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }

        return $this->render(
            script: 'action/task/edit',
            data  : [
                        'task' => $task,
                        'data' => $data,
                    ]
        );
    }
}
