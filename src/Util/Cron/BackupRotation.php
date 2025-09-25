<?php

declare(strict_types=1);

namespace DoEveryApp\Util\Cron;

class BackupRotation
{
    public function __construct()
    {
        $now           = \Carbon\Carbon::now();
        $path          = \ROOT_DIR . \DIRECTORY_SEPARATOR . 'backups' . \DIRECTORY_SEPARATOR;
        $Directory     = new \RecursiveDirectoryIterator(directory: $path);
        $Iterator      = new \RecursiveIteratorIterator(iterator: $Directory);
        $regexIterator = new \RegexIterator(
            iterator: $Iterator,
            pattern : '/^.+\.sql/i',
            mode    : \RegexIterator::GET_MATCH,
        );
        foreach ($regexIterator as $files) {
            foreach ($files as $file) {
                $realPath     = \realpath(path: $file);
                $fileName     = basename(path: $realPath);
                $filename     = \str_replace(search: ['backup_', '.sql', '_'], replace: ['', '', ' '], subject: $fileName);
                $split        = explode(separator: ' ', string: $filename);
                $filename     = $split[0] . ' ' . \str_replace(search: '-', replace: ':', subject: $split[1]);
                $creationDate = \Carbon\Carbon::create(year: $filename);
                $diff         = $creationDate->diff($now, true, ['y', 'm'])->d;
                if ($diff >= \DoEveryApp\Util\Registry::getInstance()->getKeepBackupDays()) {
                    if (false === \unlink(filename: $realPath)) {
                        \DoEveryApp\Util\DependencyContainer::getInstance()
                                                            ->getLogger()
                                                            ->error(message: 'Failed to delete backup file: ' . $realPath)
                        ;
                    }
                }
            }
        }
        $this->deleteEmptyDirectories(path: $path);
    }

    protected function deleteEmptyDirectories($path): void
    {
        $fileCount = $this->countFiles(path: $path);
        if (0 === $fileCount) {
            if (false === \rmdir(directory: $path)) {
                \DoEveryApp\Util\DependencyContainer::getInstance()
                                                    ->getLogger()
                                                    ->error(message: 'Failed to delete directory: ' . $path)
                ;
            }

            return;
        }
        foreach (\scandir(directory: $path) as $childPath) {
            if ('.' === $childPath || '..' === $childPath) {
                continue;
            }
            $childPath = $path . $childPath;
            if (true === \is_dir(filename: $childPath)) {
                $this->deleteEmptyDirectories(path: $childPath . \DIRECTORY_SEPARATOR);
            }
        }
    }

    protected function countFiles($path): int
    {
        /**
         * @var \SplFileInfo $pathToScan
         */
        $count        = 0;
        $pathIterator = new \RecursiveIteratorIterator(iterator: new \RecursiveDirectoryIterator(directory: $path));
        foreach ($pathIterator as $pathToScan) {
            if (false === $pathToScan->isDir()) {
                $count++;
                continue;
            }
            $basename = $pathToScan->getBasename();
            if ('.' === $basename || '..' === $basename) {
                continue;
            }
            $count += $this->countFiles(path: $pathToScan->getRealPath());
        }

        return $count;
    }
}
