<?php

declare(strict_types=1);

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
        $session = \DoEveryApp\Util\Session::Factory(namespace: 'passwordReset');
        $id      = $session->get(what: 'id');
        $token   = $session->get(what: 'token');
        $started = $session->get(what: 'started');
        try {
            if (null === $id || null === $token || null === $started) {
                throw new \RuntimeException(message: 'invalid data base');
            }
            $existing = \DoEveryApp\Entity\Worker::getRepository()->find(id: $id);
            if (false === $existing instanceof \DoEveryApp\Entity\Worker) {
                throw new \RuntimeException(message: 'user not found by id');
            }
            $existing = \DoEveryApp\Entity\Worker::getRepository()->findOneByPasswordResetToken(token: $token);
            if (false === $existing instanceof \DoEveryApp\Entity\Worker) {
                throw new \RuntimeException(message: 'user not found by token');
            }
            if (\Carbon\Carbon::createFromDate(year: $started)->addMinutes(value: 10) < \Carbon\Carbon::now()) {
                throw new \RuntimeException(message: 'took too long');
            }
        } catch (\Throwable $exception) {
            \DoEveryApp\Util\FlashMessenger::addDanger(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->codeNotValid());
            $session->reset();

            return $this->redirect(to: \DoEveryApp\Action\Cms\IndexAction::getRoute());
        }

        if (true === $this->isGetRequest()) {
            return $this->render(script: 'action/auth/applyNewPassword', data: ['data' => []]);
        }
        $data = [];
        try {
            $data = $this->getRequest()->getParsedBody();
            $data = $this->filterAndValidate(data: $data);

            if ($data[static::FORM_FIELD_PASSWORD] !== $data[static::FORM_FIELD_PASSWORD_CONFIRM]) {
                $this->getErrorStore()->addError(key: 'password', message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->passwordConfirmFailed());
                throw new \DoEveryApp\Exception\FormValidationFailed();
            }

            $existing
                ->setPassword(password: $data[static::FORM_FIELD_PASSWORD])
                ->setLastPasswordChange(lastPasswordChange: \Carbon\Carbon::now())
                ->setTokenValidUntil(tokenValidUntil: null)
                ->setPasswordResetToken(passwordResetToken: null)
            ;
            $existing::getRepository()->update(entity: $existing);
            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\Mailing\PasswordChanged::send(worker: $existing);

            \DoEveryApp\Util\FlashMessenger::addSuccess(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->passwordChanged());

            return $this->redirect(to: \DoEveryApp\Action\Auth\LoginAction::getRoute());
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }

        return $this->render(script: 'action/auth/applyNewPassword', data: ['data' => $data]);
    }

    protected function filterAndValidate(array &$data): array
    {
        $data[static::FORM_FIELD_PASSWORD]         = (new \Laminas\Filter\FilterChain())
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_PASSWORD))
        ;
        $data[static::FORM_FIELD_PASSWORD_CONFIRM] = (new \Laminas\Filter\FilterChain())
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_PASSWORD_CONFIRM))
        ;

        $validators = new \Symfony\Component\Validator\Constraints\Collection(fields: [
                                                                                  static::FORM_FIELD_PASSWORD         => [
                                                                                      new \Symfony\Component\Validator\Constraints\NotBlank(),
                                                                                  ],
                                                                                  static::FORM_FIELD_PASSWORD_CONFIRM => [
                                                                                      new \Symfony\Component\Validator\Constraints\NotBlank(),
                                                                                  ],
                                                                              ]);

        $this->validate(data: $data, validators: $validators);

        return $data;
    }
}
