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


    public function tasksWithDue(): string;


    public function isCurrentlyWorkingOn(): string;


    public function group(): string;


    public function name(): string;


    public function lastExecution(): string;


    public function due(): string;


    public function interval(): string;


    public function actions(): string;


    public function show(): string;


    public function addExecution(): string;


    public function edit(): string;


    public function delete(): string;


    public function executions(): string;


    public function date(): string;


    public function effort(): string;


    public function note(): string;


    public function statistics(): string;


    public function averageEffort(): string;


    public function totalEffort(): string;


    public function today(): string;


    public function yesterday(): string;


    public function thisWeek(): string;


    public function lastWeek(): string;


    public function thisMonth(): string;


    public function lastMonth(): string;


    public function thisYear(): string;


    public function lastYear(): string;


    public function byMonth(): string;


    public function byYear(): string;


    public function what(): string;


    public function value(): string;


    public function editSettings(): string;


    public function fillTimeLineQuestion(): string;


    public function yes(): string;


    public function no(): string;


    public function duePrecision(): string;


    public function keepBackupDays(): string;


    public function save(): string;


    public function new(): string;


    public function hasPasswordQuestion(): string;


    public function isAdminQuestion(): string;


    public function doNotifyLoginsQuestion(): string;


    public function doNotifyDueTasksQuestion(): string;


    public function lastLogin(): string;


    public function lastPasswordChange(): string;


    public function dueIsNow(): string;


    public function dueIsInFuture(): string;


    public function dueIsInPast(): string;


    public function minute(): string;


    public function minutes(): string;


    public function hour(): string;


    public function hours(): string;


    public function day(): string;


    public function days(): string;


    public function month(): string;


    public function months(): string;


    public function year(): string;


    public function years(): string;


    public function dueAdverb(): string;


    public function noValue(): string;


    public function oneMinute(): string;


    public function twoMinutes(): string;


    public function threeMinutes(): string;


    public function fourMinutes(): string;


    public function fiveMinutes(): string;


    public function intervalTypeRelative(): string;


    public function intervalTypeCyclic(): string;


    public function dueIsEvery(): string;


    public function dueIsEveryMinute(): string;


    public function dueIsEveryHour(): string;


    public function dueIsEveryDay(): string;


    public function dueIsEveryMonth(): string;


    public function dueIsEveryYear(): string;


    public function priorityLow(): string;


    public function priorityNormal(): string;


    public function priorityHigh(): string;


    public function priorityUrgent(): string;
}
