<?php

declare(strict_types=1);

namespace DoEveryApp\Util\Translator;

class German implements \DoEveryApp\Util\Translator
{

    public function translate($what, ...$args): string
    {
        switch ($what) {
            case 'This value should not be blank.':
            {
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


    public function task(): string
    {
        return 'Aufgabe';
    }


    public function pageTitleSetNewPassword(): string
    {
        return 'Neues Passwort setzen';
    }


    public function confirmPassword(): string
    {
        return 'Passwort bestätigen';
    }


    public function dashboardLastPasswordChange(): string
    {
        return 'Du hast dein Passwort lange nicht geändert. Das letzte mal %s.';
    }


    public function dashboardChangePassword(): string
    {
        return 'Du solltest dein Passwort ändern.';
    }


    public function dashboardAddTwoFactor(): string
    {
        return 'Du solltest einen zweiten Faktor für den Login einrichten.';
    }


    public function currentWorks(): string
    {
        return 'Aktuelle Arbeiten';
    }


    public function currentlyWorkingOn(): string
    {
        return 'arbeitet daran';
    }


    public function assignedTo(): string
    {
        return 'zugewiesen an';
    }


    public function tasksWithDue(): string
    {
        return 'Fällige Aufgaben';
    }


    public function isCurrentlyWorkingOn(): string
    {
        return '%s arbeitet daran';
    }


    public function group(): string
    {
        return 'Gruppe';
    }


    public function name(): string
    {
        return 'Name';
    }


    public function lastExecution(): string
    {
        return 'letzte Ausführung';
    }


    public function due(): string
    {
        return 'Fälligkeit';
    }


    public function interval(): string
    {
        return 'Intervall';
    }


    public function actions(): string
    {
        return 'Aktionen';
    }


    public function show(): string
    {
        return 'anzeigen';
    }


    public function addExecution(): string
    {
        return 'Ausführung eintragen';
    }


    public function edit(): string
    {
        return 'bearbeiten';
    }


    public function delete(): string
    {
        return 'löschen';
    }


    public function executions(): string
    {
        return 'Ausführungen';
    }


    public function date(): string
    {
        return 'Datum';
    }


    public function effort(): string
    {
        return 'Aufwand';
    }


    public function note(): string
    {
        return 'Notiz';
    }


    public function statistics(): string
    {
        return 'Statistik';
    }


    public function averageEffort(): string
    {
        return 'Aufwand durchschnittlich';
    }


    public function totalEffort(): string
    {
        return 'insgesamt';
    }
}