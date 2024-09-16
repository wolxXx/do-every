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
}