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

    public const string FORM_FIELD_DURATION                       = 'duration';

    public const string FORM_FIELD_NOTE                           = 'note';

    public const string FORM_FIELD_DATE                           = 'date';

    public const string FORM_FIELD_WORKER                         = 'worker';

    public const string FORM_FIELD_CHECK_LIST_ITEMS               = 'checkListItems';

    public const string FORM_FIELD_CHECK_LIST_ITEM_ID             = 'id';

    public const string FORM_FIELD_CHECK_LIST_ITEM_CHECKED        = 'checked';

    public const string FORM_FIELD_CHECK_LIST_ITEM_NAME           = 'name';

    public const string FORM_FIELD_CHECK_LIST_ITEM_NOTE           = 'note';

    public const string FORM_FIELD_CHECK_LIST_ITEM_REFERENCE      = 'reference';

    public const string FORM_FIELD_CHECK_LIST_ITEM_REFERENCE_NOTE = 'referenceNote';


    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $task = \DoEveryApp\Entity\Task::getRepository()->find($this->getArgumentSafe());
        if (false === $task instanceof \DoEveryApp\Entity\Task) {
            \DoEveryApp\Util\FlashMessenger::addDanger('Aufgabe nicht gefunden');

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
            foreach ($data[static::FORM_FIELD_CHECK_LIST_ITEMS] ?? [] as $item) {
                $checkListItemReference = \DoEveryApp\Entity\Task\CheckListItem::getRepository()->find($item[static::FORM_FIELD_CHECK_LIST_ITEM_REFERENCE]);
                $checkListItem          = (new \DoEveryApp\Entity\Execution\CheckListItem())
                    ->setExecution($execution)
                    ->setChecked('1' === $item[static::FORM_FIELD_CHECK_LIST_ITEM_CHECKED])
                    ->setNote($item[static::FORM_FIELD_CHECK_LIST_ITEM_NOTE])
                    ->setCheckListItem($checkListItemReference)
                    ->setName($checkListItemReference->getName())
                    ->setPosition($checkListItemReference->getPosition())
                ;
                $checkListItem::getRepository()->create($checkListItem);
            }

            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess('Ausführung registriert.');

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


    protected function filterAndValidate(array &$data): array
    {
        $constraints = [
            static::FORM_FIELD_DURATION => [
            ],
            static::FORM_FIELD_NOTE     => [
            ],
            static::FORM_FIELD_DATE     => [
                new \Symfony\Component\Validator\Constraints\NotBlank(),
            ],
            static::FORM_FIELD_WORKER   => [
                new \Symfony\Component\Validator\Constraints\Callback(function ($value) {
                    if (null === $value) {
                        return;
                    }
                    $assignee = \DoEveryApp\Entity\Worker::getRepository()->find($value);
                    if (false === $assignee instanceof \DoEveryApp\Entity\Worker) {
                        throw new \InvalidArgumentException('worker not found');
                    }
                }),
            ],

        ];


        $data[static::FORM_FIELD_DURATION] = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_DURATION))
        ;
        $data[static::FORM_FIELD_NOTE]     = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_NOTE))
        ;
        $data[static::FORM_FIELD_DATE]     = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_DATE))
        ;
        $data[static::FORM_FIELD_WORKER]   = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_WORKER))
        ;

        foreach ($data[static::FORM_FIELD_CHECK_LIST_ITEMS] ?? [] as $index => $item) {
            $data[static::FORM_FIELD_CHECK_LIST_ITEMS][$index][static::FORM_FIELD_CHECK_LIST_ITEM_ID] = (new \Laminas\Filter\FilterChain())
                ->attach(new \Laminas\Filter\StringTrim())
                ->attach(new \Laminas\Filter\ToNull())
                ->filter($item[static::FORM_FIELD_CHECK_LIST_ITEM_ID])
            ;
            $data['checkListItems_' . $index . '_' . static::FORM_FIELD_CHECK_LIST_ITEM_ID]           = $data[static::FORM_FIELD_CHECK_LIST_ITEMS][$index][static::FORM_FIELD_CHECK_LIST_ITEM_ID];
            $constraints[static::FORM_FIELD_CHECK_LIST_ITEMS]                                         = [];
            $constraints['checkListItems_' . $index . '_id']                                          = [

            ];
            $data[static::FORM_FIELD_CHECK_LIST_ITEMS][$index]['checked']                             = (new \Laminas\Filter\FilterChain())
                ->attach(new \Laminas\Filter\StringTrim())
                ->attach(new \Laminas\Filter\ToNull())
                ->filter($item['checked'])
            ;
            $data['checkListItems_' . $index . '_checked']                                            = $data[static::FORM_FIELD_CHECK_LIST_ITEMS][$index]['checked'];
            $constraints['checkListItems_' . $index . '_checked']                                     = [

            ];
            $data[static::FORM_FIELD_CHECK_LIST_ITEMS][$index]['note']                                = (new \Laminas\Filter\FilterChain())
                ->attach(new \Laminas\Filter\StringTrim())
                ->attach(new \Laminas\Filter\ToNull())
                ->filter($item['note'])
            ;
            $data['checkListItems_' . $index . '_note']                                               = $data[static::FORM_FIELD_CHECK_LIST_ITEMS][$index]['note'];
            $constraints['checkListItems_' . $index . '_note']                                        = [

            ];
            $data[static::FORM_FIELD_CHECK_LIST_ITEMS][$index]['reference']                           = (new \Laminas\Filter\FilterChain())
                ->attach(new \Laminas\Filter\StringTrim())
                ->attach(new \Laminas\Filter\ToNull())
                ->filter($item['reference'])
            ;
            $data['checkListItems_' . $index . '_reference']                                          = $data[static::FORM_FIELD_CHECK_LIST_ITEMS][$index]['reference'];
            $constraints['checkListItems_' . $index . '_reference']                                   = [
                new \Symfony\Component\Validator\Constraints\NotBlank(),
            ];
        }

        $this->validate($data, new \Symfony\Component\Validator\Constraints\Collection($constraints));

        return $data;
    }
}