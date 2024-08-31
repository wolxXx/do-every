<?php

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

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $execution = \DoEveryApp\Entity\Execution::getRepository()->find($this->getArgumentSafe());
        if (false === $execution instanceof \DoEveryApp\Entity\Execution) {
            \DoEveryApp\Util\FlashMessenger::addDanger('Ausführung nicht gefunden');

            return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
        }

        if (true === $this->isGetRequest()) {
            return $this->render(
                'action/execution/edit',
                [
                    'data' => [
                        'date'   => $execution->getDate()->format('Y-m-d H:i:s'),
                        'worker' => $execution->getWorker()?->getId(),
                        'note' => $execution->getNote(),
                        'duration' => $execution->getDuration(),
                    ],
                ]
            );
        }

        $data = [];
        try {
            $data = $this->getRequest()->getParsedBody();
            $data = $this->filterAndValidate($data);
            $execution
                ->setDuration($data['duration'])
                ->setDate(new \DateTime($data['date']))
                ->setNote($data['note'])
                ->setWorker($data['worker'] ? \DoEveryApp\Entity\Worker::getRepository()->find($data['worker']) : null)
                ;
            $execution::getRepository()->update($execution);

            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess('Ausführung bearbeitet  .');

            return $this->redirect(\DoEveryApp\Action\Task\ShowAction::getRoute($execution->getTask()->getId()));
        } catch (\Throwable $exception) {
            \var_dump($data);
            #die('');
            throw $exception;
        }

        return $this->render(
            'action/execution/edit',
            [
                'data' => $data,
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