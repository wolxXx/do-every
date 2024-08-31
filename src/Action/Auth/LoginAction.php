<?php

namespace DoEveryApp\Action\Auth;

#[\DoEveryApp\Attribute\Action\Route(
    path        : '/auth/login',
    methods     : [
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
    authRequired: false
)]
class LoginAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $currentUser = \DoEveryApp\Util\User\Current::get();
        if (true === \DoEveryApp\Util\User\Current::isAuthenticated()) {
            return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
        }

        if (true === $this->isGetRequest()) {
            return $this->render('action/auth/login', ['data' => []]);
        }
        $data = [];
        try {
            $data     = $this->getRequest()->getParsedBody();
            $data     = $this->filterAndValidate($data);
            $existing = \DoEveryApp\Entity\Worker::getRepository()->findOneByEmail($data['email']);
            if (false === $existing instanceof \DoEveryApp\Entity\Worker) {
                $this->getErrorStore()->addError('email', 'user not found');
                throw new \InvalidArgumentException('User not found');
            }
            if (false === \DoEveryApp\Util\Password::verify($data['password'], $existing->getPassword())) {
                $this->getErrorStore()->addError('email', 'user not found');
                throw new \InvalidArgumentException('User not found');
            }
            \DoEveryApp\Util\User\Current::login($existing);
            $existing->setLastLogin(\Carbon\Carbon::now());
            $existing::getRepository()->update($existing);
            \DoEveryApp\Util\DependencyContainer::getInstance()
                ->getEntityManager()
                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess('welcome, ' . $existing->getName());
            return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
        } catch (\Throwable $exception) {
            #\var_dump($data);
            #die('');
            #throw $exception;
        }


        return $this->render('action/auth/login', ['data' => $data]);
    }


    protected function filterAndValidate(array &$data): array
    {
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

        $validators = new \Symfony\Component\Validator\Constraints\Collection([
            'email'    => [
                new \Symfony\Component\Validator\Constraints\NotBlank(),
            ],
            'password' => [
                new \Symfony\Component\Validator\Constraints\NotBlank(),
            ],
        ]);


        $this->validate($data, $validators);

        return $data;
    }
}