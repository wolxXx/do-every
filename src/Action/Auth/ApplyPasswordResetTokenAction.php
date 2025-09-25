<?php

declare(strict_types = 1);

namespace DoEveryApp\Action\Auth;

#[\DoEveryApp\Attribute\Action\Route(
    path        : '/auth/apply-code',
    methods     : [
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
    authRequired: false
)]
class ApplyPasswordResetTokenAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public const string FORM_FIELD_TOKEN = 'token';

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (true === $this->isGetRequest()) {
            return $this->render(script: 'action/auth/applyPasswordResetToken');
        }
        $data = [];
        try {
            $data     = $this
                ->getRequest()
                ->getParsedBody()
            ;
            $data     = $this->filterAndValidate(data: $data);
            $existing = \DoEveryApp\Entity\Worker::getRepository()
                                                 ->findOneByPasswordResetToken(token: $data[static::FORM_FIELD_TOKEN])
            ;
            if (false === $existing instanceof \DoEveryApp\Entity\Worker) {
                \DoEveryApp\Util\FlashMessenger::addDanger(message: \DoEveryApp\Util\DependencyContainer::getInstance()
                                                                                                        ->getTranslator()
                                                                                                        ->codeNotValid(),
                );

                return $this->redirect(to: \DoEveryApp\Action\Cms\IndexAction::getRoute());
            }
            if (null === $existing->getTokenValidUntil() || $existing->getTokenValidUntil() < \Carbon\Carbon::now()) {
                \DoEveryApp\Util\FlashMessenger::addDanger(message: \DoEveryApp\Util\DependencyContainer::getInstance()
                                                                                                        ->getTranslator()
                                                                                                        ->codeNotValid(),
                );

                return $this->redirect(to: \DoEveryApp\Action\Cms\IndexAction::getRoute());
            }

            \DoEveryApp\Util\Session::Factory(namespace: 'passwordReset')
                                    ->write(what: 'id', data: $existing->getId())
                                    ->write(what: 'token', data: $existing->getPasswordResetToken())
                                    ->write(what: 'started', data: \Carbon\Carbon::now()
                                                                                 ->format(format: 'Y-m-d H:i:s'))
            ;

            return $this->redirect(to: \DoEveryApp\Action\Auth\SetNewPasswordByTokenAction::getRoute());
        } catch (\DoEveryApp\Exception\FormValidationFailed) {
        }

        return $this->render(script: 'action/auth/applyPasswordResetToken', data: ['data' => $data]);
    }

    protected function filterAndValidate(array &$data): array
    {
        $fields = [];
        {
            $data[static::FORM_FIELD_TOKEN]   = new \Laminas\Filter\FilterChain()
                ->attach(callback: new \Laminas\Filter\StringTrim())
                ->attach(callback: new \Laminas\Filter\ToNull())
                ->filter(value: $this->getFromBody(key: static::FORM_FIELD_TOKEN))
            ;
            $fields[static::FORM_FIELD_TOKEN] = [
                new \Symfony\Component\Validator\Constraints\NotBlank(),
            ];
        }

        $this->validate(data: $data, validators: new \Symfony\Component\Validator\Constraints\Collection(fields: $fields));

        return $data;
    }
}
