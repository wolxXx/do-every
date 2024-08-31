<?php

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
                    ->setName($data['name'])
                    ->setColor($data['color'])
            );

            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess('Gruppe erstellt.');

            return $this->redirect(\DoEveryApp\Action\Group\ShowAction::getRoute($newGroup->getId()));
        } catch (\Throwable $exception) {
            \var_dump($data);
            #die('');
            throw $exception;
        }


        return $this->render('action/group/add', ['data' => $data]);
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