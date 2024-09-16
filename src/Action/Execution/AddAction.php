<?php

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
        $task = \DoEveryApp\Entity\Task::getRepository()->find($this->getArgumentSafe());
        if (false === $task instanceof \DoEveryApp\Entity\Task) {
            \DoEveryApp\Util\FlashMessenger::addDanger(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->taskNotFound());

            return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
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
                'action/execution/add',
                [
                    'data' => [
                        static::FORM_FIELD_DATE             => (new \DateTime())->format('Y-m-d H:i:s'),
                        static::FORM_FIELD_WORKER           => \DoEveryApp\Util\User\Current::get()->getId(),
                        static::FORM_FIELD_CHECK_LIST_ITEMS => $checkListItemData,
                    ],
                    'task' => $task,
                ]
            );
        }

        $data = [];
        try {
            $data = $this->getRequest()->getParsedBody();
            $data = $this->filterAndValidate($data);

            $execution = \DoEveryApp\Service\Task\Execution\Creator::execute(
                (new \DoEveryApp\Service\Task\Execution\Creator\Bag())
                    ->setTask($task)
                    ->setDuration($data[static::FORM_FIELD_DURATION])
                    ->setDate(new \DateTime($data[static::FORM_FIELD_DATE]))
                    ->setNote($data[static::FORM_FIELD_NOTE])
                    ->setWorker($data[static::FORM_FIELD_WORKER] ? \DoEveryApp\Entity\Worker::getRepository()->find($data[static::FORM_FIELD_WORKER]) : null)
            );
            $this->handleCheckListItems($execution, $data);

            $now      = \Carbon\Carbon::now();
            $executed = \Carbon\Carbon::create($execution->getDate());
            if (\abs($now->unix() - $executed->unix()) < 120) {
                $task->setWorkingOn(null);
                $task::getRepository()->update($task);
            }

            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->executionAdded());

            return $this->redirect(\DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()));
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }

        return $this->render(
            'action/execution/add',
            [
                'data' => $data,
                'task' => $task,
            ]
        );
    }
}