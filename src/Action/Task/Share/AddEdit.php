<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Task\Share;

trait AddEdit
{
    protected function handleCheckListItems(\DoEveryApp\Entity\Task $task, array $data): static
    {
        foreach ($data['checkListItem'] ?? [] as $position => $item) {
            if (null === $item['id']) {
                $checkListItem = (new \DoEveryApp\Entity\Task\CheckListItem())
                    ->setTask($task)
                    ->setName($item['name'])
                    ->setNote($item['note'])
                    ->setPosition($position)
                ;
                $checkListItem::getRepository()->create($checkListItem);
                continue;
            }
            $checkListItem = \DoEveryApp\Entity\Task\CheckListItem::getRepository()->find($item['id'])
                                                                  ->setTask($task)
                                                                  ->setName($item['name'])
                                                                  ->setNote($item['note'])
                                                                  ->setPosition($position)
            ;
            $checkListItem::getRepository()->update($checkListItem);
        }

        return $this;
    }

    protected function filterAndValidate(array &$data): array
    {
        $validatorCollection         = [
            'elapsingCronType'    => [
            ],
            'note'                => [
            ],
            'name'                => [
                new \Symfony\Component\Validator\Constraints\NotBlank(),
            ],
            'assignee'            => [
                new \Symfony\Component\Validator\Constraints\Callback(function ($value): void {
                    if (null === $value) {
                        return;
                    }
                    $assignee = \DoEveryApp\Entity\Worker::getRepository()->find($value);
                    if (false === $assignee instanceof \DoEveryApp\Entity\Worker) {
                        throw new \InvalidArgumentException('worker not found');
                    }
                }),
            ],
            'group'               => [
                new \Symfony\Component\Validator\Constraints\Callback(function ($value): void {
                    if (null === $value) {
                        return;
                    }
                    $group = \DoEveryApp\Entity\Group::getRepository()->find($value);
                    if (false === $group instanceof \DoEveryApp\Entity\Group) {
                        throw new \InvalidArgumentException('group not found');
                    }
                }),
            ],
            'intervalType'        => [
                new \Symfony\Component\Validator\Constraints\Callback(function ($value): void {
                    if (null === $value) {
                        return;
                    }
                    \DoEveryApp\Definition\IntervalType::from($value);
                }),
            ],
            'intervalValue'       => [
                new \Symfony\Component\Validator\Constraints\GreaterThan(0),
                new \Symfony\Component\Validator\Constraints\Callback(function ($value): void {
                    if (null === $value) {
                        return;
                    }
                }),
            ],
            'priority'            => [
                new \Symfony\Component\Validator\Constraints\NotBlank(),
                new \Symfony\Component\Validator\Constraints\Callback(function ($value): void {
                    if (null === $value) {
                        return;
                    }
                    \DoEveryApp\Definition\Priority::from($value);
                }),
            ],
            'enableNotifications' => [
                new \Symfony\Component\Validator\Constraints\NotBlank(),
                new \Symfony\Component\Validator\Constraints\Callback(function ($value) {
                    if (null === $value) {
                        return $value;
                    }

                    return $value === '1' || $value === '0';
                }),
            ],
        ];
        $data['name']                = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('name'))
        ;
        $data['note']                = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('note'))
        ;
        $data['assignee']            = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('assignee'))
        ;
        $data['group']               = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('group'))
        ;
        $data['intervalType']        = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('intervalType'))
        ;
        $data['intervalValue']       = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('intervalValue'))
        ;
        $data['priority']            = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->attach(new \Laminas\Filter\ToInt())
            ->filter($this->getFromBody('priority'))
        ;
        $data['enableNotifications'] = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->filter($this->getFromBody('enableNotifications'))
        ;
        $data['elapsingCronType']    = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->filter($this->getFromBody('elapsingCronType'))
        ;

        foreach ($data['checkListItem'] ?? [] as $index => $item) {
            $data['checkListItem'][$index]['id']                      = (new \Laminas\Filter\FilterChain())
                ->attach(new \Laminas\Filter\StringTrim())
                ->attach(new \Laminas\Filter\ToNull())
                ->filter($item['id'] ?? '')
            ;
            $data['checkListItem'][$index]['position']                = (new \Laminas\Filter\FilterChain())
                ->attach(new \Laminas\Filter\StringTrim())
                ->attach(new \Laminas\Filter\ToNull())
                ->filter($item['position'] ?? '')
            ;
            $data['checkListItem'][$index]['name']                    = (new \Laminas\Filter\FilterChain())
                ->attach(new \Laminas\Filter\StringTrim())
                ->attach(new \Laminas\Filter\ToNull())
                ->filter($item['name'] ?? '')
            ;
            $data['checkListItem'][$index]['note']                    = (new \Laminas\Filter\FilterChain())
                ->attach(new \Laminas\Filter\StringTrim())
                ->attach(new \Laminas\Filter\ToNull())
                ->filter($item['note'] ?? '')
            ;
            $validatorCollection['checkListItem']                     = [];
            $data['checkListItem_' . $index . '_name']                = $data['checkListItem'][$index]['name'];
            $validatorCollection['checkListItem_' . $index . '_name'] = [
                new \Symfony\Component\Validator\Constraints\NotBlank(),
            ];
        }

        $validators = new \Symfony\Component\Validator\Constraints\Collection($validatorCollection);
        $this->validate($data, $validators);

        return $data;
    }
}
