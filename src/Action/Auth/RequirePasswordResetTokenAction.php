<?php

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
            return $this->render('action/auth/requirePasswordResetToken', ['data' => []]);
        }
        $data = [];
        try {
            $data     = $this->getRequest()->getParsedBody();
            $data     = $this->filterAndValidate($data);
            $existing = \DoEveryApp\Entity\Worker::getRepository()->findOneByEmail($data[self::FORM_FIELD_EMAIL]);
            if (false === $existing instanceof \DoEveryApp\Entity\Worker) {
                \DoEveryApp\Util\FlashMessenger::addSuccess('Code verschickt.');

                return $this->redirect(\DoEveryApp\Action\Auth\ApplyPasswordResetTokenAction::getRoute());
            }

            $existing
                ->setPasswordResetToken(\DoEveryApp\Util\TokenGenerator::getUserPasswordReset())
                ->setTokenValidUntil(\DoEveryApp\Util\TokenGenerator::getUserPasswordResetValidUntil())
            ;
            $existing::getRepository()->update($existing);
            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\Mailing\RequirePasswordResetToken::send($existing);
            \DoEveryApp\Util\FlashMessenger::addSuccess('Code verschickt.');

            return $this->redirect(\DoEveryApp\Action\Auth\ApplyPasswordResetTokenAction::getRoute());
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }


        return $this->render('action/auth/requirePasswordResetToken', ['data' => $data]);
    }


    protected function filterAndValidate(array &$data): array
    {
        $data[self::FORM_FIELD_EMAIL] = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(self::FORM_FIELD_EMAIL))
        ;

        $validators = new \Symfony\Component\Validator\Constraints\Collection([
            self::FORM_FIELD_EMAIL => [
                new \Symfony\Component\Validator\Constraints\NotBlank(),
            ],
        ]);


        $this->validate($data, $validators);

        return $data;
    }
}