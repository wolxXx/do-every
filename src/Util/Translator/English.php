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
}