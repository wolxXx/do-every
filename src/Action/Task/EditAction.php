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
            return $this->render('action/task/edit', [
                'task' => $task,
                'data' => [
                    'name' => $task->getName(),
                    'assignee' => $task->getAssignee()?->getId(),
                    'group' => $task->getGroup()?->getId(),
                    'intervalType' => $task->getIntervalType(),
                    'intervalValue' => $task->getIntervalValue(),
                    'priority' => $task->getPriority(),
                    'enableNotifications' => $task->isNotify()? '1' : '0',
                ],
            ]);
        }
        $data = [];
        try {
            $data    = $this->getRequest()->getParsedBody();
            $data    = $this->filterAndValidate($data);
            $task
                    ->setAssignee($data['assignee'] ? \DoEveryApp\Entity\Worker::getRepository()->find($data['assignee']) : null)
                    ->setGroup($data['group'] ? \DoEveryApp\Entity\Group::getRepository()->find($data['group']) : null)
                    ->setName($data['name'])
                    ->setIntervalType($data['intervalType'] ? \DoEveryApp\Definition\IntervalType::from($data['intervalType'])->value : null)
                    ->setIntervalValue($data['intervalValue'])
                    ->setPriority(\DoEveryApp\Definition\Priority::from($data['priority'])->value)
                    ->setNotify('1' === $data['enableNotifications'])
            ;
            $task::getRepository()->update($task);

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
        $data['name']                = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('name'))
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

        $validators = new \Symfony\Component\Validator\Constraints\Collection([
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
                                                                              ]);


        $this->validate($data, $validators);

        return $data;
    }
}