<?php

namespace DoEveryApp\Action\Auth;

#[\DoEveryApp\Attribute\Action\Route(
    path        : '/auth/new-password',
    methods     : [
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
    authRequired: false
)]
class SetNewPasswordByTokenAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $session = \DoEveryApp\Util\Session::Factory('passwordReset');
        $id      = $session->get('id');
        $token   = $session->get('token');
        $started = $session->get('started');
        try {
            if (null === $id || null === $token || null === $started) {
                throw new \RuntimeException('invalid data base');
            }
            $existing = \DoEveryApp\Entity\Worker::getRepository()->find($id);
            if (false === $existing instanceof \DoEveryApp\Entity\Worker) {
                throw new \RuntimeException('user not found by id');
            }
            $existing = \DoEveryApp\Entity\Worker::getRepository()->findOneByPasswordResetToken($token);
            if (false === $existing instanceof \DoEveryApp\Entity\Worker) {
                throw new \RuntimeException('user not found by token');
            }
            if(\Carbon\Carbon::createFromDate($started)->addMinutes(10) < \Carbon\Carbon::now()) {
                throw new \RuntimeException('took too long');
            }
        } catch (\Throwable $exception) {
            \DoEveryApp\Util\FlashMessenger::addDanger('Code ungültig.');
            $session->reset();
            return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
        }

        if (true === $this->isGetRequest()) {
            return $this->render('action/auth/applyNewPassword', ['data' => []]);
        }
        $data = [];
        try {
            $data     = $this->getRequest()->getParsedBody();
            $data     = $this->filterAndValidate($data);

            if($data['password'] !== $data['confirm_password']) {
                $this->getErrorStore()->addError('password', 'Passwortkontrolle fehlgeschlagen');
                throw new \InvalidArgumentException('password mismatch');
            }

            $existing
                ->setPassword($data['password'])
                ->setTokenValidUntil(null)
                ->setPasswordResetToken(null)
            ;
            $existing::getRepository()->update($existing);
            \DoEveryApp\Util\DependencyContainer::getInstance()
                ->getEntityManager()
                ->flush()
            ;
            \DoEveryApp\Util\Mailing\PasswordChanged::send($existing);

            \DoEveryApp\Util\FlashMessenger::addSuccess('Passwort geändert.');
            return $this->redirect(\DoEveryApp\Action\Auth\LoginAction::getRoute());
        } catch (\Throwable $exception) {
            #\var_dump($data);
            #die('');
            #throw $exception;
        }

        return $this->render('action/auth/applyNewPassword', ['data' => $data]);
    }


    protected function filterAndValidate(array &$data): array
    {
        $data['password'] = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('password'))
        ;
        $data['confirm_password'] = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('confirm_password'))
        ;

        $validators = new \Symfony\Component\Validator\Constraints\Collection([
                                                                                  'password' => [
                                                                                      new \Symfony\Component\Validator\Constraints\NotBlank(),
                                                                                  ],
                                                                                  'confirm_password' => [
                                                                                      new \Symfony\Component\Validator\Constraints\NotBlank(),
                                                                                  ],
                                                                              ]);


        $this->validate($data, $validators);

        return $data;
    }
}