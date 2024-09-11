<?php

namespace DoEveryApp\Action\Cms;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/edit-settings',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
    ],
)]
class EditSettingsAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $registry = \DoEveryApp\Util\Registry::getInstance();
        if (true === $this->isGetRequest()) {
            $data = [
                'keepBackups'  => $registry->getKeepBackupDays(),
                'fillTimeLine' => $registry->doFillTimeLine(),
                'precisionDue' => $registry->getPrecisionDue(),
            ];
            return $this->render('action/cms/editSettings', ['data' => $data]);
        }

        try {
            $data = $this->getRequest()->getParsedBody();
            $data = $this->filterAndValidate($data);

            $registry
                ->setKeepBackupDays($data['keepBackups'])
                ->setDoFillTimeLine('1' === $data['fillTimeLine'])
                ->setPrecisionDue($data['precisionDue'])
            ;
            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess('Einstellungen gespeichert.');

            return $this->redirect(ShowSettingsAction::getRoute());
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }

        return $this->render('action/cms/editSettings', ['data' => $data]);
    }


    protected function filterAndValidate(array &$data): array
    {
        $data['keepBackups']  = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToInt())
            ->filter($this->getFromBody('keepBackups'))
        ;
        $data['fillTimeLine'] = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('fillTimeLine'))
        ;
        $data['precisionDue'] = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToInt())
            ->filter($this->getFromBody('precisionDue'))
        ;

        $validators = new \Symfony\Component\Validator\Constraints\Collection([
            'keepBackups'  => [
            ],
            'fillTimeLine' => [
            ],
            'precisionDue' => [
            ],
        ]);


        $this->validate($data, $validators);

        return $data;
    }
}