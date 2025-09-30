<?php

declare(strict_types = 1);

namespace DoEveryApp\Action\Auth;

#[\DoEveryApp\Attribute\Action\Route(
    path        : '/auth/passkey-login-xx',
    methods     : [
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
    authRequired: false
)]
class PasskeyLoginAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public const string FORM_FIELD_PUBLIC_KEY = 'publicKey';
    public const string FORM_FIELD_LOGIN      = 'login';

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        try {
            if (true === \DoEveryApp\Util\User\Current::isAuthenticated()) {
                throw new \DoEveryApp\Exception\FormValidationFailed();
            }
            $data = $this->getRequest()->getParsedBody();
            $data = $this->filterAndValidate(data: $data);

            \DoEveryApp\Util\QueryLogger::$disabled = true;
            $publicKey                         = $data[static::FORM_FIELD_PUBLIC_KEY];
            $login                         = $data[static::FORM_FIELD_LOGIN];
            $worker = \DoEveryApp\Entity\Worker::getRepository()->findOneByEmail($login);
            if (false === $worker instanceof \DoEveryApp\Entity\Worker) {
                throw new \DoEveryApp\Exception\FormValidationFailed();
            }
            /**
             * @var \DoEveryApp\Entity\Worker\Credential|null $credential
             */
            $credential = \DoEveryApp\Entity\Worker\Credential::getRepository()
                                                      ->createQueryBuilder('c')
                                                      ->andWhere('c.passkeySecret = :publicKey')
                                                      ->setParameter('publicKey', $publicKey)
                                                      ->andWhere('c.worker = :worker')
                                                      ->setParameter('worker', $worker)
                                                      ->getQuery()
                                                      ->getOneOrNullResult()
            ;
            if (null === $credential) {
                throw new \DoEveryApp\Exception\FormValidationFailed();
            }
            \DoEveryApp\Util\User\Current::login(user: $worker, method: 'passkey');

            $worker->setLastLogin(lastLogin: \Carbon\Carbon::now());
            $worker::getRepository()->update($worker);
            \DoEveryApp\Util\DependencyContainer::getInstance()
                                           ->getEntityManager()
                                           ->flush()
            ;

            return \DoEveryApp\Util\JsonGateway::Factory(response: $this->getResponse(), code: 204);
        } catch (\DoEveryApp\Exception\FormValidationFailed) {
            return \DoEveryApp\Util\JsonGateway::Factory(response: $this->getResponse(), code: 400);
        } catch (\Throwable $exception) {
            \DoEveryApp\Util\DependencyContainer::getInstance()->getLogger()->error(message: $exception);
            return \DoEveryApp\Util\JsonGateway::Factory(response: $this->getResponse(), code: 400);
        }
    }


    protected function filterAndValidate(array &$data): array
    {
        $validators = [
            static::FORM_FIELD_PUBLIC_KEY => [
            ],
            static::FORM_FIELD_LOGIN => [
            ],
        ];

        $data[static::FORM_FIELD_PUBLIC_KEY] = new \Laminas\Filter\FilterChain()
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_PUBLIC_KEY))
        ;

        $data[static::FORM_FIELD_LOGIN] = new \Laminas\Filter\FilterChain()
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_LOGIN))
        ;

        $this->validate(data: $data, validators: new \Symfony\Component\Validator\Constraints\Collection(fields: $validators));

        return $data;
    }
}