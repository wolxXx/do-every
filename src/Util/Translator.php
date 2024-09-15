<?php


declare(strict_types=1);

namespace DoEveryApp\Util;

interface Translator
{
    public const string LANGUAGE_ENGLISH = 'en';

    public const string LANGUAGE_GERMAN  = 'de';

    public const string LANGUAGE_POLISH  = 'pl';

    public const string LANGUAGE_FRENCH  = 'fr';

    public const string LANGUAGE_MAORI   = 'nz';


    public function translate($what, ...$args): string;


    public function dashboard(): string;


    public function attention(): string;


    public function go(): string;


    public function settings(): string;


    public function logout(): string;


    public function worker(): string;


    public function workers(): string;


    public function login(): string;


    public function eMail(): string;


    public function password(): string;


    public function tasks(): string;


    public function pageTitleSetNewPassword(): string;


    public function confirmPassword(): string;
}
