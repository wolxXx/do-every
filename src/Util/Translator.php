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


    public function dashboardLastPasswordChange(): string;


    public function dashboardChangePassword(): string;


    public function dashboardAddTwoFactor(): string;


    public function currentWorks(): string;


    public function task(): string;


    public function currentlyWorkingOn(): string;


    public function assignedTo(): string;


    public function tasksWithDue():string;


    public function isCurrentlyWorkingOn():string;


    public function group():string;


    public function name():string;


    public function lastExecution():string;


    public function due():string;


    public function interval():string;


    public function actions():string;


    public function show():string;


    public function addExecution():string;


    public function edit():string;


    public function delete():string;


    public function executions():string;


    public function date():string;


    public function effort():string;


    public function note():string;


    public function statistics():string;


    public function averageEffort():string;


    public function totalEffort(): string;
}
