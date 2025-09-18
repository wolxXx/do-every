<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Execution\Share;

trait AddEdit
{
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

    protected function handleCheckListItems(\DoEveryApp\Entity\Execution $execution, array $data): static
    {
        foreach ($data[static::FORM_FIELD_CHECK_LIST_ITEMS] ?? [] as $item) {
            $checkListItemReference = \DoEveryApp\Entity\Task\CheckListItem::getRepository()->find(id: $item[static::FORM_FIELD_CHECK_LIST_ITEM_REFERENCE]);
            $checkListItem          = (new \DoEveryApp\Entity\Execution\CheckListItem())
                ->setExecution(execution: $execution)
                ->setChecked(checked: '1' === $item[static::FORM_FIELD_CHECK_LIST_ITEM_CHECKED])
                ->setNote(note: $item[static::FORM_FIELD_CHECK_LIST_ITEM_NOTE])
                ->setCheckListItem(checkListItem: $checkListItemReference)
                ->setName(name: $checkListItemReference->getName())
                ->setPosition(position: $checkListItemReference->getPosition())
            ;
            $checkListItem::getRepository()->create(entity: $checkListItem);
        }

        return $this;
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
                new \Symfony\Component\Validator\Constraints\Callback(callback: function ($value): void {
                    if (null === $value) {
                        return;
                    }
                    $assignee = \DoEveryApp\Entity\Worker::getRepository()->find(id: $value);
                    if (false === $assignee instanceof \DoEveryApp\Entity\Worker) {
                        throw new \InvalidArgumentException(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->workerNotFound());
                    }
                }),
            ],

        ];

        $data[static::FORM_FIELD_DURATION] = (new \Laminas\Filter\FilterChain())
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->attach(callback: new \Laminas\Filter\ToInt())
            ->filter(value: $this->getFromBody(static::FORM_FIELD_DURATION))
        ;
        $data[static::FORM_FIELD_NOTE]     = (new \Laminas\Filter\FilterChain())
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(static::FORM_FIELD_NOTE))
        ;
        $data[static::FORM_FIELD_DATE]     = (new \Laminas\Filter\FilterChain())
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(static::FORM_FIELD_DATE))
        ;
        $data[static::FORM_FIELD_WORKER]   = (new \Laminas\Filter\FilterChain())
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(static::FORM_FIELD_WORKER))
        ;

        foreach ($data[static::FORM_FIELD_CHECK_LIST_ITEMS] ?? [] as $index => $item) {
            $data[static::FORM_FIELD_CHECK_LIST_ITEMS][$index][static::FORM_FIELD_CHECK_LIST_ITEM_ID]                             = (new \Laminas\Filter\FilterChain())
                ->attach(callback: new \Laminas\Filter\StringTrim())
                ->attach(callback: new \Laminas\Filter\ToNull())
                ->filter(value: $item[static::FORM_FIELD_CHECK_LIST_ITEM_ID])
            ;
            $data[static::FORM_FIELD_CHECK_LIST_ITEMS . '_' . $index . '_' . static::FORM_FIELD_CHECK_LIST_ITEM_ID]               = $data[static::FORM_FIELD_CHECK_LIST_ITEMS][$index][static::FORM_FIELD_CHECK_LIST_ITEM_ID];
            $constraints[static::FORM_FIELD_CHECK_LIST_ITEMS]                                                                     = [];
            $constraints[static::FORM_FIELD_CHECK_LIST_ITEMS . '_' . $index . '_' . static::FORM_FIELD_CHECK_LIST_ITEM_ID]        = [

            ];
            $data[static::FORM_FIELD_CHECK_LIST_ITEMS][$index][static::FORM_FIELD_CHECK_LIST_ITEM_CHECKED]                        = (new \Laminas\Filter\FilterChain())
                ->attach(callback: new \Laminas\Filter\StringTrim())
                ->attach(callback: new \Laminas\Filter\ToNull())
                ->filter(value: $item[static::FORM_FIELD_CHECK_LIST_ITEM_CHECKED])
            ;
            $data[static::FORM_FIELD_CHECK_LIST_ITEMS . '_' . $index . '_' . static::FORM_FIELD_CHECK_LIST_ITEM_CHECKED]          = $data[static::FORM_FIELD_CHECK_LIST_ITEMS][$index][static::FORM_FIELD_CHECK_LIST_ITEM_CHECKED];
            $constraints[static::FORM_FIELD_CHECK_LIST_ITEMS . '_' . $index . '_' . static::FORM_FIELD_CHECK_LIST_ITEM_CHECKED]   = [

            ];
            $data[static::FORM_FIELD_CHECK_LIST_ITEMS][$index][static::FORM_FIELD_CHECK_LIST_ITEM_NOTE]                           = (new \Laminas\Filter\FilterChain())
                ->attach(callback: new \Laminas\Filter\StringTrim())
                ->attach(callback: new \Laminas\Filter\ToNull())
                ->filter(value: $item[static::FORM_FIELD_CHECK_LIST_ITEM_NOTE])
            ;
            $data[static::FORM_FIELD_CHECK_LIST_ITEMS . '_' . $index . '_' . static::FORM_FIELD_CHECK_LIST_ITEM_NOTE]             = $data[static::FORM_FIELD_CHECK_LIST_ITEMS][$index][static::FORM_FIELD_CHECK_LIST_ITEM_NOTE];
            $constraints[static::FORM_FIELD_CHECK_LIST_ITEMS . '_' . $index . '_' . static::FORM_FIELD_CHECK_LIST_ITEM_NOTE]      = [

            ];
            $data[static::FORM_FIELD_CHECK_LIST_ITEMS][$index][static::FORM_FIELD_CHECK_LIST_ITEM_REFERENCE]                      = (new \Laminas\Filter\FilterChain())
                ->attach(callback: new \Laminas\Filter\StringTrim())
                ->attach(callback: new \Laminas\Filter\ToNull())
                ->filter(value: $item[static::FORM_FIELD_CHECK_LIST_ITEM_REFERENCE])
            ;
            $data[static::FORM_FIELD_CHECK_LIST_ITEMS . '_' . $index . '_' . static::FORM_FIELD_CHECK_LIST_ITEM_REFERENCE]        = $data[static::FORM_FIELD_CHECK_LIST_ITEMS][$index][static::FORM_FIELD_CHECK_LIST_ITEM_REFERENCE];
            $constraints[static::FORM_FIELD_CHECK_LIST_ITEMS . '_' . $index . '_' . static::FORM_FIELD_CHECK_LIST_ITEM_REFERENCE] = [
                new \Symfony\Component\Validator\Constraints\NotBlank(),
            ];
        }

        $this->validate($data, new \Symfony\Component\Validator\Constraints\Collection(fields: $constraints));

        return $data;
    }
}
