<?php

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';


#[\Symfony\Component\Console\Attribute\AsCommand(name: 'users:list')]
class UserListCommand extends \Symfony\Component\Console\Command\Command
{
    public function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output): int
    {
        $table = new \Symfony\Component\Console\Helper\Table(output: $output);
        $table->setHeaders(headers: [
                                        'id',
                                        'email',
                                        'name',
                                        'last login',
                                        'lang',
                                        'admin',
                                        'notify tasks',
                                        'notify logins',
                                        'working',
                                        'assigned',
                                        'reset token',
                                        'last pw change',
                                        'pk set',
                                    ]);

        $maxLength = 80;
        foreach (\DoEveryApp\Entity\Worker::getRepository()->findIndexed() as $worker) {
            $workingOn = '';
            $assigned = '';
            foreach ($worker->getTasksWorkingOn() as $task) {
                $workingOn .= $task->display() . ', ';
            }
            foreach ($worker->getTasksAssigned() as $task) {
                $assigned .= $task->display() . ', ';
            }
            $workingOn = rtrim($workingOn, ', ');
            $workingOn = trim($workingOn);
            if ('' === $workingOn) {
                $workingOn = '-';
            }
            if ($maxLength < strlen($workingOn)) {
                $workingOn = substr($workingOn, 0, $maxLength) . '...';
            }
            $assigned = rtrim($assigned, ', ');
            $assigned = trim($assigned);
            if ('' === $assigned) {
                $assigned = '-';
            }
            if ($maxLength < strlen($assigned)) {
                $assigned = substr($assigned, 0, $maxLength) . '...';
            }
            $table->addRow(
                row: [
                         $worker->getId(),
                         $worker->getEmail(),
                         $worker->getName(),
                         $worker->getLastLogin()?->format('Y-m-d H:i:s') ?? '-',
                         $worker->getLanguage() ?? '-',
                         $worker->isAdmin() ? 'yes': 'no',
                         $worker->doNotify() ? 'yes': 'no',
                         $worker->doNotifyLogin() ? 'yes': 'no',
                         $workingOn,
                         $assigned,
                         $worker->getPasswordResetToken() ?? '-',
                         $worker->getLastPasswordChange()?->format('Y-m-d H:i:s') ?? '-',
                         null === $worker->getPasskeyCredential() ? 'no' : 'yes',
                     ],
            );

        }



        $table->render();
        return 0;
    }
}

$application = new \Symfony\Component\Console\Application(name: 'user', version: '1.0.0');
$application->addCommand(new UserListCommand());
$application->run();