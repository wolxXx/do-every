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

    public const string FORM_FIELD_EMAIL    = 'email';

    public const string FORM_FIELD_PASSWORD = 'password';


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
            $existing = \DoEveryApp\Entity\Worker::getRepository()->findOneByEmail($data[static::FORM_FIELD_EMAIL]);
            if (false === $existing instanceof \DoEveryApp\Entity\Worker) {
                $this->getErrorStore()->addError(static::FORM_FIELD_EMAIL, 'user not found');
                throw new \DoEveryApp\Exception\FormValidationFailed('User not found');
            }
            if (false === \DoEveryApp\Util\Password::verify($data[static::FORM_FIELD_PASSWORD], $existing->getPassword())) {
                $this->getErrorStore()->addError(static::FORM_FIELD_EMAIL, 'user not found');
                throw new \DoEveryApp\Exception\FormValidationFailed('User not found');
            }

            if (true === $existing->doNotifyLogin()) {
                \DoEveryApp\Util\Mailing\Login::send($existing);
            }
            \DoEveryApp\Util\User\Current::login($existing);
            $existing->setLastLogin(\Carbon\Carbon::now());
            $existing::getRepository()->update($existing);
            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;

            \DoEveryApp\Util\FlashMessenger::addSuccess('welcome, ' . \DoEveryApp\Util\View\Worker::get($existing));

            return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }


        return $this->render('action/auth/login', ['data' => $data]);
    }


    protected function filterAndValidate(array &$data): array
    {
        $data[static::FORM_FIELD_EMAIL]    = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_EMAIL))
        ;
        $data[static::FORM_FIELD_PASSWORD] = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_PASSWORD))
        ;

        $validators = new \Symfony\Component\Validator\Constraints\Collection([
                                                                                  static::FORM_FIELD_EMAIL    => [
                                                                                      new \Symfony\Component\Validator\Constraints\NotBlank(),
                                                                                  ],
                                                                                  static::FORM_FIELD_PASSWORD => [
                                                                                      new \Symfony\Component\Validator\Constraints\NotBlank(),
                                                                                  ],
                                                                              ]);


        $this->validate($data, $validators);

        return $data;
    }
}