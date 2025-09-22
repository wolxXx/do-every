<?php

declare(strict_types = 1);

namespace DoEveryApp\Action\Task\Share;

trait AddEdit
{
    public const string FORM_FIELD_CHECK_LIST_ITEM          = 'checkListItem';

    public const string FORM_FIELD_CHECK_LIST_ITEM_ID       = 'id';

    public const string FORM_FIELD_CHECK_LIST_ITEM_NAME     = 'name';

    public const string FORM_FIELD_CHECK_LIST_ITEM_NOTE     = 'note';

    public const string FORM_FIELD_CHECK_LIST_ITEM_POSITION = 'position';

    public const string FORM_FIELD_ELAPSING_CRON_TYPE       = 'elapsingCronType';

    public const string FORM_FIELD_NOTE                     = 'note';

    public const string FORM_FIELD_NAME                     = 'name';

    public const string FORM_FIELD_ASSIGNEE                 = 'assignee';

    public const string FORM_FIELD_GROUP                    = 'group';

    public const string FORM_FIELD_INTERVAL_TYPE            = 'intervalType';

    public const string FORM_FIELD_INTERVAL_VALUE           = 'intervalValue';

    public const string FORM_FIELD_PRIORITY                 = 'priority';

    public const string FORM_FIELD_ENABLE_NOTIFICATIONS     = 'enableNotifications';

    protected function handleCheckListItems(\DoEveryApp\Entity\Task $task, array $data): static
    {
        foreach ($data[static::FORM_FIELD_CHECK_LIST_ITEM] ?? [] as $position => $item) {
            if (null === $item[static::FORM_FIELD_CHECK_LIST_ITEM_ID]) {
                $checkListItem = new \DoEveryApp\Entity\Task\CheckListItem()
                    ->setTask(task: $task)
                    ->setName(name: $item[static::FORM_FIELD_CHECK_LIST_ITEM_NAME])
                    ->setNote(note: $item[static::FORM_FIELD_CHECK_LIST_ITEM_NOTE])
                    ->setPosition(position: $position)
                ;
                $checkListItem::getRepository()
                              ->create(entity: $checkListItem)
                ;

                continue;
            }
            $checkListItem = \DoEveryApp\Entity\Task\CheckListItem::getRepository()
                                                                  ->find(id: $item[static::FORM_FIELD_CHECK_LIST_ITEM_ID])
                                                                  ->setTask(task: $task)
                                                                  ->setName(name: $item[static::FORM_FIELD_CHECK_LIST_ITEM_NAME])
                                                                  ->setNote(note: $item[static::FORM_FIELD_CHECK_LIST_ITEM_NOTE])
                                                                  ->setPosition(position: $position)
            ;
            $checkListItem::getRepository()
                          ->update(entity: $checkListItem)
            ;
        }

        return $this;
    }

    protected function filterAndValidate(array &$data): array
    {
        $validatorCollection = [
            static::FORM_FIELD_ELAPSING_CRON_TYPE   => [],
            static::FORM_FIELD_NOTE                 => [],
            static::FORM_FIELD_NAME                 => [
                new \Symfony\Component\Validator\Constraints\NotBlank(),
            ],
            static::FORM_FIELD_ASSIGNEE             => [
                new \Symfony\Component\Validator\Constraints\Callback(callback: function($value): void {
                    if (null === $value) {
                        return;
                    }
                    $assignee = \DoEveryApp\Entity\Worker::getRepository()
                                                         ->find(id: $value)
                    ;
                    if (false === $assignee instanceof \DoEveryApp\Entity\Worker) {
                        throw new \InvalidArgumentException(message: 'worker not found');
                    }
                }),
            ],
            static::FORM_FIELD_GROUP                => [
                new \Symfony\Component\Validator\Constraints\Callback(callback: function($value): void {
                    if (null === $value) {
                        return;
                    }
                    $group = \DoEveryApp\Entity\Group::getRepository()
                                                     ->find(id: $value)
                    ;
                    if (false === $group instanceof \DoEveryApp\Entity\Group) {
                        throw new \InvalidArgumentException(message: 'group not found');
                    }
                }),
            ],
            static::FORM_FIELD_INTERVAL_TYPE        => [
                new \Symfony\Component\Validator\Constraints\Callback(callback: function($value): void {
                    if (null === $value) {
                        return;
                    }
                    if (null === \DoEveryApp\Definition\IntervalType::tryFrom(value: $value)) {
                        throw new \InvalidArgumentException(message: 'invalid interval type');
                    }
                }),
            ],
            static::FORM_FIELD_INTERVAL_VALUE       => [
                new \Symfony\Component\Validator\Constraints\GreaterThan(value: 0),
            ],
            static::FORM_FIELD_PRIORITY             => [
                new \Symfony\Component\Validator\Constraints\NotBlank(),
                new \Symfony\Component\Validator\Constraints\Callback(callback: function($value): void {
                    if (null === $value) {
                        return;
                    }
                    if (null === \DoEveryApp\Definition\Priority::tryFrom(value: $value)) {
                        throw new \InvalidArgumentException(message: 'invalid priority');
                    }
                }),
            ],
            static::FORM_FIELD_ENABLE_NOTIFICATIONS => [
                new \Symfony\Component\Validator\Constraints\NotBlank(),
                new \Symfony\Component\Validator\Constraints\Callback(callback: function($value) {
                    if (null === $value) {
                        return null;
                    }

                    return $value === '1' || $value === '0';
                }),
            ],
        ];
        $data[static::FORM_FIELD_NAME] = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_NAME))
        ;
        $data[static::FORM_FIELD_NOTE] = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_NOTE))
        ;
        $data[static::FORM_FIELD_ASSIGNEE] = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_ASSIGNEE))
        ;
        $data[static::FORM_FIELD_GROUP] = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_GROUP))
        ;
        $data[static::FORM_FIELD_INTERVAL_TYPE] = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_INTERVAL_TYPE))
        ;
        $data[static::FORM_FIELD_INTERVAL_VALUE] = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->attach(callback: new \Laminas\Filter\ToInt())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_INTERVAL_VALUE))
        ;
        $data[static::FORM_FIELD_PRIORITY] = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->attach(callback: new \Laminas\Filter\ToInt())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_PRIORITY))
        ;
        $data[static::FORM_FIELD_ENABLE_NOTIFICATIONS] = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_ENABLE_NOTIFICATIONS))
        ;
        $data[static::FORM_FIELD_ELAPSING_CRON_TYPE] = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_ELAPSING_CRON_TYPE))
        ;

        foreach ($data[static::FORM_FIELD_CHECK_LIST_ITEM] ?? [] as $index => $item) {
            $data[static::FORM_FIELD_CHECK_LIST_ITEM][$index][static::FORM_FIELD_CHECK_LIST_ITEM_ID] = new \Laminas\Filter\FilterChain()
                ->attach(callback: new \Laminas\Filter\StringTrim())
                ->attach(callback: new \Laminas\Filter\ToNull())
                ->filter(value: $item[static::FORM_FIELD_CHECK_LIST_ITEM_ID] ?? '')
            ;
            $data[static::FORM_FIELD_CHECK_LIST_ITEM][$index][static::FORM_FIELD_CHECK_LIST_ITEM_POSITION] = new \Laminas\Filter\FilterChain()
                ->attach(callback: new \Laminas\Filter\StringTrim())
                ->attach(callback: new \Laminas\Filter\ToNull())
                ->filter(value: $item[static::FORM_FIELD_CHECK_LIST_ITEM_POSITION] ?? '')
            ;
            $data[static::FORM_FIELD_CHECK_LIST_ITEM][$index][static::FORM_FIELD_CHECK_LIST_ITEM_NAME] = new \Laminas\Filter\FilterChain()
                ->attach(callback: new \Laminas\Filter\StringTrim())
                ->attach(callback: new \Laminas\Filter\ToNull())
                ->filter(value: $item[static::FORM_FIELD_CHECK_LIST_ITEM_NAME] ?? '')
            ;
            $data[static::FORM_FIELD_CHECK_LIST_ITEM][$index][static::FORM_FIELD_CHECK_LIST_ITEM_NOTE] = new \Laminas\Filter\FilterChain()
                ->attach(callback: new \Laminas\Filter\StringTrim())
                ->attach(callback: new \Laminas\Filter\ToNull())
                ->filter(value: $item[static::FORM_FIELD_CHECK_LIST_ITEM_NOTE] ?? '')
            ;

            $validatorCollection[static::FORM_FIELD_CHECK_LIST_ITEM] = [];

            $data[static::FORM_FIELD_CHECK_LIST_ITEM . '_' . $index . '_' . static::FORM_FIELD_CHECK_LIST_ITEM_NAME] = $data[static::FORM_FIELD_CHECK_LIST_ITEM][$index][static::FORM_FIELD_CHECK_LIST_ITEM_NAME];
            $validatorCollection[static::FORM_FIELD_CHECK_LIST_ITEM . '_' . $index . '_' . static::FORM_FIELD_CHECK_LIST_ITEM_NAME] = [
                new \Symfony\Component\Validator\Constraints\NotBlank(),
                new \Symfony\Component\Validator\Constraints\Length(max: 30),
            ];

            $data[static::FORM_FIELD_CHECK_LIST_ITEM . '_' . $index . '_' . static::FORM_FIELD_CHECK_LIST_ITEM_NOTE] = $data[static::FORM_FIELD_CHECK_LIST_ITEM][$index][static::FORM_FIELD_CHECK_LIST_ITEM_NOTE];
            $validatorCollection[static::FORM_FIELD_CHECK_LIST_ITEM . '_' . $index . '_' . static::FORM_FIELD_CHECK_LIST_ITEM_NOTE] = [
                new \Symfony\Component\Validator\Constraints\Length(max: 200),
            ];
        }

        $validators = new \Symfony\Component\Validator\Constraints\Collection(fields: $validatorCollection);
        $this->validate(data: $data, validators: $validators);

        return $data;
    }
}
