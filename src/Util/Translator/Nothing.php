<?php


declare(strict_types=1);

namespace DoEveryApp\Util\Translator;

class Nothing implements \DoEveryApp\Util\Translator
{

    protected function debug(): string
    {
        return '..';
    }


    public function translate($what, ...$args): string
    {
        return $this->debug();
    }


    public function dashboard(): string
    {
        return $this->debug();
    }


    public function attention(): string
    {
        return $this->debug();
    }


    public function go(): string
    {
        return $this->debug();
    }


    public function settings(): string
    {
        return $this->debug();
    }


    public function logout(): string
    {
        return $this->debug();
    }


    public function worker(): string
    {
        return $this->debug();
    }


    public function workers(): string
    {
        return $this->debug();
    }


    public function login(): string
    {
        return $this->debug();
    }


    public function eMail(): string
    {
        return $this->debug();
    }


    public function password(): string
    {
        return $this->debug();
    }


    public function tasks(): string
    {
        return $this->debug();
    }


    public function pageTitleSetNewPassword(): string
    {
        return $this->debug();
    }


    public function confirmPassword(): string
    {
        return $this->debug();
    }


    public function dashboardLastPasswordChange(): string
    {
        return $this->debug();
    }


    public function dashboardChangePassword(): string
    {
        return $this->debug();
    }


    public function dashboardAddTwoFactor(): string
    {
        return $this->debug();
    }


    public function currentWorks(): string
    {
        return $this->debug();
    }


    public function task(): string
    {
        return $this->debug();
    }


    public function currentlyWorkingOn(): string
    {
        return $this->debug();
    }


    public function assignedTo(): string
    {
        return $this->debug();
    }


    public function tasksWithDue(): string
    {
        return $this->debug();
    }


    public function isCurrentlyWorkingOn(): string
    {
        return $this->debug();
    }


    public function group(): string
    {
        return $this->debug();
    }


    public function name(): string
    {
        return $this->debug();
    }


    public function lastExecution(): string
    {
        return $this->debug();
    }


    public function due(): string
    {
        return $this->debug();
    }


    public function interval(): string
    {
        return $this->debug();
    }


    public function actions(): string
    {
        return $this->debug();
    }


    public function show(): string
    {
        return $this->debug();
    }


    public function addExecution(): string
    {
        return $this->debug();
    }


    public function edit(): string
    {
        return $this->debug();
    }


    public function delete(): string
    {
        return $this->debug();
    }


    public function executions(): string
    {
        return $this->debug();
    }


    public function date(): string
    {
        return $this->debug();
    }


    public function effort(): string
    {
        return $this->debug();
    }


    public function note(): string
    {
        return $this->debug();
    }


    public function statistics(): string
    {
        return $this->debug();
    }


    public function averageEffort(): string
    {
        return $this->debug();
    }


    public function totalEffort(): string
    {
        return $this->debug();
    }
}

