<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Auth;

#[\DoEveryApp\Attribute\Action\Route(
    path        : '/auth/authenticate',
    methods     : [
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
    authRequired: false
)]
class AuthenticateAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public const string FORM_FIELD_CODE          = 'code';

    public const string FORM_FIELD_RECOVERY_CODE = 'recoveryCode';

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $session = \DoEveryApp\Util\Session::Factory(namespace: '2faValidate');
        $userId  = $session->get(what: 'user');
        if (null === $userId || false === \DoEveryApp\Entity\Worker::getRepository()->find(id: $userId) instanceof \DoEveryApp\Entity\Worker) {
            \DoEveryApp\Util\FlashMessenger::addDanger(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->defaultErrorMessage());
            $session->reset();

            return $this->redirect(to: \DoEveryApp\Action\Auth\LoginAction::getRoute());
        }
        $worker = \DoEveryApp\Entity\Worker::getRepository()->find(id: $userId);
        if (true === $this->isGetRequest()) {
            return $this->render(script: 'action/auth/authenticate', data: ['data' => []]);
        }
        try {
            $data         = $this->getRequest()->getParsedBody();
            $data         = $this->filterAndValidate(data: $data);
            $code         = $data['code'];
            $recoveryCode = $data['recoveryCode'];

            if (null !== $code) {
                $twoFactorUtility = \DoEveryApp\Util\TwoFactorAuthenticator::Factory();
                $verified         = $twoFactorUtility->verify(token: $code, secret: $worker->getTwoFactorSecret());
                if (false === $verified) {
                    $session->reset();
                    \DoEveryApp\Util\FlashMessenger::addDanger(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->defaultErrorMessage());

                    return $this->redirect(to: \DoEveryApp\Action\Auth\LoginAction::getRoute());
                }

                \DoEveryApp\Util\User\Current::login(user: $worker);

                return $this->redirect(to: \DoEveryApp\Action\Cms\IndexAction::getRoute());
            }

            if (null !== $recoveryCode) {
                try {
                    if ($recoveryCode === $worker->getTwoFactorRecoverCode1()) {
                        if (null !== $worker->getTwoFactorRecoverCode1UsedAt()) {
                            throw new \InvalidArgumentException();
                        }
                        $worker->setTwoFactorRecoverCode1UsedAt(twoFactorRecoverCode1UsedAt: \Carbon\Carbon::now());
                        $worker::getRepository()->update(entity: $worker);
                        \DoEveryApp\Util\DependencyContainer::getInstance()
                                                            ->getEntityManager()
                                                            ->flush()
                        ;
                        \DoEveryApp\Util\User\Current::login(user: $worker);

                        return $this->redirect(to: \DoEveryApp\Action\Cms\IndexAction::getRoute());
                    }
                    if ($recoveryCode === $worker->getTwoFactorRecoverCode2()) {
                        if (null !== $worker->getTwoFactorRecoverCode2UsedAt()) {
                            throw new \InvalidArgumentException();
                        }
                        $worker->setTwoFactorRecoverCode2UsedAt(twoFactorRecoverCode2UsedAt: \Carbon\Carbon::now());
                        $worker::getRepository()->update(entity: $worker);
                        \DoEveryApp\Util\DependencyContainer::getInstance()
                                                            ->getEntityManager()
                                                            ->flush()
                        ;
                        \DoEveryApp\Util\User\Current::login(user: $worker);

                        return $this->redirect(to: \DoEveryApp\Action\Cms\IndexAction::getRoute());
                    }
                    if ($recoveryCode === $worker->getTwoFactorRecoverCode3()) {
                        if (null !== $worker->getTwoFactorRecoverCode3UsedAt()) {
                            throw new \InvalidArgumentException();
                        }
                        $worker->setTwoFactorRecoverCode3UsedAt(twoFactorRecoverCode3UsedAt: \Carbon\Carbon::now());
                        $worker::getRepository()->update(entity: $worker);
                        \DoEveryApp\Util\DependencyContainer::getInstance()
                                                            ->getEntityManager()
                                                            ->flush()
                        ;
                        \DoEveryApp\Util\User\Current::login(user: $worker);

                        return $this->redirect(to: \DoEveryApp\Action\Cms\IndexAction::getRoute());
                    }
                } catch (\Throwable) {
                    $session->reset();
                    \DoEveryApp\Util\FlashMessenger::addDanger(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->defaultErrorMessage());

                    return $this->redirect(to: \DoEveryApp\Action\Auth\LoginAction::getRoute());
                }
            }

            $session->reset();
            \DoEveryApp\Util\FlashMessenger::addDanger(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->defaultErrorMessage());

            return $this->redirect(to: \DoEveryApp\Action\Auth\LoginAction::getRoute());
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }

        return $this->render(script: 'action/auth/authenticate', data: ['data' => []]);
    }

    protected function filterAndValidate(array &$data): array
    {
        $data[static::FORM_FIELD_CODE]          = (new \Laminas\Filter\FilterChain())
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_CODE))
        ;
        $data[static::FORM_FIELD_RECOVERY_CODE] = (new \Laminas\Filter\FilterChain())
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_RECOVERY_CODE))
        ;

        $validators = new \Symfony\Component\Validator\Constraints\Collection(fields: [
                                                                                  static::FORM_FIELD_CODE          => [
                                                                                  ],
                                                                                  static::FORM_FIELD_RECOVERY_CODE => [
                                                                                  ],
                                                                              ]);

        $this->validate(data: $data, validators: $validators);

        return $data;
    }
}
