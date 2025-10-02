<?php

declare(strict_types = 1);

namespace DoEveryApp\Util\Translator;

class English implements \DoEveryApp\Util\Translator
{
    #[\Override]
    public function translate($what, ...$args): string
    {
        switch ($what) {
            case 'test':
            {
                return 'test!';
            }
            case 'This value should not be blank.':
            {
                return 'This value should not be blank.';
            }
            case 'This value is too long. It should have {{ limit }} character or less.|This value is too long. It should have {{ limit }} characters or less.':
            {
                return 'This value is too long. It should have {{ limit }} character or less.|This value is too long. It should have {{ limit }} characters or less.';
            }
        }
        throw new \InvalidArgumentException(message: 'Unknown translation: ' . $what);
    }

    #[\Override]
    public function dashboard(): string
    {
        return 'dashboard';
    }

    #[\Override]
    public function attention(): string
    {
        return 'Attention!';
    }

    #[\Override]
    public function go(): string
    {
        return 'go';
    }

    #[\Override]
    public function settings(): string
    {
        return 'settings';
    }

    #[\Override]
    public function logout(): string
    {
        return 'logout';
    }

    #[\Override]
    public function worker(): string
    {
        return 'bee';
    }

    #[\Override]
    public function workers(): string
    {
        return 'bees';
    }

    #[\Override]
    public function login(): string
    {
        return 'login';
    }

    #[\Override]
    public function eMail(): string
    {
        return 'e-mail';
    }

    #[\Override]
    public function password(): string
    {
        return 'password';
    }

    #[\Override]
    public function tasks(): string
    {
        return 'tasks';
    }

    #[\Override]
    public function pageTitleSetNewPassword(): string
    {
        return 'set new password';
    }

    #[\Override]
    public function confirmPassword(): string
    {
        return 'confirm password';
    }

    #[\Override]
    public function dashboardLastPasswordChange(\DateTime $dateTime): string
    {
        return 'You haven\'t changed your password for a long time. The last time was ' . \DoEveryApp\Util\View\DateTime::getDateTimeMediumDateShortTime(dateTime: $dateTime) . '.';
    }

    #[\Override]
    public function dashboardChangePassword(): string
    {
        return 'change password';
    }

    #[\Override]
    public function dashboardAddTwoFactor(): string
    {
        return 'You should enable the two factor authentication.';
    }

    #[\Override]
    public function currentWorks(): string
    {
        return 'current works';
    }

    #[\Override]
    public function task(): string
    {
        return 'task';
    }

    #[\Override]
    public function currentlyWorkingOn(): string
    {
        return 'currently working on';
    }

    #[\Override]
    public function assignedTo(): string
    {
        return 'assigned to';
    }

    #[\Override]
    public function tasksWithDue(): string
    {
        return 'tasks';
    }

    #[\Override]
    public function isCurrentlyWorkingOn(string $who): string
    {
        return \DoEveryApp\Util\View\Escaper::escape(value: $who) . ' is working on';
    }

    #[\Override]
    public function group(): string
    {
        return 'group';
    }

    #[\Override]
    public function name(): string
    {
        return 'name';
    }

    #[\Override]
    public function lastExecution(): string
    {
        return 'last execution';
    }

    #[\Override]
    public function due(): string
    {
        return 'due';
    }

    #[\Override]
    public function interval(): string
    {
        return 'interval';
    }

    #[\Override]
    public function actions(): string
    {
        return 'actions';
    }

    #[\Override]
    public function show(): string
    {
        return 'show';
    }

    #[\Override]
    public function addExecution(): string
    {
        return 'add execution';
    }

    #[\Override]
    public function editExecution(): string
    {
        return 'edit execution';
    }

    #[\Override]
    public function edit(): string
    {
        return 'edit';
    }

    #[\Override]
    public function delete(): string
    {
        return 'delete';
    }

    #[\Override]
    public function executions(): string
    {
        return 'executions';
    }

    #[\Override]
    public function date(): string
    {
        return 'date';
    }

    #[\Override]
    public function effort(): string
    {
        return 'effort';
    }

    #[\Override]
    public function note(): string
    {
        return 'note';
    }

    #[\Override]
    public function statistics(): string
    {
        return 'statistics';
    }

    #[\Override]
    public function averageEffort(): string
    {
        return 'average';
    }

    #[\Override]
    public function totalEffort(): string
    {
        return 'total';
    }

    #[\Override]
    public function today(): string
    {
        return 'today';
    }

    #[\Override]
    public function yesterday(): string
    {
        return 'yesterday';
    }

    #[\Override]
    public function thisWeek(): string
    {
        return 'this week';
    }

    #[\Override]
    public function lastWeek(): string
    {
        return 'last week';
    }

    #[\Override]
    public function thisMonth(): string
    {
        return 'this month';
    }

    #[\Override]
    public function lastMonth(): string
    {
        return 'last month';
    }

    #[\Override]
    public function thisYear(): string
    {
        return 'this year';
    }

    #[\Override]
    public function lastYear(): string
    {
        return 'last year';
    }

    #[\Override]
    public function byMonth(): string
    {
        return 'by month';
    }

    #[\Override]
    public function byYear(): string
    {
        return 'by year';
    }

    #[\Override]
    public function what(): string
    {
        return 'what';
    }

    #[\Override]
    public function value(): string
    {
        return 'value';
    }

    #[\Override]
    public function editSettings(): string
    {
        return 'edit settings';
    }

    #[\Override]
    public function fillTimeLineQuestion(): string
    {
        return 'do fill time line?';
    }

    #[\Override]
    public function yes(): string
    {
        return 'yes';
    }

    #[\Override]
    public function no(): string
    {
        return 'no';
    }

    #[\Override]
    public function duePrecision(): string
    {
        return 'due precision';
    }

    #[\Override]
    public function keepBackupDays(): string
    {
        return 'keep backups (days)';
    }

    #[\Override]
    public function save(): string
    {
        return 'save';
    }

    #[\Override]
    public function new(): string
    {
        return 'new';
    }

    #[\Override]
    public function hasPasswordQuestion(): string
    {
        return 'has password?';
    }

    #[\Override]
    public function isAdminQuestion(): string
    {
        return 'is admin?';
    }

    #[\Override]
    public function doNotifyLoginsQuestion(): string
    {
        return 'do notify logins?';
    }

    #[\Override]
    public function doNotifyDueTasksQuestion(): string
    {
        return 'do notify due tasks?';
    }

    #[\Override]
    public function lastLogin(): string
    {
        return 'last login';
    }

    #[\Override]
    public function lastPasswordChange(): string
    {
        return 'last password change';
    }

    #[\Override]
    public function dueIsNow(): string
    {
        return 'is now due';
    }

    #[\Override]
    public function dueIsInFuture(): string
    {
        return 'in';
    }

    #[\Override]
    public function dueIsInPast(): string
    {
        return 'since';
    }

    #[\Override]
    public function minute(): string
    {
        return 'minute';
    }

    #[\Override]
    public function minutes(): string
    {
        return 'minutes';
    }

    #[\Override]
    public function hour(): string
    {
        return 'hour';
    }

    #[\Override]
    public function hours(): string
    {
        return 'hours';
    }

    #[\Override]
    public function day(): string
    {
        return 'day';
    }

    #[\Override]
    public function days(): string
    {
        return 'days';
    }

    #[\Override]
    public function daysPluralized(null|int|float $dayAmount = 0): string
    {
        if (null === $dayAmount) {
            return '-';
        }
        if (1 === $dayAmount || 1.0 === $dayAmount) {
            return 'day';
        }

        return 'days';
    }


    #[\Override]
    public function month(): string
    {
        return 'month';
    }

    #[\Override]
    public function months(): string
    {
        return 'months';
    }

    #[\Override]
    public function year(): string
    {
        return 'year';
    }

    #[\Override]
    public function years(): string
    {
        return 'years';
    }

    #[\Override]
    public function dueAdverb(): string
    {
        return 'due';
    }

    #[\Override]
    public function noValue(): string
    {
        return '-';
    }

    #[\Override]
    public function oneMinute(): string
    {
        return '1 minute';
    }

    #[\Override]
    public function twoMinutes(): string
    {
        return '2 minutes';
    }

    #[\Override]
    public function threeMinutes(): string
    {
        return '3 minutes';
    }

    #[\Override]
    public function fourMinutes(): string
    {
        return '4 minutes';
    }

    #[\Override]
    public function fiveMinutes(): string
    {
        return '5 minutes';
    }

    #[\Override]
    public function intervalTypeRelative(): string
    {
        return 'relative';
    }

    #[\Override]
    public function intervalTypeCyclic(): string
    {
        return 'cyclic';
    }

    #[\Override]
    public function dueIsEvery(): string
    {
        return 'every';
    }

    #[\Override]
    public function dueIsEveryMinute(): string
    {
        return 'every minute';
    }

    #[\Override]
    public function dueIsEveryHour(): string
    {
        return 'every hour';
    }

    #[\Override]
    public function dueIsEveryDay(): string
    {
        return 'every day';
    }

    #[\Override]
    public function dueIsEveryMonth(): string
    {
        return 'every month';
    }

    #[\Override]
    public function dueIsEveryYear(): string
    {
        return 'every year';
    }

    #[\Override]
    public function priorityLow(): string
    {
        return 'low';
    }

    #[\Override]
    public function priorityNormal(): string
    {
        return 'normal';
    }

    #[\Override]
    public function priorityHigh(): string
    {
        return 'high';
    }

    #[\Override]
    public function priorityUrgent(): string
    {
        return 'urgent';
    }

    #[\Override]
    public function codeNotValid(): string
    {
        return 'code not valid';
    }

    #[\Override]
    public function defaultErrorMessage(): string
    {
        return 'an error occurred';
    }

    #[\Override]
    public function userNotFound(): string
    {
        return 'user not found';
    }

    #[\Override]
    public function codeSent(): string
    {
        return 'code sent';
    }

    #[\Override]
    public function passwordConfirmFailed(): string
    {
        return 'password confirm failed';
    }

    #[\Override]
    public function passwordChanged(): string
    {
        return 'password changed';
    }

    #[\Override]
    public function settingsSaved(): string
    {
        return 'settings saved';
    }

    #[\Override]
    public function workerNotFound(): string
    {
        return 'worker not found';
    }

    #[\Override]
    public function taskNotFound(): string
    {
        return 'task not found';
    }

    #[\Override]
    public function executionAdded(): string
    {
        return 'execution added';
    }

    #[\Override]
    public function executionNotFound(): string
    {
        return 'execution not found';
    }

    #[\Override]
    public function executionDeleted(): string
    {
        return 'execution deleted';
    }

    #[\Override]
    public function executionEdited(): string
    {
        return 'execution edited';
    }

    #[\Override]
    public function groupAdded(): string
    {
        return 'group added';
    }

    #[\Override]
    public function groupNotFound(): string
    {
        return 'group not found';
    }

    #[\Override]
    public function groupDeleted(): string
    {
        return 'group deleted';
    }

    #[\Override]
    public function groupEdited(): string
    {
        return 'group edited';
    }

    #[\Override]
    public function taskAdded(): string
    {
        return 'task added';
    }

    #[\Override]
    public function taskDeleted(): string
    {
        return 'task deleted';
    }

    #[\Override]
    public function taskEdited(): string
    {
        return 'task edited';
    }

    #[\Override]
    public function statusSet(): string
    {
        return 'status set';
    }

    #[\Override]
    public function workerAssigned(): string
    {
        return 'worker assigned';
    }

    #[\Override]
    public function assignmentRemoved(): string
    {
        return 'removed assignment';
    }

    #[\Override]
    public function taskReset(): string
    {
        return 'task reset';
    }

    #[\Override]
    public function workerAdded(): string
    {
        return 'worker added';
    }

    #[\Override]
    public function itIsYou(): string
    {
        return 'this is you!';
    }

    #[\Override]
    public function workerDeleted(): string
    {
        return 'worker deleted';
    }

    #[\Override]
    public function twoFactorDisabled(): string
    {
        return 'two-factor authentication disabled';
    }

    #[\Override]
    public function workerEdited(): string
    {
        return 'worker edited';
    }

    #[\Override]
    public function twoFactorEnabled(): string
    {
        return 'two-factor authentication enabled';
    }

    #[\Override]
    public function setAdminFlag(): string
    {
        return 'admin flag saved';
    }

    #[\Override]
    public function passwordDeleted(): string
    {
        return 'password deleted';
    }

    #[\Override]
    public function iAmWorkingOn(): string
    {
        return 'i am working on it';
    }

    #[\Override]
    public function nobodyIsWorkingOn(): string
    {
        return 'nobody is working on it';
    }

    #[\Override]
    public function reset(): string
    {
        return 'reset';
    }

    #[\Override]
    public function deactivate(): string
    {
        return 'deactivate';
    }

    #[\Override]
    public function activate(): string
    {
        return 'activate';
    }

    #[\Override]
    public function info(): string
    {
        return 'info';
    }

    #[\Override]
    public function status(): string
    {
        return 'status';
    }

    #[\Override]
    public function active(): string
    {
        return 'active';
    }

    #[\Override]
    public function paused(): string
    {
        return 'paused';
    }

    #[\Override]
    public function willBeNotified(): string
    {
        return 'will be notified';
    }

    #[\Override]
    public function willNotBeNotified(): string
    {
        return 'will not be notified';
    }

    #[\Override]
    public function priority(): string
    {
        return 'priority';
    }

    #[\Override]
    public function nobody(): string
    {
        return 'nobody';
    }

    #[\Override]
    public function by(): string
    {
        return 'by';
    }

    #[\Override]
    public function taskList(): string
    {
        return 'task list';
    }

    #[\Override]
    public function step(): string
    {
        return 'step';
    }

    #[\Override]
    public function notice(): string
    {
        return 'notice';
    }

    #[\Override]
    public function steps(): string
    {
        return 'steps';
    }

    #[\Override]
    public function without(): string
    {
        return 'without';
    }

    #[\Override]
    public function intervalType(): string
    {
        return 'interval type';
    }

    #[\Override]
    public function intervalValue(): string
    {
        return 'interval value';
    }

    #[\Override]
    public function intervalMode(): string
    {
        return 'interval mode';
    }

    #[\Override]
    public function stepsQuestion(): string
    {
        return 'Which steps shall be done?';
    }

    #[\Override]
    public function add(): string
    {
        return 'add';
    }

    #[\Override]
    public function addTask(): string
    {
        return 'add task';
    }

    #[\Override]
    public function editTask(string $task): string
    {
        return 'edit task ' . $task;
    }

    #[\Override]
    public function groups(): string
    {
        return 'groups';
    }

    #[\Override]
    public function addGroup(): string
    {
        return 'new group';
    }

    #[\Override]
    public function addWorker(): string
    {
        return 'add new worker';
    }

    #[\Override]
    public function editWorker(string $who): string
    {
        return 'edit worker ' . \DoEveryApp\Util\View\Escaper::escape(value: $who);
    }

    #[\Override]
    public function enableTwoFactorForWorker(string $who): string
    {
        return 'enable 2FA for worker ' . \DoEveryApp\Util\View\Escaper::escape(value: $who);
    }

    #[\Override]
    public function twoFactorNotice(): string
    {
        return 'Scan the QR code on the left side with your authenticator app (e.g., Google Authenticator). <br />
Securely store the three access codes so you can access the system even without the authenticator app.<br /><br />
Then click the "Save" button to complete the process and digitally secure the data.';
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
        return '+2FA';
    }

    #[\Override]
    public function removeTwoFactor(): string
    {
        return '-2FA';
    }

    #[\Override]
    public function logFor(string $who): string
    {
        return 'work log for "' . \DoEveryApp\Util\View\Escaper::escape(value: $who) . '"';
    }

    #[\Override]
    public function workerDidNothing(string $who): string
    {
        return '- ' . \DoEveryApp\Util\View\Escaper::escape(value: $who) . ' did not contribute yet -';
    }

    #[\Override]
    public function needEmailForThisAction(): string
    {
        return 'an e-Mail-address is required.';
    }

    #[\Override]
    public function loginRequired(): string
    {
        return 'a login is required';
    }

    #[\Override]
    public function help(): string
    {
        return 'help';
    }

    #[\Override]
    public function areYouSure(): string
    {
        return 'Are you sure?';
    }

    #[\Override]
    public function reallyWantToDeleteTask(string $name): string
    {
        return 'Do you really want to delete the task "' . $name . '"?';
    }

    #[\Override]
    public function reallyWantToDeleteGroup(string $name): string
    {
        return 'Do you really want to delete the group "' . $name . '"?';
    }

    #[\Override]
    public function reallyWantToResetTask(string $name): string
    {
        return 'Do you really want to reset the task "' . $name . '"?';
    }

    #[\Override]
    public function reallyWantToDeleteExecution(): string
    {
        return 'Do you really want to delete the execution?';
    }

    #[\Override]
    public function reallyWantToDeleteWorker(string $name): string
    {
        return 'Do you really want to delete the worker "' . $name . '"?';
    }

    #[\Override]
    public function reallyWantToResetTwoFactor(string $name): string
    {
        return 'Do you really want to reset the two-factor authentication for the worker "' . $name . '"?';
    }

    #[\Override]
    public function noGroupsFound(): string
    {
        return 'no groups found';
    }

    #[\Override]
    public function noTasksFound(): string
    {
        return 'no tasks found';
    }

    #[\Override]
    public function welcomeUser(string $useName): string
    {
        return 'Welcome, ' . $useName . '!';
    }

    #[\Override]
    public function timerStart(): string
    {
        return 'start';
    }

    #[\Override]
    public function timerPause(): string
    {
        return 'pause';
    }

    #[\Override]
    public function timerStop(): string
    {
        return 'stop';
    }

    #[\Override]
    public function timerReset(): string
    {
        return 'reset';
    }

    #[\Override]
    public function timerTakeTime(): string
    {
        return 'take';
    }

    #[\Override]
    public function timer(): string
    {
        return 'timer';
    }

    #[\Override]
    public function useTimer(): string
    {
        return 'use timer';
    }

    #[\Override]
    public function running(): string
    {
        return 'running';
    }

    #[\Override]
    public function sections(): string
    {
        return 'sections';
    }

    #[\Override]
    public function davEnabled(): string
    {
        return 'DAV enabled';
    }

    #[\Override]
    public function enableDav(): string
    {
        return 'enable DAV';
    }

    #[\Override]
    public function davUser(): string
    {
        return 'DAV user';
    }

    #[\Override]
    public function davPassword(): string
    {
        return 'DAV password';
    }

    #[\Override]
    public function davUrl(): string
    {
        return 'DAV URL';
    }

    #[\Override]
    public function markdownTransformationEnabled(): string
    {
        return 'markdown transformation enabled';
    }

    #[\Override]
    public function reallyWantToDeleteTimer(): string
    {
        return 'Do you really want to delete the timer?';
    }

    #[\Override]
    public function timerDeleted(): string
    {
        return 'timer deleted';
    }

    #[\Override]
    public function disabledTasks(): string
    {
        return 'disabled tasks';
    }

    #[\Override]
    public function enabledTasks(): string
    {
        return 'enabled tasks';
    }

    #[\Override]
    public function cloneTask(string $task): string
    {
        return 'clone task ' . $task;
    }

    #[\Override]
    public function taskCloned(): string
    {
        return 'task cloned';
    }

    #[\Override]
    public function now(): string
    {
        return 'now';
    }

    #[\Override]
    public function runningTimer(): string
    {
        return 'running timer';
    }

    #[\Override]
    public function taskType(): string
    {
        return 'task type';
    }

    #[\Override]
    public function intervalTypeOneTime(): string
    {
        return 'one time';
    }

    #[\Override]
    public function clone(): string
    {
        return 'clone';
    }

    #[\Override]
    public function dueDate(): string
    {
        return 'due date';
    }

    #[\Override]
    public function remindDate(): string
    {
        return 'remind date';
    }

    #[\Override]
    public function backupDelay(): string
    {
        return 'backup interval (in hours)';
    }

    #[\Override]
    public function passwordChangeInterval(): string
    {
        return 'password change interval (in months)';
    }

    #[\Override]
    public function itIsNotYou(): string
    {
        return 'this is not you!';
    }

    #[\Override]
    public function hasPasskeyQuestion(): string
    {
        return 'has passkey?';
    }

    #[\Override]
    public function reallyWantToDeletePasskey(string $name): string
    {
        return 'Do you really want to delete the passkey for ' . $name . '?';
    }

    #[\Override]
    public function removePasskey(): string
    {
        return 'remove passkey';
    }

    #[\Override]
    public function addPasskey(): string
    {
        return '+ PK';
    }

    #[\Override]
    public function passkeyDeleted(): string
    {
        return 'passkey deleted';
    }

    #[\Override]
    public function loginWithPasskey(): string
    {
        return 'login with passkey';
    }

    #[\Override]
    public function passkeyAdded(): string
    {
        return 'passkey added';
    }

    #[\Override]
    public function passkeyLoginError(): string
    {
        return 'passkey login error';
    }

    #[\Override]
    public function twoFactorValidation(): string
    {
        return 'two-factor validation';
    }

    #[\Override]
    public function orUseRecoveryCode(): string
    {
        return 'or use recovery code';
    }

    #[\Override]
    public function passwordAdded(): string
    {
        return 'password added';
    }

    #[\Override]
    public function addPassword(): string
    {
        return 'ass password';
    }

    #[\Override]
    public function passwordRepeat(): string
    {
        return 'repeat password';
    }

    #[\Override]
    public function proposePassword(): string
    {
        return 'propose password';
    }
}
