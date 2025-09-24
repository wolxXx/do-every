<?php

declare(strict_types = 1);

namespace DoEveryApp\Util\Translator;

class German implements \DoEveryApp\Util\Translator
{
    #[\Override]
    public function translate($what, ...$args): string
    {
        switch ($what) {
            case 'test':
            {
                return 'Test!';
            }
            case 'This value should not be blank.':
            {
                return 'Es wird eine Eingabe benötigt.';
            }
            case 'This value is too long. It should have {{ limit }} character or less.|This value is too long. It should have {{ limit }} characters or less.':
            {
                return str_replace(search: '{{ limit }}', replace: $args[0]['{{ limit }}'], subject: 'Der Wert ist zu lang. Er sollte {{ limit }} Zeichen oder weniger haben.');
            }
        }
        throw new \InvalidArgumentException(message: 'Unknown translation: ' . $what);
    }

    #[\Override]
    public function dashboard(): string
    {
        return 'Dashboard';
    }

    #[\Override]
    public function attention(): string
    {
        return 'Achtung!';
    }

    #[\Override]
    public function go(): string
    {
        return 'los';
    }

    #[\Override]
    public function settings(): string
    {
        return 'Einstellungen';
    }

    #[\Override]
    public function logout(): string
    {
        return 'abmelden';
    }

    #[\Override]
    public function worker(): string
    {
        return 'fleißiges Bienchen';
    }

    #[\Override]
    public function workers(): string
    {
        return 'fleißige Bienchen';
    }

    #[\Override]
    public function login(): string
    {
        return 'anmelden';
    }

    #[\Override]
    public function eMail(): string
    {
        return 'E-Mail';
    }

    #[\Override]
    public function password(): string
    {
        return 'Passwort';
    }

    #[\Override]
    public function tasks(): string
    {
        return 'Aufgaben';
    }

    #[\Override]
    public function task(): string
    {
        return 'Aufgabe';
    }

    #[\Override]
    public function pageTitleSetNewPassword(): string
    {
        return 'Neues Passwort setzen';
    }

    #[\Override]
    public function confirmPassword(): string
    {
        return 'Passwort bestätigen';
    }

    #[\Override]
    public function dashboardLastPasswordChange(\DateTime $dateTime): string
    {
        return 'Du hast dein Passwort lange nicht geändert. Das letzte mal ' . \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateShortTime(dateTime: $dateTime) . '.';
    }

    #[\Override]
    public function dashboardChangePassword(): string
    {
        return 'Du solltest dein Passwort ändern.';
    }

    #[\Override]
    public function dashboardAddTwoFactor(): string
    {
        return 'Du solltest einen zweiten Faktor für den Login einrichten.';
    }

    #[\Override]
    public function currentWorks(): string
    {
        return 'Aktuelle Arbeiten';
    }

    #[\Override]
    public function currentlyWorkingOn(): string
    {
        return 'arbeitet daran';
    }

    #[\Override]
    public function assignedTo(): string
    {
        return 'zugewiesen an';
    }

    #[\Override]
    public function tasksWithDue(): string
    {
        return 'Fällige Aufgaben';
    }

    #[\Override]
    public function isCurrentlyWorkingOn(string $who): string
    {
        return \DoEveryApp\Util\View\Escaper::escape(value: $who) . ' arbeitet daran';
    }

    #[\Override]
    public function group(): string
    {
        return 'Gruppe';
    }

    #[\Override]
    public function name(): string
    {
        return 'Name';
    }

    #[\Override]
    public function lastExecution(): string
    {
        return 'letzte Ausführung';
    }

    #[\Override]
    public function due(): string
    {
        return 'Fälligkeit';
    }

    #[\Override]
    public function interval(): string
    {
        return 'Intervall';
    }

    #[\Override]
    public function actions(): string
    {
        return 'Aktionen';
    }

    #[\Override]
    public function show(): string
    {
        return 'anzeigen';
    }

    #[\Override]
    public function addExecution(): string
    {
        return 'Ausführung eintragen';
    }

    #[\Override]
    public function editExecution(): string
    {
        return 'Ausführung bearbeiten';
    }

    #[\Override]
    public function edit(): string
    {
        return 'bearbeiten';
    }

    #[\Override]
    public function delete(): string
    {
        return 'löschen';
    }

    #[\Override]
    public function executions(): string
    {
        return 'Ausführungen';
    }

    #[\Override]
    public function date(): string
    {
        return 'Datum';
    }

    #[\Override]
    public function effort(): string
    {
        return 'Aufwand';
    }

    #[\Override]
    public function note(): string
    {
        return 'Notiz';
    }

    #[\Override]
    public function statistics(): string
    {
        return 'Statistik';
    }

    #[\Override]
    public function averageEffort(): string
    {
        return 'Aufwand durchschnittlich';
    }

    #[\Override]
    public function totalEffort(): string
    {
        return 'insgesamt';
    }

    #[\Override]
    public function today(): string
    {
        return 'heute';
    }

    #[\Override]
    public function yesterday(): string
    {
        return 'gestern';
    }

    #[\Override]
    public function thisWeek(): string
    {
        return 'diese Woche';
    }

    #[\Override]
    public function lastWeek(): string
    {
        return 'letzte Woche';
    }

    #[\Override]
    public function thisMonth(): string
    {
        return 'dieser Monat';
    }

    #[\Override]
    public function lastMonth(): string
    {
        return 'letzter Monat';
    }

    #[\Override]
    public function thisYear(): string
    {
        return 'dieses Jahr';
    }

    #[\Override]
    public function lastYear(): string
    {
        return 'letztes Jahr';
    }

    #[\Override]
    public function byMonth(): string
    {
        return 'Nach Monaten';
    }

    #[\Override]
    public function byYear(): string
    {
        return 'Nach Jahren';
    }

    #[\Override]
    public function what(): string
    {
        return 'Was';
    }

    #[\Override]
    public function value(): string
    {
        return 'Wert';
    }

    #[\Override]
    public function editSettings(): string
    {
        return 'Einstellungen bearbeiten';
    }

    #[\Override]
    public function fillTimeLineQuestion(): string
    {
        return 'Zeitlinie auffüllen?';
    }

    #[\Override]
    public function yes(): string
    {
        return 'ja';
    }

    #[\Override]
    public function no(): string
    {
        return 'nein';
    }

    #[\Override]
    public function duePrecision(): string
    {
        return 'Fälligkeitspräzision';
    }

    #[\Override]
    public function keepBackupDays(): string
    {
        return 'Backups aufheben (Tage)';
    }

    #[\Override]
    public function save(): string
    {
        return 'speichern';
    }

    #[\Override]
    public function new(): string
    {
        return 'neu';
    }

    #[\Override]
    public function hasPasswordQuestion(): string
    {
        return 'hat Passwort?';
    }

    #[\Override]
    public function isAdminQuestion(): string
    {
        return 'ist Admin?';
    }

    #[\Override]
    public function doNotifyLoginsQuestion(): string
    {
        return 'Logins benachrichtigen?';
    }

    #[\Override]
    public function doNotifyDueTasksQuestion(): string
    {
        return 'Fälligkeiten benachrichtigen?';
    }

    #[\Override]
    public function lastLogin(): string
    {
        return 'letzter Login';
    }

    #[\Override]
    public function lastPasswordChange(): string
    {
        return 'letzte Passwortänderung';
    }

    #[\Override]
    public function dueIsNow(): string
    {
        return 'jetzt fällig';
    }

    #[\Override]
    public function dueIsInFuture(): string
    {
        return 'in';
    }

    #[\Override]
    public function dueIsInPast(): string
    {
        return 'seit';
    }

    #[\Override]
    public function minute(): string
    {
        return 'Minute';
    }

    #[\Override]
    public function minutes(): string
    {
        return 'Minuten';
    }

    #[\Override]
    public function hour(): string
    {
        return 'Stunde';
    }

    #[\Override]
    public function hours(): string
    {
        return 'Stunden';
    }

    #[\Override]
    public function day(): string
    {
        return 'Tag';
    }

    #[\Override]
    public function days(): string
    {
        return 'Tagen';
    }


    #[\Override]
    public function daysPluralized(null|int|float $dayAmount = 0): string
    {
        if (null === $dayAmount) {
            return '-';
        }
        if (1 === $dayAmount || 1.0 === $dayAmount) {
            return 'Tag';
        }

        return 'Tage';
    }

    #[\Override]
    public function month(): string
    {
        return 'Monat';
    }

    #[\Override]
    public function months(): string
    {
        return 'Monaten';
    }

    #[\Override]
    public function year(): string
    {
        return 'Jahr';
    }

    #[\Override]
    public function years(): string
    {
        return 'Jahren';
    }

    #[\Override]
    public function dueAdverb(): string
    {
        return 'fällig';
    }

    #[\Override]
    public function noValue(): string
    {
        return '-';
    }

    #[\Override]
    public function oneMinute(): string
    {
        return 'eine Minute';
    }

    #[\Override]
    public function twoMinutes(): string
    {
        return 'zwei Minuten';
    }

    #[\Override]
    public function threeMinutes(): string
    {
        return 'drei Minuten';
    }

    #[\Override]
    public function fourMinutes(): string
    {
        return 'vier Minuten';
    }

    #[\Override]
    public function fiveMinutes(): string
    {
        return 'fünf Minuten';
    }

    #[\Override]
    public function intervalTypeRelative(): string
    {
        return 'relativ';
    }

    #[\Override]
    public function intervalTypeCyclic(): string
    {
        return 'hart zyklisch';
    }

    #[\Override]
    public function dueIsEvery(): string
    {
        return 'alle';
    }

    #[\Override]
    public function dueIsEveryMinute(): string
    {
        return 'jede Minute';
    }

    #[\Override]
    public function dueIsEveryHour(): string
    {
        return 'jede Stunde';
    }

    #[\Override]
    public function dueIsEveryDay(): string
    {
        return 'jeden Tag';
    }

    #[\Override]
    public function dueIsEveryMonth(): string
    {
        return 'jeden Monat';
    }

    #[\Override]
    public function dueIsEveryYear(): string
    {
        return 'jedes Jahr';
    }

    #[\Override]
    public function priorityLow(): string
    {
        return 'gering';
    }

    #[\Override]
    public function priorityNormal(): string
    {
        return 'normal';
    }

    #[\Override]
    public function priorityHigh(): string
    {
        return 'hoch';
    }

    #[\Override]
    public function priorityUrgent(): string
    {
        return 'dringend';
    }

    #[\Override]
    public function codeNotValid(): string
    {
        return 'Code ungültig.';
    }

    #[\Override]
    public function defaultErrorMessage(): string
    {
        return 'Das hat nicht geklappt.';
    }

    #[\Override]
    public function userNotFound(): string
    {
        return 'Nutzer nicht gefunden';
    }

    #[\Override]
    public function codeSent(): string
    {
        return 'Code verschickt.';
    }

    #[\Override]
    public function passwordConfirmFailed(): string
    {
        return 'Passwortkontrolle fehlgeschlagen';
    }

    #[\Override]
    public function passwordChanged(): string
    {
        return 'Passwort geändert.';
    }

    #[\Override]
    public function settingsSaved(): string
    {
        return 'Einstellungen gespeichert.';
    }

    #[\Override]
    public function workerNotFound(): string
    {
        return 'Biene nicht gefunden';
    }

    #[\Override]
    public function taskNotFound(): string
    {
        return 'Aufgabe nicht gefunden';
    }

    #[\Override]
    public function executionAdded(): string
    {
        return 'Ausführung registriert.';
    }

    #[\Override]
    public function executionNotFound(): string
    {
        return 'Ausführung nicht gefunden.';
    }

    #[\Override]
    public function executionDeleted(): string
    {
        return 'Ausführung gelöscht.';
    }

    #[\Override]
    public function executionEdited(): string
    {
        return 'Ausführung bearbeitet.';
    }

    #[\Override]
    public function groupAdded(): string
    {
        return 'Gruppe erstellt.';
    }

    #[\Override]
    public function groupNotFound(): string
    {
        return 'Gruppe nicht gefunden.';
    }

    #[\Override]
    public function groupDeleted(): string
    {
        return 'Gruppe gelöscht.';
    }

    #[\Override]
    public function groupEdited(): string
    {
        return 'Gruppe bearbeitet.';
    }

    #[\Override]
    public function taskAdded(): string
    {
        return 'Aufgabe erstellt.';
    }

    #[\Override]
    public function taskDeleted(): string
    {
        return 'Aufgabe gelöscht.';
    }

    #[\Override]
    public function taskEdited(): string
    {
        return 'Aufgabe bearbeitet.';
    }

    #[\Override]
    public function statusSet(): string
    {
        return 'Status erfolgreich gesetzt';
    }

    #[\Override]
    public function workerAssigned(): string
    {
        return 'Markierung erfolgreich gesetzt';
    }

    #[\Override]
    public function assignmentRemoved(): string
    {
        return 'Markierung erfolgreich entfernt.';
    }

    #[\Override]
    public function taskReset(): string
    {
        return 'Aufgabe zurückgesetzt.';
    }

    #[\Override]
    public function workerAdded(): string
    {
        return 'Biene erstellt.';
    }

    #[\Override]
    public function itIsYou(): string
    {
        return 'Das bist du!';
    }

    #[\Override]
    public function workerDeleted(): string
    {
        return 'Biene gelöscht.';
    }

    #[\Override]
    public function twoFactorDisabled(): string
    {
        return 'Zwei-Faktor-Authentifizierung erfolgreich entfernt.';
    }

    #[\Override]
    public function workerEdited(): string
    {
        return 'Biene bearbeitet.';
    }

    #[\Override]
    public function twoFactorEnabled(): string
    {
        return 'Zwei-Faktor-Authentifizierung erfolgreich eingerichtet.';
    }

    #[\Override]
    public function setAdminFlag(): string
    {
        return 'Admin-Flag erfolgreich gesetzt.';
    }

    #[\Override]
    public function passwordDeleted(): string
    {
        return 'Passwort gelöscht.';
    }

    #[\Override]
    public function iAmWorkingOn(): string
    {
        return 'ich arbeite daran';
    }

    #[\Override]
    public function nobodyIsWorkingOn(): string
    {
        return 'niemand arbeitet daran';
    }

    #[\Override]
    public function reset(): string
    {
        return 'reset';
    }

    #[\Override]
    public function deactivate(): string
    {
        return 'deaktivieren';
    }

    #[\Override]
    public function activate(): string
    {
        return 'aktivieren';
    }

    #[\Override]
    public function info(): string
    {
        return 'Info';
    }

    #[\Override]
    public function status(): string
    {
        return 'Status';
    }

    #[\Override]
    public function active(): string
    {
        return 'aktiv';
    }

    #[\Override]
    public function paused(): string
    {
        return 'pausiert';
    }

    #[\Override]
    public function willBeNotified(): string
    {
        return 'wird benachrichtigt';
    }

    #[\Override]
    public function willNotBeNotified(): string
    {
        return 'wird nicht benachrichtigt';
    }

    #[\Override]
    public function priority(): string
    {
        return 'Priorität';
    }

    #[\Override]
    public function nobody(): string
    {
        return 'niemand';
    }

    #[\Override]
    public function by(): string
    {
        return 'von';
    }

    #[\Override]
    public function taskList(): string
    {
        return 'Aufgabenliste';
    }

    #[\Override]
    public function step(): string
    {
        return 'Schritt';
    }

    #[\Override]
    public function notice(): string
    {
        return 'Hinweis';
    }

    #[\Override]
    public function steps(): string
    {
        return 'Schritte';
    }

    #[\Override]
    public function without(): string
    {
        return 'ohne';
    }

    #[\Override]
    public function intervalType(): string
    {
        return 'Interval-Typ';
    }

    #[\Override]
    public function intervalValue(): string
    {
        return 'Interval-Wert';
    }

    #[\Override]
    public function intervalMode(): string
    {
        return 'Intervall-Modus';
    }

    #[\Override]
    public function stepsQuestion(): string
    {
        return 'Welche Schritte sollen ausgeführt werden?';
    }

    #[\Override]
    public function add(): string
    {
        return 'hinzufügen';
    }

    #[\Override]
    public function addTask(): string
    {
        return 'neue Aufgabe erstellen';
    }

    #[\Override]
    public function editTask(string $task): string
    {
        return 'Aufgabe ' . $task . ' bearbeiten';
    }

    #[\Override]
    public function groups(): string
    {
        return 'Gruppen';
    }

    #[\Override]
    public function addGroup(): string
    {
        return 'neue Gruppe';
    }

    #[\Override]
    public function addWorker(): string
    {
        return 'neue Biene erstellen';
    }

    #[\Override]
    public function editWorker(string $who): string
    {
        return 'Biene ' . \DoEveryApp\Util\View\Escaper::escape(value: $who) . ' bearbeiten';
    }

    #[\Override]
    public function enableTwoFactorForWorker(string $who): string
    {
        return '2FA für Biene ' . \DoEveryApp\Util\View\Escaper::escape(value: $who) . ' einrichten';
    }

    #[\Override]
    public function twoFactorNotice(): string
    {
        return 'Scanne den QR-Code links mit deiner Authenticator-App (bspw. Google Authenticator). <br />
                Speichere dir an einem sicheren Ort die drei Codes, mit denen du ins System kommst,
                sollte deine Authenticator-App mal nicht zur Hand sein.<br /><br />
                Drücke im Anschluss den Speichern-Knopf, um den Vorgang abzuschließen und den Datensatz
                digital zu speichern.';
    }

    #[\Override]
    public function code(): string
    {
        return 'Code';
    }

    #[\Override]
    public function codes(): string
    {
        return 'Codes';
    }

    #[\Override]
    public function log(): string
    {
        return 'log';
    }

    #[\Override]
    public function addTwoFactor(): string
    {
        return '+2fa';
    }

    #[\Override]
    public function removeTwoFactor(): string
    {
        return '-2fa';
    }

    #[\Override]
    public function logFor(string $who): string
    {
        return 'Arbeitsnachweis für Biene "' . \DoEveryApp\Util\View\Escaper::escape(value: $who) . '"';
    }

    #[\Override]
    public function workerDidNothing(string $who): string
    {
        return '- ' . \DoEveryApp\Util\View\Escaper::escape(value: $who) . ' hat bisher kein Beitrag geleistet -';
    }

    #[\Override]
    public function needEmailForThisAction(): string
    {
        return 'dafür wird eine e-Mail-Adresse benötigt.';
    }

    #[\Override]
    public function loginRequired(): string
    {
        return 'Ein Login ist notwendig';
    }

    #[\Override]
    public function help(): string
    {
        return 'Hilfe';
    }

    #[\Override]
    public function areYouSure(): string
    {
        return 'Bist du sicher?';
    }

    #[\Override]
    public function reallyWantToDeleteTask(string $name): string
    {
        return 'Willst du wirklich die Aufgabe "' . $name . '" löschen?';
    }

    #[\Override]
    public function reallyWantToDeleteGroup(string $name): string
    {
        return 'Willst du wirklich die Gruppe "' . $name . '" löschen?';
    }

    #[\Override]
    public function reallyWantToResetTask(string $name): string
    {
        return 'Willst du wirklich die Aufgabe "' . $name . '" zurücksetzen?';
    }

    #[\Override]
    public function reallyWantToDeleteExecution(): string
    {
        return 'Willst du wirklich die Ausführung löschen?';
    }

    #[\Override]
    public function reallyWantToDeleteWorker(string $name): string
    {
        return 'Willst du wirklich die Biene "' . $name . '" löschen?';
    }

    #[\Override]
    public function reallyWantToResetTwoFactor(string $name): string
    {
        return 'Willst du wirklich die Zwei-Faktor-Authentifizierung von Biene "' . $name . '" zurücksetzen?';
    }


    #[\Override]
    public function noGroupsFound(): string
    {
        return 'keine Gruppen gefunden';
    }

    #[\Override]
    public function noTasksFound(): string
    {
        return 'keine Aufgaben gefunden';
    }

    #[\Override]
    public function welcomeUser(string $useName): string
    {
        return 'Willkommen,  ' . $useName . '!';
    }

    #[\Override]
    public function timerStart(): string
    {
        return 'Start';
    }

    #[\Override]
    public function timerPause(): string
    {
        return 'Pause';
    }

    #[\Override]
    public function timerStop(): string
    {
        return 'Stopp';
    }

    #[\Override]
    public function timerReset(): string
    {
        return 'Neu';
    }

    #[\Override]
    public function timerTakeTime(): string
    {
        return 'Übernehmen';
    }

    #[\Override]
    public function timer(): string
    {
        return 'Stoppuhr';
    }

    #[\Override]
    public function useTimer(): string
    {
        return 'Stoppuhr verwenden';
    }

    #[\Override]
    public function running(): string
    {
        return 'läuft';
    }

    #[\Override]
    public function sections(): string
    {
        return 'Abschnitte';
    }

    #[\Override]
    public function davEnabled(): string
    {
        return 'DAV-Support aktiviert';
    }

    #[\Override]
    public function enableDav(): string
    {
        return 'DAV-Support aktivieren';
    }

    #[\Override]
    public function davUser(): string
    {
        return 'DAV-Benutzer';
    }

    #[\Override]
    public function davPassword(): string
    {
        return 'DAV-Passwort';
    }

    #[\Override]
    public function davUrl(): string
    {
        return 'DAV-URL';
    }

    #[\Override]
    public function markdownTransformationEnabled(): string
    {
        return 'Markdown-Transformation aktiviert';
    }

    #[\Override]
    public function reallyWantToDeleteTimer(): string
    {
        return 'Willst du wirklich den Timer löschen?';
    }

    #[\Override]
    public function timerDeleted(): string
    {
        return 'Timer gelöscht.';
    }

    #[\Override]
    public function disabledTasks(): string
    {
        return 'deaktivierte Aufgaben';
    }

    #[\Override]
    public function enabledTasks(): string
    {
        return 'aktivierte Aufgaben';
    }

    #[\Override]
    public function cloneTask(string $task): string
    {
        return 'Aufgabe ' . $task . ' duplizieren';
    }

    #[\Override]
    public function taskCloned(): string
    {
        return 'Aufgabe dupliziert.';
    }

    #[\Override]
    public function now(): string
    {
        return 'jetzt';
    }

    #[\Override]
    public function runningTimer(): string
    {
        return 'laufende Stoppuhr';
    }

    #[\Override]
    public function backupDelay(): string
    {
        return 'Backup-Interval (in Stunden)';
    }
}
