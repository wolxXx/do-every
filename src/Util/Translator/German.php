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
        return 'fleißiges Bienchen';
    }


    public function workers(): string
    {
        return 'fleißige Bienchen';
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


    public function today(): string
    {
        return 'heute';
    }


    public function yesterday(): string
    {
        return 'gestern';
    }


    public function thisWeek(): string
    {
        return 'diese Woche';
    }


    public function lastWeek(): string
    {
        return 'letzte Woche';
    }


    public function thisMonth(): string
    {
        return 'dieser Monat';
    }


    public function lastMonth(): string
    {
        return 'letzter Monat';
    }


    public function thisYear(): string
    {
        return 'dieses Jahr';
    }


    public function lastYear(): string
    {
        return 'letztes Jahr';
    }


    public function byMonth(): string
    {
        return 'Nach Monaten';
    }


    public function byYear(): string
    {
        return 'Nach Jahren';
    }


    public function what(): string
    {
        return 'Was';
    }


    public function value(): string
    {
        return 'Wert';
    }


    public function editSettings(): string
    {
        return 'Einstellungen bearbeiten';
    }


    public function fillTimeLineQuestion(): string
    {
        return 'Zeitlinie auffüllen?';
    }


    public function yes(): string
    {
        return 'ja';
    }


    public function no(): string
    {
        return 'nein';
    }


    public function duePrecision(): string
    {
        return 'Fälligkeitspräzision';
    }


    public function keepBackupDays(): string
    {
        return 'Backups aufheben (Tage)';
    }


    public function save(): string
    {
        return 'speichern';
    }


    public function new(): string
    {
        return 'neu';
    }


    public function hasPasswordQuestion(): string
    {
        return 'hat Passwort?';
    }


    public function isAdminQuestion(): string
    {
        return 'ist Admin?';
    }


    public function doNotifyLoginsQuestion(): string
    {
        return 'Logins benachrichtigen?';
    }


    public function doNotifyDueTasksQuestion(): string
    {
        return 'Fälligkeiten benachrichtigen?';
    }


    public function lastLogin(): string
    {
        return 'letzter Login';
    }


    public function lastPasswordChange(): string
    {
        return 'letzte Passwortänderung';
    }


    public function dueIsNow(): string
    {
        return 'jetzt fällig';
    }


    public function dueIsInFuture(): string
    {
        return 'in';
    }


    public function dueIsInPast(): string
    {
        return 'seit';
    }


    public function minute(): string
    {
        return 'Minute';
    }


    public function minutes(): string
    {
        return 'Minuten';
    }


    public function hour(): string
    {
        return 'Stunde';
    }


    public function hours(): string
    {
        return 'Stunden';
    }


    public function day(): string
    {
        return 'Tag';
    }


    public function days(): string
    {
        return 'Tagen';
    }


    public function month(): string
    {
        return 'Monat';
    }


    public function months(): string
    {
        return 'Monaten';
    }


    public function year(): string
    {
        return 'Jahr';
    }


    public function years(): string
    {
        return 'Jahren';
    }


    public function dueAdverb(): string
    {
        return 'fällig';
    }


    public function noValue(): string
    {
        return '-';
    }


    public function oneMinute(): string
    {
        return 'eine Minute';
    }


    public function twoMinutes(): string
    {
        return 'zwei Minuten';
    }


    public function threeMinutes(): string
    {
        return 'drei Minuten';
    }


    public function fourMinutes(): string
    {
        return 'vier Minuten';
    }


    public function fiveMinutes(): string
    {
        return 'fünf Minuten';
    }


    public function intervalTypeRelative(): string
    {
        return 'relativ';
    }


    public function intervalTypeCyclic(): string
    {
        return 'hart zyklisch';
    }


    public function dueIsEvery(): string
    {
        return 'alle';
    }


    public function dueIsEveryMinute(): string
    {
        return 'jede Minute';
    }


    public function dueIsEveryHour(): string
    {
        return 'jede Stunde';
    }


    public function dueIsEveryDay(): string
    {
        return 'jeden Tag';
    }


    public function dueIsEveryMonth(): string
    {
        return 'jeden Monat';
    }


    public function dueIsEveryYear(): string
    {
        return 'jedes Jahr';
    }


    public function priorityLow(): string
    {
        return 'gering';
    }


    public function priorityNormal(): string
    {
        return 'normal';
    }


    public function priorityHigh(): string
    {
        return 'hoch';
    }


    public function priorityUrgent(): string
    {
        return 'dringend';
    }

    public function codeNotValid(): string
    {
        return 'Code ungültig.';
    }

    public function defaultErrorMessage(): string
    {
        return 'Das hat nicht geklappt.';
    }

    public function userNotFound(): string
    {
        return 'Nutzer nicht gefunden';
    }

    public function codeSent(): string
    {
        return 'Code verschickt.';
    }

    public function passwordConfirmFailed(): string
    {
        return 'Passwortkontrolle fehlgeschlagen';
    }

    public function passwordChanged(): string
    {
        return 'Passwort geändert.';
    }

    public function settingsSaved(): string
    {
        return 'Einstellungen gespeichert.';
    }

    public function workerNotFound(): string
    {
        return 'Biene nicht gefunden';
    }

    public function taskNotFound(): string
    {
        return 'Aufgabe nicht gefunden';
    }

    public function executionAdded(): string
    {
        return 'Ausführung registriert.';
    }

    public function executionNotFound(): string
    {
        return 'Ausführung nicht gefunden.';
    }

    public function executionDeleted(): string
    {
        return 'Ausführung gelöscht.';
    }

    public function executionEdited(): string
    {
        return 'Ausführung bearbeitet.';
    }

    public function groupAdded(): string
    {
        return 'Gruppe erstellt.';
    }

    public function groupNotFound(): string
    {
        return 'Gruppe nicht gefunden.';
    }

    public function groupDeleted(): string
    {
        return 'Gruppe gelöscht.';
    }

    public function groupEdited(): string
    {
        return 'Gruppe bearbeitet.';
    }

    public function taskAdded(): string
    {
        return 'Aufgabe erstellt.';
    }

    public function taskDeleted(): string
    {
        return 'Aufgabe gelöscht.';
    }

    public function taskEdited(): string
    {
        return 'Aufgabe bearbeitet.';
    }

    public function statusSet(): string
    {
        return 'Status erfolgreich gesetzt';
    }

    public function workerAssigned(): string
    {
        return 'Markierung erfolgreich gesetzt';
    }

    public function assignmentRemoved(): string
    {
        return 'Markierung erfolgreich entfernt.';
    }

    public function taskReset(): string
    {
        return 'Aufgabe zurückgesetzt.';
    }

    public function workerAdded(): string
    {
        return 'Worker erstellt.';
    }
}