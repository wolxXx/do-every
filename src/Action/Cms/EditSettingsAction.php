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

    public const string FORM_FIELD_KEEP_BACKUPS   = 'keepBackups';

    public const string FORM_FIELD_FILL_TIME_LINE = 'fillTimeLine';

    public const string FORM_FIELD_PRECISION_DUE  = 'precisionDue';


    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $registry = \DoEveryApp\Util\Registry::getInstance();
        if (true === $this->isGetRequest()) {
            $data = [
                static::FORM_FIELD_KEEP_BACKUPS   => $registry->getKeepBackupDays(),
                static::FORM_FIELD_FILL_TIME_LINE => $registry->doFillTimeLine(),
                static::FORM_FIELD_PRECISION_DUE  => $registry->getPrecisionDue(),
            ];

            return $this->render('action/cms/editSettings', ['data' => $data]);
        }

        $data = [];
        try {
            $data = $this->getRequest()->getParsedBody();
            $data = $this->filterAndValidate($data);

            $registry
                ->setKeepBackupDays($data[static::FORM_FIELD_KEEP_BACKUPS])
                ->setDoFillTimeLine('1' === $data[static::FORM_FIELD_FILL_TIME_LINE])
                ->setPrecisionDue($data[static::FORM_FIELD_PRECISION_DUE])
            ;
            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess(\DoEveryApp\Util\DependencyContainer::getInstance()->getTranslator()->settingsSaved());

            return $this->redirect(ShowSettingsAction::getRoute());
        } catch (\DoEveryApp\Exception\FormValidationFailed $exception) {
        }

        return $this->render('action/cms/editSettings', ['data' => $data]);
    }


    protected function filterAndValidate(array &$data): array
    {
        $data[static::FORM_FIELD_KEEP_BACKUPS]   = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToInt())
            ->filter($this->getFromBody(static::FORM_FIELD_KEEP_BACKUPS))
        ;
        $data[static::FORM_FIELD_FILL_TIME_LINE] = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_FILL_TIME_LINE))
        ;
        $data[static::FORM_FIELD_PRECISION_DUE]  = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToInt())
            ->filter($this->getFromBody(static::FORM_FIELD_PRECISION_DUE))
        ;

        $validators = new \Symfony\Component\Validator\Constraints\Collection([
            static::FORM_FIELD_KEEP_BACKUPS   => [
            ],
            static::FORM_FIELD_FILL_TIME_LINE => [
            ],
            static::FORM_FIELD_PRECISION_DUE  => [
            ],
        ]);


        $this->validate($data, $validators);

        return $data;
    }
}