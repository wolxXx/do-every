<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Group;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/group/add',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class AddAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public const string FORM_FIELD_NAME  = 'name';

    public const string FORM_FIELD_COLOR = 'color';

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (true === $this->isGetRequest()) {
            return $this->render('action/group/add', ['data' => []]);
        }
        $data = [];
        try {
            $data     = $this->getRequest()->getParsedBody();
            $data     = $this->filterAndValidate($data);
            $newGroup = \DoEveryApp\Service\Task\Group\Creator::execute(
                (new \DoEveryApp\Service\Task\Group\Creator\Bag())
                    ->setName($data[static::FORM_FIELD_NAME])
                    ->setColor($data[static::FORM_FIELD_COLOR])
            );

            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->groupAdded());

            return $this->redirect(\DoEveryApp\Action\Group\ShowAction::getRoute($newGroup->getId()));
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }

        return $this->render('action/group/add', ['data' => $data]);
    }

    protected function filterAndValidate(array &$data): array
    {
        $data[static::FORM_FIELD_NAME]  = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_NAME))
        ;
        $data[static::FORM_FIELD_COLOR] = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_COLOR))
        ;

        $validators = new \Symfony\Component\Validator\Constraints\Collection([
                                                                                  static::FORM_FIELD_COLOR => [

                                                                                  ],
                                                                                  static::FORM_FIELD_NAME  => [
                                                                                      new \Symfony\Component\Validator\Constraints\NotBlank(),
                                                                                  ],
                                                                              ]);

        $this->validate($data, $validators);

        return $data;
    }
}
