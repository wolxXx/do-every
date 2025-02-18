<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Execution;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/execution/add/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class AddAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SingleIdRoute;
    use \DoEveryApp\Action\Execution\Share\AddEdit;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $task = \DoEveryApp\Entity\Task::getRepository()->find(id: $this->getArgumentSafe());
        if (false === $task instanceof \DoEveryApp\Entity\Task) {
            \DoEveryApp\Util\FlashMessenger::addDanger(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->taskNotFound());

            return $this->redirect(to: \DoEveryApp\Action\Cms\IndexAction::getRoute());
        }

        if (true === $this->isGetRequest()) {
            $checkListItemData = [];
            foreach ($task->getCheckListItems() as $checkListItem) {
                $checkListItemData[] = [
                    static::FORM_FIELD_CHECK_LIST_ITEM_ID             => null,
                    static::FORM_FIELD_CHECK_LIST_ITEM_REFERENCE      => $checkListItem->getId(),
                    static::FORM_FIELD_CHECK_LIST_ITEM_REFERENCE_NOTE => $checkListItem->getNote(),
                    static::FORM_FIELD_CHECK_LIST_ITEM_NAME           => $checkListItem->getName(),
                    static::FORM_FIELD_CHECK_LIST_ITEM_NOTE           => null,
                    static::FORM_FIELD_CHECK_LIST_ITEM_CHECKED        => false,
                ];
            }

            return $this->render(
                script: 'action/execution/add',
                data: [
                    'execution' => null,
                    'task'      => $task,
                    'data'      => [
                        static::FORM_FIELD_DATE             => (new \DateTime())->format(format: 'Y-m-d H:i:s'),
                        static::FORM_FIELD_WORKER           => \DoEveryApp\Util\User\Current::get()->getId(),
                        static::FORM_FIELD_CHECK_LIST_ITEMS => $checkListItemData,
                    ],
                ]
            );
        }

        $data = [];
        try {
            $data = $this->getRequest()->getParsedBody();
            $data = $this->filterAndValidate(data: $data);

            $execution = \DoEveryApp\Service\Task\Execution\Creator::execute(
                bag: (new \DoEveryApp\Service\Task\Execution\Creator\Bag())
                    ->setTask(task: $task)
                    ->setDuration(duration: $data[static::FORM_FIELD_DURATION])
                    ->setDate(date: new \DateTime(datetime: $data[static::FORM_FIELD_DATE]))
                    ->setNote(note: $data[static::FORM_FIELD_NOTE])
                    ->setWorker(worker: $data[static::FORM_FIELD_WORKER] ? \DoEveryApp\Entity\Worker::getRepository()->find(id: $data[static::FORM_FIELD_WORKER]) : null)
            );
            $this->handleCheckListItems(execution: $execution, data: $data);

            $now      = \Carbon\Carbon::now();
            $executed = \Carbon\Carbon::create(year: $execution->getDate());
            if (\abs(num: $now->unix() - $executed->unix()) < 120) {
                $task->setWorkingOn(workingOn: null);
                $task::getRepository()->update(entity: $task);
            }

            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->executionAdded());

            return $this->redirect(to: \DoEveryApp\Action\Task\ShowAction::getRoute(id: $task->getId()));
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }

        return $this->render(
            script: 'action/execution/add',
            data: [
                'execution' => null,
                'task'      => $task,
                'data'      => $data,
            ]
        );
    }
}
