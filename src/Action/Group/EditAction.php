<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Group;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/group/edit/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class EditAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SingleIdRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $group = \DoEveryApp\Entity\Group::getRepository()->find(id: $this->getArgumentSafe());
        if (false === $group instanceof \DoEveryApp\Entity\Group) {
            \DoEveryApp\Util\FlashMessenger::addDanger(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->groupNotFound());

            return $this->redirect(to: \DoEveryApp\Action\Cms\IndexAction::getRoute());
        }
        if (true === $this->isGetRequest()) {
            return $this->render(
                script: 'action/group/edit',
                data: [
                    'group' => $group,
                    'data'  => [
                        'name'  => $group->getName(),
                        'color' => $group->getColor(),
                    ],
                ]
            );
        }
        $data = [];
        try {
            $data = $this->getRequest()->getParsedBody();
            $data = $this->filterAndValidate(data: $data);
            $group
                ->setName(name: $data['name'])
                ->setColor(color: $data['color'])
            ;

            $group::getRepository()->update(entity: $group);
            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess(message: \DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->groupEdited());

            return $this->redirect(to: \DoEveryApp\Action\Group\ShowAction::getRoute(id: $group->getId()));
        } catch (\DoEveryApp\Exception\FormValidationFailed) {
        }

        return $this->render(
            script: 'action/group/edit',
            data: [
                'group' => $group,
                'data'  => $data,
            ]
        );
    }

    protected function filterAndValidate(array &$data): array
    {
        $data['name']  = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(key: 'name'))
        ;
        $data['color'] = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(key: 'color'))
        ;

        $validators = new \Symfony\Component\Validator\Constraints\Collection(fields: [
                                                                                  'color' => [

                                                                                  ],
                                                                                  'name'  => [
                                                                                      new \Symfony\Component\Validator\Constraints\NotBlank(),
                                                                                  ],

                                                                              ]);

        $this->validate(data: $data, validators: $validators);

        return $data;
    }
}
