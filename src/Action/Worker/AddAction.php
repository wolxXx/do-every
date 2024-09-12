<?php

namespace DoEveryApp\Action\Worker;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/worker/add',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class AddAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (true === $this->isGetRequest()) {
            return $this->render('action/worker/add', [
                'data' => [],
            ]);
        }
        $data = [];
        try {
            $data    = $this->getRequest()->getParsedBody();
            $data    = $this->filterAndValidate($data);
            $newTask = \DoEveryApp\Service\Worker\Creator::execute(
                (new \DoEveryApp\Service\Worker\Creator\Bag())
                    ->setName($data['name'])
                    ->setIsAdmin('1' === $data['is_admin'])
                    ->enableNotifications('1' === $data['do_notify'])
                    ->enableLoginNotifications('1' === $data['do_notify_logins'])
                    ->setEmail($data['email'])
                    ->setPassword(null === $data['password'] ? null : $data['password'])
            );

            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess('Worker erstellt.');

            return $this->redirect(\DoEveryApp\Action\Worker\IndexAction::getRoute());
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }


        return $this->render('action/worker/add', ['data' => $data]);
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