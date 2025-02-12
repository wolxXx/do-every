<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Worker\Share;

trait AddEdit
{
    public const string FORM_FIELD_NAME             = 'name';

    public const string FORM_FIELD_EMAIL            = 'email';

    public const string FORM_FIELD_PASSWORD         = 'password';

    public const string FORM_FIELD_IS_ADMIN         = 'is_admin';

    public const string FORM_FIELD_DO_NOTIFY        = 'do_notify';

    public const string FORM_FIELD_DO_NOTIFY_LOGINS = 'do_notify_logins';

    protected function filterAndValidate(array &$data): array
    {
        $data[static::FORM_FIELD_NAME]             = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_NAME))
        ;
        $data[static::FORM_FIELD_EMAIL]            = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_EMAIL))
        ;
        $data[static::FORM_FIELD_PASSWORD]         = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_PASSWORD))
        ;
        $data[static::FORM_FIELD_IS_ADMIN]         = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_IS_ADMIN))
        ;
        $data[static::FORM_FIELD_DO_NOTIFY]        = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_DO_NOTIFY))
        ;
        $data[static::FORM_FIELD_DO_NOTIFY_LOGINS] = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody(static::FORM_FIELD_DO_NOTIFY_LOGINS))
        ;

        $validators = new \Symfony\Component\Validator\Constraints\Collection([
                                                                                  static::FORM_FIELD_EMAIL            => [
                                                                                  ],
                                                                                  static::FORM_FIELD_IS_ADMIN         => [
                                                                                  ],
                                                                                  static::FORM_FIELD_DO_NOTIFY        => [
                                                                                  ],
                                                                                  static::FORM_FIELD_DO_NOTIFY_LOGINS => [
                                                                                  ],
                                                                                  static::FORM_FIELD_PASSWORD         => [
                                                                                  ],
                                                                                  static::FORM_FIELD_NAME             => [
                                                                                      new \Symfony\Component\Validator\Constraints\NotBlank(),
                                                                                  ],
                                                                              ]);

        $this->validate($data, $validators);

        return $data;
    }
}
