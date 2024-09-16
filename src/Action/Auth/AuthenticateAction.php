<?php

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
        $session = \DoEveryApp\Util\Session::Factory('2faValidate');
        $userId  = $session->get('user');
        if (null === $userId || false === \DoEveryApp\Entity\Worker::getRepository()->find($userId) instanceof \DoEveryApp\Entity\Worker) {
            \DoEveryApp\Util\FlashMessenger::addDanger(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->defaultErrorMessage());
            $session->reset();

            return $this->redirect(\DoEveryApp\Action\Auth\LoginAction::getRoute());
        }
        $worker = \DoEveryApp\Entity\Worker::getRepository()->find($userId);
        if (true === $this->isGetRequest()) {
            return $this->render('action/auth/authenticate', ['data' => []]);
        }
        try {
            $data         = $this->getRequest()->getParsedBody();
            $data         = $this->filterAndValidate($data);
            $code         = $data['code'];
            $recoveryCode = $data['recoveryCode'];

            if (null !== $code) {
                $twoFactorUtility = \DoEveryApp\Util\TwoFactorAuthenticator::Factory();
                $verified         = $twoFactorUtility->verify($code, $worker->getTwoFactorSecret());
                if (false === $verified) {
                    $session->reset();
                    \DoEveryApp\Util\FlashMessenger::addDanger(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->defaultErrorMessage());

                    return $this->redirect(\DoEveryApp\Action\Auth\LoginAction::getRoute());
                }

                \DoEveryApp\Util\User\Current::login($worker);

                return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
            }

            if (null !== $recoveryCode) {
                try {
                    if ($recoveryCode === $worker->getTwoFactorRecoverCode1()) {
                        if (null !== $worker->getTwoFactorRecoverCode1UsedAt()) {
                            throw new \InvalidArgumentException();
                        }
                        $worker->setTwoFactorRecoverCode1UsedAt(\Carbon\Carbon::now());
                        $worker::getRepository()->update($worker);
                        \DoEveryApp\Util\DependencyContainer::getInstance()
                                                            ->getEntityManager()
                                                            ->flush()
                        ;
                        \DoEveryApp\Util\User\Current::login($worker);

                        return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
                    }
                    if ($recoveryCode === $worker->getTwoFactorRecoverCode2()) {
                        if (null !== $worker->getTwoFactorRecoverCode2UsedAt()) {
                            throw new \InvalidArgumentException();
                        }
                        $worker->setTwoFactorRecoverCode2UsedAt(\Carbon\Carbon::now());
                        $worker::getRepository()->update($worker);
                        \DoEveryApp\Util\DependencyContainer::getInstance()
                                                            ->getEntityManager()
                                                            ->flush()
                        ;
                        \DoEveryApp\Util\User\Current::login($worker);

                        return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
                    }
                    if ($recoveryCode === $worker->getTwoFactorRecoverCode3()) {
                        if (null !== $worker->getTwoFactorRecoverCode3UsedAt()) {
                            throw new \InvalidArgumentException();
                        }
                        $worker->setTwoFactorRecoverCode3UsedAt(\Carbon\Carbon::now());
                        $worker::getRepository()->update($worker);
                        \DoEveryApp\Util\DependencyContainer::getInstance()
                                                            ->getEntityManager()
                                                            ->flush()
                        ;
                        \DoEveryApp\Util\User\Current::login($worker);

                        return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
                    }
                } catch (\Throwable) {
                    $session->reset();
                    \DoEveryApp\Util\FlashMessenger::addDanger(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->defaultErrorMessage());

                    return $this->redirect(\DoEveryApp\Action\Auth\LoginAction::getRoute());
                }
            }

            $session->reset();
            \DoEveryApp\Util\FlashMessenger::addDanger(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->defaultErrorMessage());

            return $this->redirect(\DoEveryApp\Action\Auth\LoginAction::getRoute());
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }

        return $this->render('action/auth/authenticate', ['data' => []]);
    }


    protected function filterAndValidate(array &$data): array
    {
        $data[static::FORM_FIELD_CODE]          = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_CODE))
        ;
        $data[static::FORM_FIELD_RECOVERY_CODE] = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_RECOVERY_CODE))
        ;

        $validators = new \Symfony\Component\Validator\Constraints\Collection([
                                                                                  static::FORM_FIELD_CODE          => [
                                                                                  ],
                                                                                  static::FORM_FIELD_RECOVERY_CODE => [
                                                                                  ],
                                                                              ]);


        $this->validate($data, $validators);

        return $data;
    }
}