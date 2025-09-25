<?php

declare(strict_types = 1);

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


    public function dashboardLastPasswordChange(\DateTime $dateTime): string;


    public function dashboardChangePassword(): string;


    public function dashboardAddTwoFactor(): string;


    public function currentWorks(): string;


    public function task(): string;


    public function currentlyWorkingOn(): string;


    public function assignedTo(): string;


    public function tasksWithDue(): string;


    public function isCurrentlyWorkingOn(string $who): string;


    public function group(): string;


    public function name(): string;


    public function lastExecution(): string;


    public function due(): string;


    public function interval(): string;


    public function actions(): string;


    public function show(): string;


    public function addExecution(): string;

    public function editExecution(): string;


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

    public function daysPluralized(null|int|float $dayAmount = 0): string;


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


    public function codeNotValid(): string;


    public function defaultErrorMessage(): string;


    public function userNotFound(): string;


    public function codeSent(): string;


    public function passwordConfirmFailed(): string;


    public function passwordChanged(): string;


    public function settingsSaved(): string;


    public function workerNotFound(): string;


    public function taskNotFound(): string;


    public function executionAdded(): string;


    public function executionNotFound(): string;


    public function executionDeleted(): string;


    public function executionEdited(): string;


    public function groupAdded(): string;


    public function groupNotFound(): string;


    public function groupDeleted(): string;


    public function groupEdited(): string;


    public function taskAdded(): string;


    public function taskDeleted(): string;


    public function taskEdited(): string;


    public function statusSet(): string;


    public function workerAssigned(): string;


    public function assignmentRemoved(): string;


    public function taskReset(): string;


    public function workerAdded(): string;


    public function itIsYou(): string;


    public function workerDeleted(): string;


    public function twoFactorDisabled(): string;


    public function workerEdited(): string;


    public function twoFactorEnabled(): string;


    public function setAdminFlag(): string;


    public function passwordDeleted(): string;


    public function iAmWorkingOn(): string;


    public function nobodyIsWorkingOn(): string;


    public function reset(): string;


    public function deactivate(): string;


    public function activate(): string;


    public function info(): string;


    public function status(): string;


    public function active(): string;


    public function paused(): string;


    public function willBeNotified(): string;


    public function willNotBeNotified(): string;


    public function priority(): string;


    public function nobody(): string;


    public function by(): string;


    public function taskList(): string;


    public function step(): string;


    public function steps(): string;


    public function notice(): string;


    public function without(): string;


    public function intervalType(): string;


    public function intervalValue(): string;


    public function intervalMode(): string;


    public function stepsQuestion(): string;


    public function add(): string;


    public function addTask(): string;


    public function editTask(string $task): string;

    public function cloneTask(string $task): string;


    public function groups(): string;


    public function addGroup(): string;


    public function addWorker(): string;


    public function editWorker(string $who): string;


    public function enableTwoFactorForWorker(string $who): string;


    public function twoFactorNotice(): string;


    public function code(): string;


    public function codes(): string;


    public function log(): string;


    public function addTwoFactor(): string;


    public function removeTwoFactor(): string;


    public function logFor(string $who): string;


    public function workerDidNothing(string $who): string;


    public function needEmailForThisAction(): string;


    public function loginRequired(): string;


    public function help(): string;

    public function areYouSure(): string;

    public function reallyWantToDeleteTask(string $name): string;

    public function reallyWantToDeleteGroup(string $name): string;

    public function reallyWantToResetTask(string $name): string;

    public function reallyWantToDeleteExecution(): string;

    public function reallyWantToDeleteWorker(string $name): string;

    public function reallyWantToResetTwoFactor(string $name): string;

    public function noGroupsFound(): string;

    public function noTasksFound(): string;

    public function welcomeUser(string $useName): string;

    public function timerStart(): string;

    public function timerPause(): string;

    public function timerStop(): string;

    public function timerReset(): string;

    public function timerTakeTime(): string;

    public function timer(): string;

    public function useTimer(): string;

    public function running(): string;

    public function sections(): string;

    public function davEnabled(): string;

    public function enableDav(): string;

    public function davUser(): string;

    public function davPassword(): string;

    public function davUrl(): string;

    public function markdownTransformationEnabled(): string;

    public function reallyWantToDeleteTimer(): string;

    public function timerDeleted(): string;

    public function disabledTasks(): string;

    public function enabledTasks(): string;

    public function taskCloned(): string;

    public function now(): string;

    public function runningTimer(): string;

    public function taskType(): string;

    public function intervalTypeOneTime(): string;

    public function clone(): string;

    public function dueDate(): string;

    public function remindDate(): string;

    public function backupDelay(): string;

    public function passwordChangeInterval(): string;
}
