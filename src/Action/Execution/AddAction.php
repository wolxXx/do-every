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

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $task = \DoEveryApp\Entity\Task::getRepository()->find($this->getArgumentSafe());
        if (false === $task instanceof \DoEveryApp\Entity\Task) {
            \DoEveryApp\Util\FlashMessenger::addDanger('Aufgabe nicht gefunden');

            return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
        }

        if (true === $this->isGetRequest()) {
            return $this->render(
                'action/execution/add',
                [
                    'data' => [
                        'date'   => (new \DateTime())->format('Y-m-d H:i:s'),
                        'worker' => \DoEveryApp\Util\User\Current::get()->getId(),
                    ],
                    'task' => $task,
                ]
            );
        }

        $data = [];
        try {
            $data = $this->getRequest()->getParsedBody();
            $data = $this->filterAndValidate($data);

            \DoEveryApp\Service\Task\Execution\Creator::execute(
                (new \DoEveryApp\Service\Task\Execution\Creator\Bag())
                    ->setTask($task)
                    ->setDuration($data['duration'])
                    ->setDate(new \DateTime($data['date']))
                    ->setNote($data['note'])
                    ->setWorker($data['worker'] ? \DoEveryApp\Entity\Worker::getRepository()->find($data['worker']) : null)
            );

            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess('Ausführung registriert.');

            return $this->redirect(\DoEveryApp\Action\Task\ShowAction::getRoute($task->getId()));
        } catch (\Throwable $exception) {
            \var_dump($data);
            #die('');
            throw $exception;
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
        $data['duration'] = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('duration'))
        ;
        $data['note']     = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('note'))
        ;
        $data['date']     = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('date'))
        ;
        $data['worker']   = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('worker'))
        ;

        $validators = new \Symfony\Component\Validator\Constraints\Collection([
                                                                                  'duration' => [
                                                                                  ],
                                                                                  'note'     => [
                                                                                  ],
                                                                                  'date'     => [
                                                                                      new \Symfony\Component\Validator\Constraints\NotBlank(),
                                                                                  ],
                                                                                  'worker'   => [
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

                                                                              ]);


        $this->validate($data, $validators);

        return $data;
    }
}