<?php

declare(strict_types=1);

namespace DoEveryApp\Util\Translator;

class German implements \DoEveryApp\Util\Translator
{

    public function translate($what, ...$args): string
    {
        switch ($what) {
            case 'This value should not be blank.': {
                return 'Es wird eine Eingabe benötigt.';
            }
        }
        \var_dump($what, ...$args);
        return $what;
    }


    public function dashboard(): string
    {
        return 'Dashboard';
    }


    public function attention(): string
    {
        return 'Achtung!';
    }


    public function go(): string
    {
        return 'los';
    }


    public function settings(): string
    {
        return 'Einstellungen';
    }


    public function logout(): string
    {
        return 'abmelden';
    }


    public function worker(): string
    {
        return 'Biene';
    }


    public function workers(): string
    {
        return 'Bienen';
    }


    public function login(): string
    {
        return 'anmelden';
    }


    public function eMail(): string
    {
        return 'E-Mail';
    }


    public function password(): string
    {
        return 'Passwort';
    }


    public function tasks(): string
    {
        return 'Aufgaben';
    }


    public function pageTitleSetNewPassword(): string
    {
        return 'Neues Passwort setzen';
    }


    public function confirmPassword(): string
    {
        return 'Passwort bestätigen';
    }
}