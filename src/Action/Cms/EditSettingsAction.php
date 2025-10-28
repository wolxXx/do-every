<?php

declare(strict_types = 1);

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

    public const string FORM_FIELD_KEEP_BACKUPS             = 'keepBackups';

    public const string FORM_FIELD_BACKUP_DELAY             = 'backupDelay';

    public const string FORM_FIELD_FILL_TIME_LINE           = 'fillTimeLine';

    public const string FORM_FIELD_PRECISION_DUE            = 'precisionDue';

    public const string FORM_FIELD_USE_TIMER                = 'useTimer';

    public const string FORM_FIELD_MARKDOWN_ENABLED         = 'markdownEnabled';

    public const string FORM_FIELD_PASSWORD_CHANGE_INTERVAL = 'passwordChangeInterval';

    public const string FORM_FIELD_CONTENT_SECURITY         = 'contentSecurity';

    public const string FORM_FIELD_CONTENT_STEPS            = 'contentSteps';

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        $registry = \DoEveryApp\Util\Registry::getInstance();
        if (true === $this->isGetRequest()) {
            $data = [
                static::FORM_FIELD_BACKUP_DELAY             => $registry->backupDelay(),
                static::FORM_FIELD_KEEP_BACKUPS             => $registry->getKeepBackupDays(),
                static::FORM_FIELD_FILL_TIME_LINE           => $registry->doFillTimeLine(),
                static::FORM_FIELD_PRECISION_DUE            => $registry->getPrecisionDue(),
                static::FORM_FIELD_USE_TIMER                => $registry->doUseTimer(),
                static::FORM_FIELD_MARKDOWN_ENABLED         => $registry->isMarkdownTransformerActive(),
                static::FORM_FIELD_PASSWORD_CHANGE_INTERVAL => $registry->passwordChangeInterval(),
                static::FORM_FIELD_CONTENT_SECURITY         => $registry->mailContentSecurityNote(),
                static::FORM_FIELD_CONTENT_STEPS            => $registry->mailContentSteps(),
            ];

            return $this->render(script: 'action/cms/editSettings', data: ['data' => $data]);
        }

        $data = [];
        try {
            $data = $this
                ->getRequest()
                ->getParsedBody()
            ;
            $data = $this->filterAndValidate(data: $data);

            $registry
                ->setKeepBackupDays(days: $data[static::FORM_FIELD_KEEP_BACKUPS])
                ->setBackupDelay(delay: $data[static::FORM_FIELD_BACKUP_DELAY])
                ->setDoFillTimeLine(fillTimeLine: '1' === $data[static::FORM_FIELD_FILL_TIME_LINE])
                ->enableTimer(useTimer: '1' === $data[static::FORM_FIELD_USE_TIMER])
                ->setPrecisionDue(precisionDue: $data[static::FORM_FIELD_PRECISION_DUE])
                ->setMarkdownTransformerActive(active: '1' === $data[static::FORM_FIELD_MARKDOWN_ENABLED])
                ->setPasswordChangeInterval(interval: $data[static::FORM_FIELD_PASSWORD_CHANGE_INTERVAL])
                ->setMailContentSecurityNote(active: '1' === $data[static::FORM_FIELD_CONTENT_SECURITY])
                ->setMailContentSteps(active: '1' === $data[static::FORM_FIELD_CONTENT_STEPS])
            ;
            \DoEveryApp\Util\DependencyContainer::getInstance()
                                                ->getEntityManager()
                                                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess(message: \DoEveryApp\Util\DependencyContainer::getInstance()
                                                                                                     ->getTranslator()
                                                                                                     ->settingsSaved());

            return $this->redirect(to: ShowSettingsAction::getRoute());
        } catch (\DoEveryApp\Exception\FormValidationFailed) {
        }

        return $this->render(script: 'action/cms/editSettings', data: ['data' => $data]);
    }

    protected function filterAndValidate(array &$data): array
    {
        $data[static::FORM_FIELD_KEEP_BACKUPS]             = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToInt())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_KEEP_BACKUPS))
        ;
        $data[static::FORM_FIELD_BACKUP_DELAY]             = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToInt())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_BACKUP_DELAY))
        ;
        $data[static::FORM_FIELD_FILL_TIME_LINE]           = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_FILL_TIME_LINE))
        ;
        $data[static::FORM_FIELD_USE_TIMER]                = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_USE_TIMER))
        ;
        $data[static::FORM_FIELD_PRECISION_DUE]            = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToInt())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_PRECISION_DUE))
        ;
        $data[static::FORM_FIELD_MARKDOWN_ENABLED]         = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_MARKDOWN_ENABLED))
        ;
        $data[static::FORM_FIELD_PASSWORD_CHANGE_INTERVAL] = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToInt())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_PASSWORD_CHANGE_INTERVAL))
        ;
        $data[static::FORM_FIELD_CONTENT_SECURITY]        = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_CONTENT_SECURITY))
        ;
        $data[static::FORM_FIELD_CONTENT_STEPS]        = new \Laminas\Filter\FilterChain()
            ->attach(callback: new \Laminas\Filter\StringTrim())
            ->attach(callback: new \Laminas\Filter\ToNull())
            ->filter(value: $this->getFromBody(key: static::FORM_FIELD_CONTENT_STEPS))
        ;

        $validators = new \Symfony\Component\Validator\Constraints\Collection(fields: [
                                                                                          static::FORM_FIELD_KEEP_BACKUPS             => [
                                                                                          ],
                                                                                          static::FORM_FIELD_BACKUP_DELAY             => [
                                                                                          ],
                                                                                          static::FORM_FIELD_FILL_TIME_LINE           => [
                                                                                          ],
                                                                                          static::FORM_FIELD_USE_TIMER                => [
                                                                                          ],
                                                                                          static::FORM_FIELD_PRECISION_DUE            => [
                                                                                          ],
                                                                                          static::FORM_FIELD_MARKDOWN_ENABLED         => [
                                                                                          ],
                                                                                          static::FORM_FIELD_PASSWORD_CHANGE_INTERVAL => [
                                                                                          ],
                                                                                          static::FORM_FIELD_CONTENT_SECURITY         => [
                                                                                          ],
                                                                                          static::FORM_FIELD_CONTENT_STEPS            => [
                                                                                          ],
                                                                                      ]);

        $this->validate(data: $data, validators: $validators);

        return $data;
    }
}
