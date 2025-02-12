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
        $group = \DoEveryApp\Entity\Group::getRepository()->find($this->getArgumentSafe());
        if (false === $group instanceof \DoEveryApp\Entity\Group) {
            \DoEveryApp\Util\FlashMessenger::addDanger(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->groupNotFound());

            return $this->redirect(\DoEveryApp\Action\Cms\IndexAction::getRoute());
        }
        if (true === $this->isGetRequest()) {
            return $this->render(
                'action/group/edit',
                [
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
            $data = $this->filterAndValidate($data);
            $group
                ->setName($data['name'])
                ->setColor($data['color'])
            ;

            $group::getRepository()->update($group);
            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->groupEdited());

            return $this->redirect(\DoEveryApp\Action\Group\ShowAction::getRoute($group->getId()));
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }

        return $this->render(
            'action/group/edit',
            [
                'group' => $group,
                'data'  => $data,
            ]
        );
    }

    protected function filterAndValidate(array &$data): array
    {
        $data['name']  = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('name'))
        ;
        $data['color'] = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('color'))
        ;

        $validators = new \Symfony\Component\Validator\Constraints\Collection([
                                                                                  'color' => [

                                                                                  ],
                                                                                  'name'  => [
                                                                                      new \Symfony\Component\Validator\Constraints\NotBlank(),
                                                                                  ],

                                                                              ]);

        $this->validate($data, $validators);

        return $data;
    }
}
