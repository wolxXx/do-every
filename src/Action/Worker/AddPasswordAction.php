<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Worker;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/worker/add-password/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class AddPasswordAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\Worker;
    use \DoEveryApp\Action\Share\SingleIdRoute;

    public const string FORM_FIEL_PASSWORD        = 'password';

    public const string FORM_FIEL_PASSWORD_REPEAT = 'password_repeat';

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (false === ($worker = $this->getWorker()) instanceof \DoEveryApp\Entity\Worker) {
            return $worker;
        }
        if (null === $worker->getEmail()) {
            \DoEveryApp\Util\FlashMessenger::addDanger(message: $this->translator->needEmailForThisAction());

            return $this->redirect(to: \DoEveryApp\Action\Worker\IndexAction::getRoute());
        }

        if (true === $this->isGetRequest()) {
            return $this->render(
                script: 'action/worker/add-password',
                data  : [
                            'worker' => $worker,
                        ],
            );
        }

        try {
            \DoEveryApp\Util\QueryLogger::$disabled = true;

            $parsedBody = $this->request->getParsedBody();
            if ($parsedBody['password'] !== $parsedBody['password_repeat'] || ''  === \trim($parsedBody['password'])) {
                throw new \DoEveryApp\Exception\FormValidationFailed();
            }
            \DoEveryApp\Entity\Worker\Credential::getRepository()->create(
                entity: new \DoEveryApp\Entity\Worker\Credential()
                            ->setWorker(worker: $worker)
                            ->setPassword(password: '' . $parsedBody['password'])
                            ->setLastPasswordChange(lastPasswordChange: \Carbon\Carbon::now())
            );
            $this->entityManager->flush();
            \DoEveryApp\Util\FlashMessenger::addSuccess(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->passwordAdded());

            return $this->redirect(to: \DoEveryApp\Action\Worker\IndexAction::getRoute());
        } catch (\DoEveryApp\Exception\FormValidationFailed) {

        }

        return $this->render(
            script: 'action/worker/add-password',
            data  : [
                        'worker'           => $worker,
                    ],
        );
    }
}
