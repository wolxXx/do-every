<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Worker;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/worker/add',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class AddAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Worker\Share\AddEdit;
    use \DoEveryApp\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (true === $this->isGetRequest()) {
            return $this->render('action/worker/add', [
                'data' => [],
            ]);
        }
        $data = [];
        try {
            $data = $this->getRequest()->getParsedBody();
            $data = $this->filterAndValidate($data);
            \DoEveryApp\Service\Worker\Creator::execute(
                (new \DoEveryApp\Service\Worker\Creator\Bag())
                    ->setName($data[static::FORM_FIELD_NAME])
                    ->setIsAdmin('1' === $data[static::FORM_FIELD_IS_ADMIN])
                    ->enableNotifications('1' === $data[static::FORM_FIELD_DO_NOTIFY])
                    ->enableLoginNotifications('1' === $data[static::FORM_FIELD_DO_NOTIFY_LOGINS])
                    ->setEmail($data[static::FORM_FIELD_EMAIL])
                    ->setPassword(null === $data[static::FORM_FIELD_PASSWORD] ? null : $data[static::FORM_FIELD_PASSWORD])
            );

            $this
                ->entityManager
                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess($this->translator->workerAdded());

            return $this->redirect(\DoEveryApp\Action\Worker\IndexAction::getRoute());
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }

        return $this->render('action/worker/add', ['data' => $data]);
    }
}
