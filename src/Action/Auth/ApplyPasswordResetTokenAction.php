<?php

namespace DoEveryApp\Action\Auth;

#[\DoEveryApp\Attribute\Action\Route(
    path: '/auth/apply-code',
    methods: [
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
            return $this->render('action/auth/applyPasswordResetToken', ['data' => []]);
        }
        $data = [];
        try {
            $data = $this
                ->getRequest()
                ->getParsedBody();
            $data = $this->filterAndValidate($data);
            $existing = \DoEveryApp\Entity\Worker::getRepository()
                ->findOneByPasswordResetToken($data[static::FORM_FIELD_TOKEN]);
            if (false === $existing instanceof \DoEveryApp\Entity\Worker) {
                \DoEveryApp\Util\FlashMessenger::addDanger(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->codeNotValid());

                return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
            }
            if (null === $existing->getTokenValidUntil() || $existing->getTokenValidUntil() < \Carbon\Carbon::now()) {
                \DoEveryApp\Util\FlashMessenger::addDanger(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->codeNotValid());

                return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
            }

            \DoEveryApp\Util\Session::Factory('passwordReset')
                ->write('id', $existing->getId())
                ->write('token', $existing->getPasswordResetToken())
                ->write('started', \Carbon\Carbon::now()->format('Y-m-d H:i:s'));

            return $this->redirect(\DoEveryApp\Action\Auth\SetNewPasswordByTokenAction::getRoute());
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }

        return $this->render('action/auth/applyPasswordResetToken', ['data' => $data]);
    }


    protected function filterAndValidate(array &$data): array
    {
        $data[static::FORM_FIELD_TOKEN] = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_TOKEN));

        $validators = new \Symfony\Component\Validator\Constraints\Collection([
            static::FORM_FIELD_TOKEN => [
                new \Symfony\Component\Validator\Constraints\NotBlank(),
            ],
        ]);


        $this->validate($data, $validators);

        return $data;
    }
}