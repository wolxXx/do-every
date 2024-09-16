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


    public function dashboardLastPasswordChange(): string
    {
        return 'last password change';
    }


    public function dashboardChangePassword(): string
    {
        return 'change password';
    }


    public function dashboardAddTwoFactor(): string
    {
        return 'You should enable the two factor authentication.';
    }


    public function currentWorks(): string
    {
        return 'current works';
    }


    public function task(): string
    {
        return 'task';
    }


    public function currentlyWorkingOn(): string
    {
        return 'currently working on';
    }


    public function assignedTo(): string
    {
        return 'assigned to';
    }


    public function tasksWithDue(): string
    {
        return 'tasks';
    }


    public function isCurrentlyWorkingOn(): string
    {
        return '%s is working on';
    }


    public function group(): string
    {
        return 'group';
    }


    public function name(): string
    {
        return 'name';
    }


    public function lastExecution(): string
    {
        return 'last execution';
    }


    public function due(): string
    {
        return 'due';
    }


    public function interval(): string
    {
        return 'interval';
    }


    public function actions(): string
    {
        return 'actions';
    }


    public function show(): string
    {
        return 'show';
    }


    public function addExecution(): string
    {
        return 'add execution';
    }


    public function edit(): string
    {
        return 'edit';
    }


    public function delete(): string
    {
        return 'delete';
    }


    public function executions(): string
    {
        return 'executions';
    }


    public function date(): string
    {
        return 'date';
    }


    public function effort(): string
    {
        return 'effort';
    }


    public function note(): string
    {
        return 'note';
    }


    public function statistics(): string
    {
        return 'statistics';
    }


    public function averageEffort(): string
    {
        return 'average';
    }


    public function totalEffort(): string
    {
        return 'total';
    }


    public function today(): string
    {
        return 'today';
    }


    public function yesterday(): string
    {
        return 'yesterday';
    }


    public function thisWeek(): string
    {
        return 'this week';
    }


    public function lastWeek(): string
    {
        return 'last week';
    }


    public function thisMonth(): string
    {
        return 'this month';
    }


    public function lastMonth(): string
    {
        return 'last month';
    }


    public function thisYear(): string
    {
        return 'this year';
    }


    public function lastYear(): string
    {
        return 'last year';
    }


    public function byMonth(): string
    {
        return 'by month';
    }


    public function byYear(): string
    {
        return 'by year';
    }


    public function what(): string
    {
        return 'what';
    }


    public function value(): string
    {
        return 'value';
    }


    public function editSettings(): string
    {
        return 'edit settings';
    }


    public function fillTimeLineQuestion(): string
    {
        return 'do fill time line?';
    }


    public function yes(): string
    {
        return 'yes';
    }


    public function no(): string
    {
        return 'no';
    }


    public function duePrecision(): string
    {
        return 'due precision';
    }


    public function keepBackupDays(): string
    {
        return 'keep backups (days)';
    }


    public function save(): string
    {
        return 'save';
    }


    public function new(): string
    {
        return 'new';
    }


    public function hasPasswordQuestion(): string
    {
        return 'has password?';
    }


    public function isAdminQuestion(): string
    {
        return 'is admin?';
    }


    public function doNotifyLoginsQuestion(): string
    {
        return 'do notify logins?';
    }


    public function doNotifyDueTasksQuestion(): string
    {
        return 'do notify due tasks?';
    }


    public function lastLogin(): string
    {
        return 'last login';
    }


    public function lastPasswordChange(): string
    {
        return 'last password change';
    }


    public function dueIsNow(): string
    {
        return 'is now due';
    }


    public function dueIsInFuture(): string
    {
        return 'in';
    }


    public function dueIsInPast(): string
    {
        return 'since';
    }


    public function minute(): string
    {
        return 'minute';
    }


    public function minutes(): string
    {
        return 'minutes';
    }


    public function hour(): string
    {
        return 'hour';
    }


    public function hours(): string
    {
        return 'hours';
    }


    public function day(): string
    {
        return 'day';
    }


    public function days(): string
    {
        return 'days';
    }


    public function month(): string
    {
        return 'month';
    }


    public function months(): string
    {
        return 'months';
    }


    public function year(): string
    {
        return 'year';
    }


    public function years(): string
    {
        return 'years';
    }


    public function dueAdverb(): string
    {
        return 'due';
    }


    public function noValue(): string
    {
        return '-';
    }


    public function oneMinute(): string
    {
        return '1 minute';
    }


    public function twoMinutes(): string
    {
        return '2 minutes';
    }


    public function threeMinutes(): string
    {
        return '3 minutes';
    }


    public function fourMinutes(): string
    {
        return '4 minutes';
    }


    public function fiveMinutes(): string
    {
        return '5 minutes';
    }


    public function intervalTypeRelative(): string
    {
        return 'relative';
    }


    public function intervalTypeCyclic(): string
    {
        return 'cyclic';
    }


    public function dueIsEvery(): string
    {
        return 'every';
    }


    public function dueIsEveryMinute(): string
    {
        return 'every minute';
    }


    public function dueIsEveryHour(): string
    {
        return 'every hour';
    }


    public function dueIsEveryDay(): string
    {
        return 'every day';
    }


    public function dueIsEveryMonth(): string
    {
        return 'every month';
    }


    public function dueIsEveryYear(): string
    {
        return 'every year';
    }


    public function priorityLow(): string
    {
        return 'low';
    }


    public function priorityNormal(): string
    {
        return 'normal';
    }


    public function priorityHigh(): string
    {
        return 'high';
    }


    public function priorityUrgent(): string
    {
        return 'urgent';
    }


    public function codeNotValid(): string
    {
        return 'code not valid';
    }


    public function defaultErrorMessage(): string
    {
        return 'an error occurred';
    }


    public function userNotFound(): string
    {
        return 'user not found';
    }


    public function codeSent(): string
    {
        return 'code sent';
    }


    public function passwordConfirmFailed(): string
    {
        return 'password confirm failed';
    }


    public function passwordChanged(): string
    {
        return 'password changed';
    }


    public function settingsSaved(): string
    {
        return 'settings saved';
    }


    public function workerNotFound(): string
    {
        return 'worker not found';
    }


    public function taskNotFound(): string
    {
        return 'task not found';
    }


    public function executionAdded(): string
    {
        return 'execution added';
    }


    public function executionNotFound(): string
    {
        return 'execution not found';
    }


    public function executionDeleted(): string
    {
        return 'execution deleted';
    }


    public function executionEdited(): string
    {
        return 'execution edited';
    }


    public function groupAdded(): string
    {
        return 'group added';
    }


    public function groupNotFound(): string
    {
        return 'group not found';
    }


    public function groupDeleted(): string
    {
        return 'group deleted';
    }


    public function groupEdited(): string
    {
        return 'group edited';
    }


    public function taskAdded(): string
    {
        return 'task added';
    }


    public function taskDeleted(): string
    {
        return 'task deleted';
    }


    public function taskEdited(): string
    {
        return 'task edited';
    }


    public function statusSet(): string
    {
        return 'status set';
    }


    public function workerAssigned(): string
    {
        return 'worker assigned';
    }


    public function assignmentRemoved(): string
    {
        return 'removed assignment';
    }


    public function taskReset(): string
    {
        return 'task reset';
    }


    public function workerAdded(): string
    {
        return 'worker added';
    }


    public function itIsYou(): string
    {
        return 'this is you!';
    }


    public function workerDeleted(): string
    {
        return 'worker deleted';
    }


    public function twoFactorDisabled(): string
    {
        return 'two-factor authentication disabled';
    }


    public function workerEdited(): string
    {
        return 'worker edited';
    }


    public function twoFactorEnabled(): string
    {
        return 'two-factor authentication enabled';
    }


    public function setAdminFlag(): string
    {
        return 'admin flag saved';
    }


    public function passwordDeleted(): string
    {
        return 'password deleted';
    }


    public function iAmWorkingOn(): string
    {
        return 'i am working on it';
    }


    public function nobodyIsWorkingOn(): string
    {
        return 'nobody is working on it';
    }


    public function reset(): string
    {
        return 'reset';
    }


    public function deactivate(): string
    {
        return 'deactivate';
    }


    public function activate(): string
    {
        return 'activate';
    }


    public function info(): string
    {
        return 'info';
    }


    public function status(): string
    {
        return 'status';
    }


    public function active(): string
    {
        return 'active';
    }


    public function paused(): string
    {
        return 'paused';
    }


    public function willBeNotified(): string
    {
        return 'will be notified';
    }


    public function willNotBeNotified(): string
    {
        return 'will not be not notified';
    }


    public function priority(): string
    {
        return 'priority';
    }


    public function nobody(): string
    {
        return 'nobody';
    }


    public function by(): string
    {
        return 'by';
    }


    public function taskList(): string
    {
        return 'task list';
    }


    public function step(): string
    {
        return 'step';
    }


    public function notice(): string
    {
        return 'notice';
    }


    public function steps(): string
    {
        return 'steps';
    }


    public function without(): string
    {
        return 'without';
    }


    public function intervalType(): string
    {
        return 'interval type';
    }


    public function intervalValue(): string
    {
        return 'interval value';
    }


    public function intervalMode(): string
    {
        return 'intervall mode';
    }


    public function stepsQuestion(): string
    {
        return 'Which steps shall be done?';
    }


    public function add(): string
    {
        return 'add';
    }


    public function addTask(): string
    {
        return 'add task';
    }


    public function editTask(): string
    {
        return 'edit task %s';
    }


    public function groups(): string
    {
        return 'groups';
    }


    public function addGroup(): string
    {
        return 'mew group';
    }


    public function addWorker(): string
    {
        return 'add new worker';
    }


    public function editWorker(): string
    {
        return 'edit worker %s';
    }


    public function enableTwoFactorForWorker(): string
    {
        return 'enable 2FA for worker %s';
    }


    public function twoFactorNotice(): string
    {
        return 'Scan the QR code on the left side with your authenticator app (e.g., Google Authenticator). <br />
Securely store the three access codes so you can access the system even without the authenticator app.<br /><br />
Then click the "Save" button to complete the process and digitally secure the data.';
    }


    public function code(): string
    {
        return 'Code';
    }


    public function codes(): string
    {
        return 'Codes';
    }


    public function log(): string
    {
        return 'log';
    }


    public function addTwoFactor(): string
    {
        return '+2FA';
    }


    public function removeTwoFactor(): string
    {
        return '-2FA';
    }


    public function logFor(): string
    {
        return 'work log for "%s"';
    }


    public function workerDidNothing(): string
    {
        return '- %s did not contribute yet -';
    }


    public function needEmailForThisAction(): string
    {
        return 'an e-Mail-address is required.';
    }
}