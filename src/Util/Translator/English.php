<?php

declare(strict_types=1);

namespace DoEveryApp\Util\Translator;

class English implements \DoEveryApp\Util\Translator
{

    public function translate($what, ...$args): string
    {
        switch ($what) {
            case 'This value should not be blank.': {
                return 'This value should not be blank.';
            }
        }
        \var_dump($what, ...$args);
        return $what;
    }


    public function dashboard(): string
    {
        return 'dashboard';
    }


    public function attention(): string
    {
        return 'Attention!';
    }


    public function go(): string
    {
        return 'go';
    }


    public function settings(): string
    {
        return 'settings';
    }


    public function logout(): string
    {
        return 'logout';
    }


    public function worker(): string
    {
        return 'bee';
    }


    public function workers(): string
    {
        return 'bees';
    }


    public function login(): string
    {
        return 'login';
    }


    public function eMail(): string
    {
        return 'e-mail';
    }


    public function password(): string
    {
        return 'password';
    }


    public function tasks(): string
    {
        return 'tasks';
    }


    public function pageTitleSetNewPassword(): string
    {
        return 'set new password';
    }


    public function confirmPassword(): string
    {
        // TODO: Implement confirmPassword() method.
    }
}