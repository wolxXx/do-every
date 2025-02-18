<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Execution;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/execution/edit/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class EditAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SingleIdRoute;
    use \DoEveryApp\Action\Execution\Share\AddEdit;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $execution = \DoEveryApp\Entity\Execution::getRepository()->find(id: $this->getArgumentSafe());
        if (false === $execution instanceof \DoEveryApp\Entity\Execution) {
            \DoEveryApp\Util\FlashMessenger::addDanger(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->executionNotFound());

            return $this->redirect(to: \DoEveryApp\Action\Cms\IndexAction::getRoute());
        }

        if (true === $this->isGetRequest()) {
            $checkListItemData = [];
            foreach ($execution->getCheckListItems() as $checkListItem) {
                $checkListItemData[] = [
                    static::FORM_FIELD_CHECK_LIST_ITEM_ID             => $checkListItem->getId(),
                    static::FORM_FIELD_CHECK_LIST_ITEM_REFERENCE      => $checkListItem->getCheckListItem()?->getId(),
                    static::FORM_FIELD_CHECK_LIST_ITEM_REFERENCE_NOTE => $checkListItem->getCheckListItem()?->getNote(),
                    static::FORM_FIELD_CHECK_LIST_ITEM_NAME           => $checkListItem->getName(),
                    static::FORM_FIELD_CHECK_LIST_ITEM_NOTE           => $checkListItem->getNote(),
                    static::FORM_FIELD_CHECK_LIST_ITEM_CHECKED        => $checkListItem->isChecked() ? '1' : '0',
                ];
            }

            return $this->render(
                script: 'action/execution/edit',
                data: [
                    'execution' => $execution,
                    'task'      => $execution->getTask(),
                    'data'      => [
                        static::FORM_FIELD_DATE             => $execution->getDate()->format(format: 'Y-m-d H:i:s'),
                        static::FORM_FIELD_WORKER           => $execution->getWorker()?->getId(),
                        static::FORM_FIELD_NOTE             => $execution->getNote(),
                        static::FORM_FIELD_DURATION         => $execution->getDuration(),
                        static::FORM_FIELD_CHECK_LIST_ITEMS => $checkListItemData,
                    ],
                ]
            );
        }

        $data = [];
        try {
            $data = $this->getRequest()->getParsedBody();
            $data = $this->filterAndValidate(data: $data);
            $execution
                ->setDuration(duration: $data[static::FORM_FIELD_DURATION])
                ->setDate(date: new \DateTime(datetime: $data[static::FORM_FIELD_DATE]))
                ->setNote(note: $data[static::FORM_FIELD_NOTE])
                ->setWorker(worker: $data[static::FORM_FIELD_WORKER] ? \DoEveryApp\Entity\Worker::getRepository()->find(id: $data[static::FORM_FIELD_WORKER]) : null)
            ;
            $execution::getRepository()->update(entity: $execution);

            foreach ($data[static::FORM_FIELD_CHECK_LIST_ITEMS] ?? [] as $item) {
                $checkListItem = \DoEveryApp\Entity\Execution\CheckListItem::getRepository()->find(id: $item[static::FORM_FIELD_CHECK_LIST_ITEM_ID]);
                if (false === $checkListItem instanceof \DoEveryApp\Entity\Execution\CheckListItem) {
                    continue;
                }
                $checkListItem
                    ->setChecked(checked: '1' === $item[static::FORM_FIELD_CHECK_LIST_ITEM_CHECKED])
                    ->setNote(note: $item[static::FORM_FIELD_CHECK_LIST_ITEM_NOTE])
                ;
                $checkListItem::getRepository()->update(entity: $checkListItem);
            }

            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->executionEdited());

            return $this->redirect(to: \DoEveryApp\Action\Task\ShowAction::getRoute(id: $execution->getTask()->getId()));
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }

        return $this->render(
            script: 'action/execution/edit',
            data: [
                'execution' => $execution,
                'task'      => $execution->getTask(),
                'data'      => $data,
            ]
        );
    }
}
