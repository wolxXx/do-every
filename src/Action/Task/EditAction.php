<?php

namespace DoEveryApp\Action\Task;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/task/edit/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class EditAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SingleIdRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $task = \DoEveryApp\Entity\Task::getRepository()->find($this->getArgumentSafe());
        if (false === $task instanceof \DoEveryApp\Entity\Task) {
            \DoEveryApp\Util\FlashMessenger::addDanger('Aufgabe nicht gefunden');

            return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
        }
        if (true === $this->isGetRequest()) {
            $checkListItems = [];
            foreach ($task->getCheckListItems() as $checkListItem) {
                $checkListItems[] = [
                    'id'       => $checkListItem->getId(),
                    'name'     => $checkListItem->getName(),
                    'note'     => $checkListItem->getNote(),
                    'position' => $checkListItem->getPosition(),
                ];
            }

            return $this->render('action/task/edit', [
                'task' => $task,
                'data' => [
                    'checkListItem'       => $checkListItems,
                    'name'                => $task->getName(),
                    'assignee'            => $task->getAssignee()?->getId(),
                    'group'               => $task->getGroup()?->getId(),
                    'intervalType'        => $task->getIntervalType(),
                    'intervalValue'       => $task->getIntervalValue(),
                    'priority'            => $task->getPriority(),
                    'enableNotifications' => $task->isNotify() ? '1' : '0',
                    'elapsingCronType'    => $task->isElapsingCronType() ? '1' : '0',
                    'note'                => $task->getNote(),
                ],
            ]);
        }
        $data = [];
        try {
            $data = $this->getRequest()->getParsedBody();
            $data = $this->filterAndValidate($data);

            $task
                ->setAssignee($data['assignee'] ? \DoEveryApp\Entity\Worker::getRepository()->find($data['assignee']) : null)
                ->setGroup($data['group'] ? \DoEveryApp\Entity\Group::getRepository()->find($data['group']) : null)
                ->setName($data['name'])
                ->setIntervalType($data['intervalType'] ? \DoEveryApp\Definition\IntervalType::from($data['intervalType'])->value : null)
                ->setIntervalValue($data['intervalValue'])
                ->setPriority(\DoEveryApp\Definition\Priority::from($data['priority'])->value)
                ->setNotify('1' === $data['enableNotifications'])
                ->setElapsingCronType('1' === $data['elapsingCronType'])
                ->setNote($data['note'])
            ;
            $task::getRepository()->update($task);

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

            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess('Aufgabe bearbeitet.');

            return $this->redirect(\DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()));
        } catch (\Throwable $exception) {
            \var_dump($data);
            #die('');
            throw $exception;
        }


        return $this->render(
            'action/task/edit',
            [
                'task' => $task,
                'data' => $data,
            ]
        );
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
            'group'               => [
                new \Symfony\Component\Validator\Constraints\Callback(function ($value) {
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
                new \Symfony\Component\Validator\Constraints\Callback(function ($value) {
                    if (null === $value) {
                        return;
                    }
                    \DoEveryApp\Definition\IntervalType::from($value);
                }),
            ],
            'intervalValue'       => [
                new \Symfony\Component\Validator\Constraints\GreaterThan(0),
                new \Symfony\Component\Validator\Constraints\Callback(function ($value) {
                    if (null === $value) {
                        return;
                    }
                }),
            ],
            'priority'            => [
                new \Symfony\Component\Validator\Constraints\NotBlank(),
                new \Symfony\Component\Validator\Constraints\Callback(function ($value) {
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