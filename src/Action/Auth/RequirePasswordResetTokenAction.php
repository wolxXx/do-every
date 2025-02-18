<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Auth;

#[\DoEveryApp\Attribute\Action\Route(
    path        : '/auth/lost-password',
    methods     : [
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
    authRequired: false
)]
class RequirePasswordResetTokenAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public const string FORM_FIELD_EMAIL = 'email';

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (true === $this->isGetRequest()) {
            return $this->render(script: 'action/auth/requirePasswordResetToken', data: ['data' => []]);
        }
        $data = [];
        try {
            $data     = $this->getRequest()->getParsedBody();
            $data     = $this->filterAndValidate(data: $data);
            $existing = \DoEveryApp\Entity\Worker::getRepository()->findOneByEmail(email: $data[self::FORM_FIELD_EMAIL]);
            if (false === $existing instanceof \DoEveryApp\Entity\Worker) {
                \DoEveryApp\Util\FlashMessenger::addSuccess(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->codeSent());

                return $this->redirect(to: \DoEveryApp\Action\Auth\ApplyPasswordResetTokenAction::getRoute());
            }

            $existing
                ->setPasswordResetToken(passwordResetToken: \DoEveryApp\Util\TokenGenerator::getUserPasswordReset())
                ->setTokenValidUntil(tokenValidUntil: \DoEveryApp\Util\TokenGenerator::getUserPasswordResetValidUntil())
            ;
            $existing::getRepository()->update(entity: $existing);
            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\Mailing\RequirePasswordResetToken::send(worker: $existing);
            \DoEveryApp\Util\FlashMessenger::addSuccess(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->codeSent());

            return $this->redirect(to: \DoEveryApp\Action\Auth\ApplyPasswordResetTokenAction::getRoute());
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }

        return $this->render(script: 'action/auth/requirePasswordResetToken', data: ['data' => $data]);
    }

    protected function filterAndValidate(array &$data): array
    {
        $data[self::FORM_FIELD_EMAIL] = (new \Laminas\Filter\FilterChain())
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(key: self::FORM_FIELD_EMAIL))
        ;

        $validators = new \Symfony\Component\Validator\Constraints\Collection(fields: [
                                                                                  self::FORM_FIELD_EMAIL => [
                                                                                      new \Symfony\Component\Validator\Constraints\NotBlank(),
                                                                                  ],
                                                                              ]);

        $this->validate(data: $data, validators: $validators);

        return $data;
    }
}
