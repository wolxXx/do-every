<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Worker;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/worker/edit/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class EditAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\Worker;
    use \DoEveryApp\Action\Worker\Share\AddEdit;
    use \DoEveryApp\Action\Share\SingleIdRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (false === ($worker = $this->getWorker()) instanceof \DoEveryApp\Entity\Worker) {
            return $worker;
        }
        if (true === $this->isGetRequest()) {
            return $this->render('action/worker/edit', [
                'worker' => $worker,
                'data'   => [
                    static::FORM_FIELD_NAME             => $worker->getName(),
                    static::FORM_FIELD_EMAIL            => $worker->getEmail(),
                    static::FORM_FIELD_IS_ADMIN         => $worker->isAdmin() ? '1' : '0',
                    static::FORM_FIELD_DO_NOTIFY        => $worker->doNotify() ? '1' : '0',
                    static::FORM_FIELD_DO_NOTIFY_LOGINS => $worker->doNotifyLogin() ? '1' : '0',
                    static::FORM_FIELD_PASSWORD         => '',
                ],
            ]);
        }
        $data = [];
        try {
            $data = $this->getRequest()->getParsedBody();
            $data = $this->filterAndValidate($data);
            $worker
                ->setName($data[static::FORM_FIELD_NAME])
                ->setIsAdmin('1' === $data[static::FORM_FIELD_IS_ADMIN])
                ->enableNotifications('1' === $data[static::FORM_FIELD_DO_NOTIFY])
                ->setNotifyLogin('1' === $data[static::FORM_FIELD_DO_NOTIFY_LOGINS])
                ->setEmail($data[static::FORM_FIELD_EMAIL])
            ;
            if (null !== $data[static::FORM_FIELD_PASSWORD]) {
                $worker
                    ->setPassword($data[static::FORM_FIELD_PASSWORD])
                    ->setLastPasswordChange(\Carbon\Carbon::now())
                ;
            }

            $this
                ->entityManager
                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess($this->translator->workerEdited());

            return $this->redirect(\DoEveryApp\Action\Worker\IndexAction::getRoute());
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }

        return $this->render(
            'action/worker/edit',
            [
                'worker' => $worker,
                'data'   => $data,
            ]
        );
    }
}