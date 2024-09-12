<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Worker;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/worker/edit/{id:[0-9]+}',
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
        $worker = \DoEveryApp\Entity\Worker::getRepository()->find($this->getArgumentSafe());
        if (false === $worker instanceof \DoEveryApp\Entity\Worker) {
            \DoEveryApp\Util\FlashMessenger::addDanger('Worker nicht gefunden');

            return $this->redirect(\DoEveryApp\Action\Worker\IndexAction::getRoute());
        }
        if (true === $this->isGetRequest()) {
            return $this->render('action/worker/edit', [
                'worker' => $worker,
                'data' => [
                    'name' => $worker->getName(),
                    'email' => $worker->getEmail(),
                    'is_admin' => $worker->isAdmin()? '1' : '0',
                    'do_notify' => $worker->doNotify()? '1' : '0',
                    'do_notify_logins' => $worker->doNotifyLogin()? '1' : '0',
                    'password' => ''
                ],
            ]);
        }
        $data = [];
        try {
            $data    = $this->getRequest()->getParsedBody();
            $data    = $this->filterAndValidate($data);
            $worker
                    ->setName($data['name'])
                    ->setIsAdmin('1' === $data['is_admin'])
                    ->enableNotifications('1' === $data['do_notify'])
                    ->setNotifyLogin('1' === $data['do_notify_logins'])
                    ->setEmail($data['email'])

            ;
            if(null !== $data['password']) {
                $worker
                    ->setPassword($data['password'])
                    ->setLastPasswordChange(\Carbon\Carbon::now())
                ;
            }

            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess('Worker bearbeitet.');

            return $this->redirect(\DoEveryApp\Action\Worker\IndexAction::getRoute());
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }


        return $this->render(
            'action/worker/edit',
            [
                'worker' => $worker,
                'data' => $data
            ]);
    }


    protected function filterAndValidate(array &$data): array
    {
        $data['name']     = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('name'))
        ;
        $data['email']    = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('email'))
        ;
        $data['password'] = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('password'))
        ;
        $data['is_admin'] = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('is_admin'))
        ;
        $data['do_notify'] = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('do_notify'))
        ;
        $data['do_notify_logins'] = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('do_notify_logins'))
        ;

        $validators = new \Symfony\Component\Validator\Constraints\Collection([
                                                                                  'email'    => [
                                                                                  ],
                                                                                  'is_admin' => [
                                                                                  ],
                                                                                  'do_notify' => [
                                                                                  ],
                                                                                  'do_notify_logins' => [
                                                                                  ],
                                                                                  'password' => [
                                                                                  ],
                                                                                  'name'     => [
                                                                                      new \Symfony\Component\Validator\Constraints\NotBlank(),
                                                                                  ],
                                                                               
                                                                              ]);


        $this->validate($data, $validators);

        return $data;
    }
}