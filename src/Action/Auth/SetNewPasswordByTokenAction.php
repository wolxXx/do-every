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

    public const string FORM_FIELD_PASSWORD         = 'password';

    public const string FORM_FIELD_PASSWORD_CONFIRM = 'confirm_password';

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
            if (\Carbon\Carbon::createFromDate($started)->addMinutes(10) < \Carbon\Carbon::now()) {
                throw new \RuntimeException('took too long');
            }
        } catch (\Throwable $exception) {
            \DoEveryApp\Util\FlashMessenger::addDanger(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->codeNotValid());
            $session->reset();
            return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
        }

        if (true === $this->isGetRequest()) {
            return $this->render('action/auth/applyNewPassword', ['data' => []]);
        }
        $data = [];
        try {
            $data = $this->getRequest()->getParsedBody();
            $data = $this->filterAndValidate($data);

            if ($data[static::FORM_FIELD_PASSWORD] !== $data[static::FORM_FIELD_PASSWORD_CONFIRM]) {
                $this->getErrorStore()->addError('password', \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->passwordConfirmFailed());
                throw new \DoEveryApp\Exception\FormValidationFailed();
            }

            $existing
                ->setPassword($data[static::FORM_FIELD_PASSWORD])
                ->setLastPasswordChange(\Carbon\Carbon::now())
                ->setTokenValidUntil(null)
                ->setPasswordResetToken(null)
            ;
            $existing::getRepository()->update($existing);
            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\Mailing\PasswordChanged::send($existing);


            \DoEveryApp\Util\FlashMessenger::addSuccess(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->passwordChanged());
            return $this->redirect(\DoEveryApp\Action\Auth\LoginAction::getRoute());
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }

        return $this->render('action/auth/applyNewPassword', ['data' => $data]);
    }


    protected function filterAndValidate(array &$data): array
    {
        $data[static::FORM_FIELD_PASSWORD]         = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_PASSWORD))
        ;
        $data[static::FORM_FIELD_PASSWORD_CONFIRM] = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_PASSWORD_CONFIRM))
        ;

        $validators = new \Symfony\Component\Validator\Constraints\Collection([
            static::FORM_FIELD_PASSWORD         => [
                new \Symfony\Component\Validator\Constraints\NotBlank(),
            ],
            static::FORM_FIELD_PASSWORD_CONFIRM => [
                new \Symfony\Component\Validator\Constraints\NotBlank(),
            ],
        ]);

        $this->validate($data, $validators);

        return $data;
    }
}