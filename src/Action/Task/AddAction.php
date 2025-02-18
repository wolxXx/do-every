<?php

declare(strict_types=1);

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
            return $this->render(script: 'action/task/add', data: [
                'data' => [
                    'group' => (int )$this->getFromQuery(key: 'group', default: 0),
                ],
            ]);
        }
        $data = [];
        try {
            $data    = $this->getRequest()->getParsedBody();
            $data    = $this->filterAndValidate(data: $data);
            $newTask = \DoEveryApp\Service\Task\Creator::execute(
                bag: (new \DoEveryApp\Service\Task\Creator\Bag())
                    ->setAssignee(assignee: $data['assignee'] ? \DoEveryApp\Entity\Worker::getRepository()->find(id: $data['assignee']) : null)
                    ->setGroup(group: $data['group'] ? \DoEveryApp\Entity\Group::getRepository()->find(id: $data['group']) : null)
                    ->setName(name: $data['name'])
                    ->setIntervalType(intervalType: $data['intervalType'] ? \DoEveryApp\Definition\IntervalType::from(value: $data['intervalType']) : null)
                    ->setIntervalValue(intervalValue: $data['intervalValue'])
                    ->setElapsingCronType(elapsingCronType: '1' === $data['elapsingCronType'])
                    ->setPriority(priority: \DoEveryApp\Definition\Priority::from(value: $data['priority']))
                    ->enableNotifications(notify: '1' === $data['enableNotifications'])
                    ->setActive(active: true)
                    ->setNote(note: $data['note'])
            );
            $this->handleCheckListItems(task: $newTask, data: $data);

            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->taskAdded());

            return $this->redirect(to: \DoEveryApp\Action\Task\ShowAction::getRoute(id: $newTask->getId()));
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }

        return $this->render(script: 'action/task/add', data: ['data' => $data]);
    }
}
