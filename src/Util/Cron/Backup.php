<?php

declare(strict_types=1);

namespace DoEveryApp\Util\Cron;

class Backup
{
    public function __construct()
    {
        $now     = \Carbon\Carbon::now();
        $lastRun = \DoEveryApp\Util\Registry::getInstance()
                                            ->getLastBackup()
        ;
        if (null !== $lastRun) {
            $lastRun = \Carbon\Carbon::create(year: $lastRun);
            $lastRun->addHours(2);
            if ($lastRun->gt($now)) {
                return;
            }
        }

        $dbParams = require \ROOT_DIR . \DIRECTORY_SEPARATOR . 'doctrineConfiguration.php';
        $command  = 'mysqldump --column-statistics=0 -u%s -p%s -P%s -h%s --triggers --routines --single-transaction %s > %s';

        $now = \Carbon\Carbon::now();

        $path = \ROOT_DIR . \DIRECTORY_SEPARATOR . 'backups' . \DIRECTORY_SEPARATOR . $now->year . DIRECTORY_SEPARATOR . str_pad(string: '' . $now->month, length: 2, pad_string: '0', pad_type: STR_PAD_LEFT) . DIRECTORY_SEPARATOR . str_pad(string: '' . $now->day, length: 2, pad_string: '0', pad_type: STR_PAD_LEFT) . \DIRECTORY_SEPARATOR;
        if (false === \is_dir(filename: $path)) {
            mkdir(directory: $path, permissions: 0777, recursive: true);
        }
        $path    = $path . 'backup_' . date(format: 'Y-m-d_H-i-s') . '.sql';
        $command = sprintf($command, $dbParams['user'], $dbParams['password'], $dbParams['port'], $dbParams['host'], $dbParams['dbname'], $path);

        exec(command: $command);

        \DoEveryApp\Util\Registry::getInstance()
                                 ->setLastBackup(lastBackup: \Carbon\Carbon::now())
        ;
    }
}
