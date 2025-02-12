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
        $execution = \DoEveryApp\Entity\Execution::getRepository()->find($this->getArgumentSafe());
        if (false === $execution instanceof \DoEveryApp\Entity\Execution) {
            \DoEveryApp\Util\FlashMessenger::addDanger(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->executionNotFound());

            return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
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
                'action/execution/edit',
                [
                    'execution' => $execution,
                    'task'      => $execution->getTask(),
                    'data'      => [
                        static::FORM_FIELD_DATE             => $execution->getDate()->format('Y-m-d H:i:s'),
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
            $data = $this->filterAndValidate($data);
            $execution
                ->setDuration($data[static::FORM_FIELD_DURATION])
                ->setDate(new \DateTime($data[static::FORM_FIELD_DATE]))
                ->setNote($data[static::FORM_FIELD_NOTE])
                ->setWorker($data[static::FORM_FIELD_WORKER] ? \DoEveryApp\Entity\Worker::getRepository()->find($data[static::FORM_FIELD_WORKER]) : null)
            ;
            $execution::getRepository()->update($execution);

            foreach ($data[static::FORM_FIELD_CHECK_LIST_ITEMS] ?? [] as $item) {
                $checkListItem = \DoEveryApp\Entity\Execution\CheckListItem::getRepository()->find($item[static::FORM_FIELD_CHECK_LIST_ITEM_ID]);
                if (false === $checkListItem instanceof \DoEveryApp\Entity\Execution\CheckListItem) {
                    continue;
                }
                $checkListItem
                    ->setChecked('1' === $item[static::FORM_FIELD_CHECK_LIST_ITEM_CHECKED])
                    ->setNote($item[static::FORM_FIELD_CHECK_LIST_ITEM_NOTE])
                ;
                $checkListItem::getRepository()->update($checkListItem);
            }

            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->executionEdited());

            return $this->redirect(\DoEveryApp\Action\Task\ShowAction::getRoute($execution->getTask()->getId()));
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }

        return $this->render(
            'action/execution/edit',
            [
                'execution' => $execution,
                'task'      => $execution->getTask(),
                'data'      => $data,
            ]
        );
    }
}
