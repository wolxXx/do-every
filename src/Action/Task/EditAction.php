<?php

declare(strict_types = 1);

namespace DoEveryApp\Action\Task;

#[\DoEveryApp\Attribute\Action\Route(path: '/task/edit/{id:[0-9]+}', methods: [
    \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
    \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
],)]
class EditAction extends
    \DoEveryApp\Action\AbstractAction
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
                    static::FORM_FIELD_CHECK_LIST_ITEM_ID       => $checkListItem->getId(),
                    static::FORM_FIELD_CHECK_LIST_ITEM_NAME     => $checkListItem->getName(),
                    static::FORM_FIELD_CHECK_LIST_ITEM_NOTE     => $checkListItem->getNote(),
                    static::FORM_FIELD_CHECK_LIST_ITEM_POSITION => $checkListItem->getPosition(),
                ];
            }

            return $this->render(script: 'action/task/edit',
                                 data  : [
                                             'task' => $task,
                                             'data' => [
                                                 static::FORM_FIELD_CHECK_LIST_ITEM      => $checkListItems,
                                                 static::FORM_FIELD_NAME                 => $task->getName(),
                                                 static::FORM_FIELD_ASSIGNEE             => $task
                                                     ->getAssignee()
                                                     ?->getId(),
                                                 static::FORM_FIELD_GROUP                => $task
                                                     ->getGroup()
                                                     ?->getId(),
                                                 static::FORM_FIELD_INTERVAL_TYPE        => $task->getIntervalType(),
                                                 static::FORM_FIELD_INTERVAL_VALUE       => $task->getIntervalValue(),
                                                 static::FORM_FIELD_PRIORITY             => $task->getPriority(),
                                                 static::FORM_FIELD_ENABLE_NOTIFICATIONS => $task->isNotify() ? '1' : '0',
                                                 static::FORM_FIELD_TASK_TYPE            => $task->getType()->value,
                                                 static::FORM_FIELD_NOTE                 => $task->getNote(),
                                             ],
                                         ]);
        }
        $data = [];
        try {
            $data = $this
                ->getRequest()
                ->getParsedBody()
            ;
            $data = $this->filterAndValidate(data: $data);
            $task
                ->setAssignee(assignee: $data[static::FORM_FIELD_ASSIGNEE] ? \DoEveryApp\Entity\Worker::getRepository()
                                                                                                      ->find(id: $data[static::FORM_FIELD_ASSIGNEE]) : null)
                ->setGroup(group: $data[static::FORM_FIELD_GROUP] ? \DoEveryApp\Entity\Group::getRepository()
                                                                                            ->find(id: $data[static::FORM_FIELD_GROUP]) : null)
                ->setName(name: $data[static::FORM_FIELD_NAME])
                ->setIntervalType(intervalType: $data[static::FORM_FIELD_INTERVAL_TYPE] ? \DoEveryApp\Definition\IntervalType::from(value: $data[static::FORM_FIELD_INTERVAL_TYPE])->value : null)
                ->setIntervalValue(intervalValue: $data[static::FORM_FIELD_INTERVAL_VALUE])
                ->setPriority(priority: \DoEveryApp\Definition\Priority::from(value: $data[static::FORM_FIELD_PRIORITY])->value)
                ->setNotify(notify: '1' === $data[static::FORM_FIELD_ENABLE_NOTIFICATIONS])
                ->setType(type: \DoEveryApp\Definition\TaskType::from($data[static::FORM_FIELD_ELAPSING_CRON_TYPE]))
                ->setNote(note: $data[static::FORM_FIELD_NOTE])
            ;
            $task::getRepository()
                 ->update(entity: $task)
            ;

            $this->handleCheckListItems(task: $task, data: $data);

            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;

            \DoEveryApp\Util\FlashMessenger::addSuccess(message: \DoEveryApp\Util\DependencyContainer::getInstance()
                                                                                                     ->getTranslator()
                                                                                                     ->taskEdited());

            return $this->redirect(to: \DoEveryApp\Action\Task\ShowAction::getRoute(id: $task->getId()));
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }

        return $this->render(script: 'action/task/edit',
                             data  : [
                                         'task' => $task,
                                         'data' => $data,
                                     ]);
    }
}
