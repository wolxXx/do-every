<?php

declare(strict_types = 1);

namespace DoEveryApp\Action\Auth;

#[\DoEveryApp\Attribute\Action\Route(
    path        : '/auth/login',
    methods     : [
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
    authRequired: false
)]
class LoginAction extends
    \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public const string FORM_FIELD_EMAIL    = 'email';

    public const string FORM_FIELD_PASSWORD = 'password';

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (true === \DoEveryApp\Util\User\Current::isAuthenticated()) {
            return $this->redirect(to: \DoEveryApp\Action\Cms\IndexAction::getRoute());
        }

        if (true === $this->isGetRequest()) {
            return $this->render(
                script: 'action/auth/login',
                data  : ['data' => []],
            );
        }
        $data = [];
        try {
            $data     = $this
                ->getRequest()
                ->getParsedBody()
            ;
            $data     = $this->filterAndValidate(data: $data);
            $existing = \DoEveryApp\Entity\Worker::getRepository()
                                                 ->findOneByEmail(email: $data[static::FORM_FIELD_EMAIL])
            ;
            if (false === $existing instanceof \DoEveryApp\Entity\Worker) {
                $this
                    ->getErrorStore()
                    ->addError(
                        key    : static::FORM_FIELD_EMAIL,
                        message: \DoEveryApp\Util\DependencyContainer::getInstance()
                                                                     ->getTranslator()
                                                                     ->userNotFound())
                ;
                throw new \DoEveryApp\Exception\FormValidationFailed();
            }

            $credential = $existing->getPasswordCredential();
            if (false === $credential instanceof \DoEveryApp\Entity\Worker\Credential) {
                $this
                    ->getErrorStore()
                    ->addError(
                        key    : static::FORM_FIELD_EMAIL,
                        message: \DoEveryApp\Util\DependencyContainer::getInstance()
                                                                     ->getTranslator()
                                                                     ->userNotFound()
                    )
                ;
                throw new \DoEveryApp\Exception\FormValidationFailed();
            }

            if (false === \DoEveryApp\Util\Password::verify(password: $data[static::FORM_FIELD_PASSWORD], hash: $credential->getPassword())) {
                $this
                    ->getErrorStore()
                    ->addError(
                        key    : static::FORM_FIELD_EMAIL,
                        message: \DoEveryApp\Util\DependencyContainer::getInstance()
                                                                     ->getTranslator()
                                                                     ->userNotFound())
                ;
                throw new \DoEveryApp\Exception\FormValidationFailed();
            }

            if (null !== $credential->getTwoFactorSecret()) {
                $session = \DoEveryApp\Util\Session::Factory(namespace: '2faValidate');
                $session->write(what: 'user', data: $existing->getId());

                return $this->redirect(to: \DoEveryApp\Action\Auth\AuthenticateAction::getRoute());
            }

            \DoEveryApp\Util\User\Current::login(user: $existing, method: 'password');

            return $this->redirect(to: \DoEveryApp\Action\Cms\IndexAction::getRoute());
        } catch (\DoEveryApp\Exception\FormValidationFailed) {
        }

        return $this->render(script: 'action/auth/login', data: ['data' => $data]);
    }

    protected function filterAndValidate(array &$data): array
    {
        $data[static::FORM_FIELD_EMAIL]    = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_EMAIL))
        ;
        $data[static::FORM_FIELD_PASSWORD] = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_PASSWORD))
        ;

        $validators = new \Symfony\Component\Validator\Constraints\Collection(fields: [
                                                                                          static::FORM_FIELD_EMAIL    => [
                                                                                              new \Symfony\Component\Validator\Constraints\NotBlank(),
                                                                                          ],
                                                                                          static::FORM_FIELD_PASSWORD => [
                                                                                              new \Symfony\Component\Validator\Constraints\NotBlank(),
                                                                                          ],
                                                                                      ]);

        $this->validate(data: $data, validators: $validators);

        return $data;
    }
}
