<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Worker;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/worker/enable-passkey/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class EnablePasskeyAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\Worker;
    use \DoEveryApp\Action\Share\SingleIdRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (false === ($worker = $this->getWorker()) instanceof \DoEveryApp\Entity\Worker) {
            return $worker;
        }
        if (null === $worker->getEmail()) {
            \DoEveryApp\Util\FlashMessenger::addDanger(message: $this->translator->needEmailForThisAction());

            return $this->redirect(to: \DoEveryApp\Action\Worker\IndexAction::getRoute());
        }

        if (true === $this->isPostRequest()) {
            \DoEveryApp\Util\QueryLogger::$disabled = true;

            \DoEveryApp\Entity\Worker\Credential::getRepository()->create(
                entity: new \DoEveryApp\Entity\Worker\Credential()
                    ->setWorker(worker: $worker)
                    ->setPasskeySecret(passkeySecret: '' . $this->request->getParsedBody()['id'])
            );
            $this->entityManager->flush();
            \DoEveryApp\Util\FlashMessenger::addSuccess(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->passkeyAdded());

            return \DoEveryApp\Util\JsonGateway::Factory(response: $this->response, data: ['message' => 'OK']);
        }

        $challenge = base64_encode(random_bytes(10));

        $pubKeyCredParams = [
            'type' => 'public-key',
            'alg'  => -7, // ES256 algorithm
        ];

        $rpEntity = \Webauthn\PublicKeyCredentialRpEntity::create(
            name: 'Do Every*',
            id:   false === str_contains($_SERVER['HTTP_HOST'], 'localhost') ? $_SERVER['HTTP_HOST'] : 'localhost',
        );

        $userEntity = \Webauthn\PublicKeyCredentialUserEntity::create(
            name       : $worker->getEmail(),
            id         : 'XX' . $worker->getId().'xx',
            displayName: $worker->getName()
        );

        return $this->render(
            script: 'action/worker/enable-passkey',
            data  : [
                        'pubKeyCredParams' => $pubKeyCredParams,
                        'challenge'        => $challenge,
                        'rpEntity'         => $rpEntity,
                        'userEntity'       => $userEntity,
                        'worker'           => $worker,
                    ],
        );
    }
}
