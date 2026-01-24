<?php

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';


#[\Symfony\Component\Console\Attribute\AsCommand(name: 'registry:show')]
class ShowRegistryCommand extends \Symfony\Component\Console\Command\Command
{
    public function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output): int
    {
        $table = new \Symfony\Component\Console\Helper\Table(output: $output);
        $table->setHeaders(headers: [
            'key',
            'value',
            'description',
                                        ]);

        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_ADMIN_USER->value,
                     \DoEveryApp\Util\Registry::getInstance()->getAdminUser()?->getId() ?? '-',
                     'admin user',
                 ],
        );

        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_LAST_CRON->value,
                     \DoEveryApp\Util\Registry::getInstance()->getLastCron()?->format('Y-m-d H:i:s') ?? '-',
                     'last cron execution',
                 ],
        );

        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_CRON_STARTED->value,
                     \DoEveryApp\Util\Registry::getInstance()->getCronStarted()?->format('Y-m-d H:i:s') ?? '-',
                     'cron start time',
                 ],
        );

        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_CRON_LOCK->value,
                     \DoEveryApp\Util\Registry::getInstance()->isCronRunning() ? 'yes' : 'no' ?? '-',
                     'cron running',
                 ],
        );

        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_NOTIFIER_RUNNING->value,
                     \DoEveryApp\Util\Registry::getInstance()->isNotifierRunning() ? 'yes' : 'no' ?? '-',
                     'notifier running',
                 ],
        );

        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_CRON_STARTED->value,
                     \DoEveryApp\Util\Registry::getInstance()->getNotifierLastRun()?->format('Y-m-d H:i:s') ?? '-',
                     'notifier last run',
                 ],
        );

        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_KEEP_BACKUP_DAYS->value,
                     \DoEveryApp\Util\Registry::getInstance()->getKeepBackupDays(),
                     'keep backup days',
                 ],
        );

        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_LAST_BACKUP->value,
                     \DoEveryApp\Util\Registry::getInstance()->getLastBackup()?->format('Y-m-d H:i:s') ?? '-',
                     'last backup execution',
                 ],
        );

        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_MAX_WORKERS->value,
                     \DoEveryApp\Util\Registry::getInstance()->getMaxWorkers() ?? '-',
                     'max workers allowed',
                 ],
        );

        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_MAX_TASKS->value,
                     \DoEveryApp\Util\Registry::getInstance()->getMaxTasks() ?? '-',
                     'max tasks allowed',
                 ],
        );

        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_MAX_GROUPS->value,
                     \DoEveryApp\Util\Registry::getInstance()->getMaxGroups() ?? '-',
                     'max groups allowed',
                 ],
        );

        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_PRECISION_DUE->value,
                     \DoEveryApp\Util\Registry::getInstance()->getPrecisionDue(),
                     'precision due',
                 ],
        );

        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_FILL_TIME_LINE->value,
                     \DoEveryApp\Util\Registry::getInstance()->doFillTimeLine() ? 'yes' : 'no' ?? '-',
                     'do fill time line',
                 ],
        );

        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_USE_TIMER->value,
                     \DoEveryApp\Util\Registry::getInstance()->doUseTimer() ? 'yes' : 'no' ?? '-',
                     'do use timer',
                 ],
        );

        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_DAV_USER->value,
                     \DoEveryApp\Util\Registry::getInstance()->getDavUser() ?? '-',
                     'dav user',
                 ],
        );

        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_DAV_PASSWORD->value,
                     \DoEveryApp\Util\Registry::getInstance()->getDavPassword() ?? '-',
                     'dav password',
                 ],
        );

        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_MARKDOWN_TRANSFORMER_ACTIVE->value,
                     \DoEveryApp\Util\Registry::getInstance()->isMarkdownTransformerActive() ? 'yes' : 'no' ?? '-',
                     'markdown transformer active',
                 ],
        );

        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_BACKUP_DELAY->value,
                     \DoEveryApp\Util\Registry::getInstance()->backupDelay(),
                     'backup delay',
                 ],
        );

        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_PASSWORD_CHANGE_INTERVAL->value,
                     \DoEveryApp\Util\Registry::getInstance()->passwordChangeInterval(),
                     'password change interval',
                 ],
        );



        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_EMAIL_CONTENT_SECURITY_NOTES->value,
                     \DoEveryApp\Util\Registry::getInstance()->mailContentSecurityNote() ? 'yes' : 'no' ?? '-',
                     'email content has security notes',
                 ],
        );



        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_EMAIL_CONTENT_STEPS->value,
                     \DoEveryApp\Util\Registry::getInstance()->mailContentSteps() ? 'yes' : 'no' ?? '-',
                     'email content has task steps',
                 ],
        );



        $table->addRow(
            row: [
                     \DoEveryApp\Util\Registry\Key::KEY_THEME->value,
                     \DoEveryApp\Util\Registry::getInstance()->getTheme()->value,
                     'app theme',
                 ],
        );

        $table->render();
        return 0;
    }
}

$application = new \Symfony\Component\Console\Application(name: 'registry', version: '1.0.0');
$application->addCommand(new ShowRegistryCommand());
$application->run();