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
            return $this->render(script: 'action/worker/add', data: [
                'data' => [],
            ]);
        }
        $data = [];
        try {
            $data = $this->getRequest()->getParsedBody();
            $data = $this->filterAndValidate(data: $data);
            \DoEveryApp\Service\Worker\Creator::execute(
                bag: new \DoEveryApp\Service\Worker\Creator\Bag()
                    ->setName(name: $data[static::FORM_FIELD_NAME])
                    ->setIsAdmin(admin: '1' === $data[static::FORM_FIELD_IS_ADMIN])
                    ->enableNotifications(notify: '1' === $data[static::FORM_FIELD_DO_NOTIFY])
                    ->enableLoginNotifications(notifyLogins: '1' === $data[static::FORM_FIELD_DO_NOTIFY_LOGINS])
                    ->setEmail(email: $data[static::FORM_FIELD_EMAIL])
            );

            $this
                ->entityManager
                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess(message: $this->translator->workerAdded());

            return $this->redirect(to: \DoEveryApp\Action\Worker\IndexAction::getRoute());
        } catch (\DoEveryApp\Exception\FormValidationFailed) {
        }

        return $this->render(script: 'action/worker/add', data: ['data' => $data]);
    }
}
