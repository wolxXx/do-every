<?php

declare(strict_types = 1);

namespace DoEveryApp\Action\Task;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/task/add',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],)]
class AddAction
    extends
    \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Task\Share\AddEdit;
    use \DoEveryApp\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (true === $this->isGetRequest()) {
            return $this->render(
                script: 'action/task/add',
                data  : [
                            'data' => [
                                static::FORM_FIELD_INTERVAL_TYPE => \DoEveryApp\Definition\IntervalType::DAY->value,
                                static::FORM_FIELD_TASK_TYPE => \DoEveryApp\Definition\TaskType::RELATIVE->value,
                                static::FORM_FIELD_ENABLE_NOTIFICATIONS => 1,
                                static::FORM_FIELD_PRIORITY => \DoEveryApp\Definition\Priority::NORMAL->value,
                                static::FORM_FIELD_GROUP => (int)$this->getFromQuery(
                                    key    : 'group',
                                    default: 0,
                                ),
                            ],
                        ],
            );
        }
        $data = [];
        try {
            $data    = $this
                ->getRequest()
                ->getParsedBody()
            ;
            $data    = $this->filterAndValidate(data: $data);
            $newTask = \DoEveryApp\Service\Task\Creator::execute(
                bag: new \DoEveryApp\Service\Task\Creator\Bag()
                         ->setAssignee(
                             assignee: $data[static::FORM_FIELD_ASSIGNEE] ? \DoEveryApp\Entity\Worker::getRepository()
                                                                                                     ->find(id: $data[static::FORM_FIELD_ASSIGNEE]) : null,
                         )
                         ->setGroup(
                             group: $data[static::FORM_FIELD_GROUP] ? \DoEveryApp\Entity\Group::getRepository()
                                                                                              ->find(id: $data[static::FORM_FIELD_GROUP]) : null,
                         )
                         ->setName(name: $data[static::FORM_FIELD_NAME])
                         ->setIntervalType(intervalType: $data[static::FORM_FIELD_INTERVAL_TYPE] ? \DoEveryApp\Definition\IntervalType::from(value: $data[static::FORM_FIELD_INTERVAL_TYPE]) : null)
                         ->setIntervalValue(intervalValue: $data[static::FORM_FIELD_INTERVAL_VALUE])
                         ->setDueDate(dueDate: $data[static::FORM_FIELD_DUE_DATE])
                         ->setRemindDate(remindDate: $data[static::FORM_FIELD_REMIND_DATE])
                         ->setTaskType(taskType: \DoEveryApp\Definition\TaskType::from($data[static::FORM_FIELD_TASK_TYPE]))
                         ->setPriority(priority: \DoEveryApp\Definition\Priority::from(value: $data[static::FORM_FIELD_PRIORITY]))
                         ->enableNotifications(notify: '1' === $data[static::FORM_FIELD_ENABLE_NOTIFICATIONS])
                         ->setActive(active: true)
                         ->setNote(note: $data[static::FORM_FIELD_NOTE]),
            );
            $this->handleCheckListItems(
                task: $newTask,
                data: $data,
            );

            $this
                ->entityManager
                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess(
                message: \DoEveryApp\Util\DependencyContainer::getInstance()
                                                             ->getTranslator()
                                                             ->taskAdded(),
            );

            return $this->redirect(to: \DoEveryApp\Action\Task\ShowAction::getRoute(id: $newTask->getId()));
        } catch (\DoEveryApp\Exception\FormValidationFailed) {
        }

        return $this->render(
            script: 'action/task/add',
            data  : [
                        'data' => $data,
                    ],
        );
    }
}
