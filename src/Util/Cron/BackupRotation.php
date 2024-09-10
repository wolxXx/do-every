<?php

declare(strict_types=1);

namespace DoEveryApp\Util\Cron;

class BackupRotation
{
    public function __construct()
    {
        $now = \Carbon\Carbon::now();
        \DoEveryApp\Util\DependencyContainer::getInstance()
                                            ->getLogger()
                                            ->debug('backup rotation')
        ;
        $path      = \ROOT_DIR . \DIRECTORY_SEPARATOR . 'backups' . \DIRECTORY_SEPARATOR;
        $Directory = new \RecursiveDirectoryIterator($path);
        $Iterator  = new \RecursiveIteratorIterator($Directory);
        $Regex     = new \RegexIterator($Iterator, '/^.+\.sql/i', \RegexIterator::GET_MATCH);
        foreach ($Regex as $files) {
            foreach ($files as $file) {
                $realPath     = \realpath($file);
                $fileName     = basename($realPath);
                $filename     = \str_replace(['backup_', '.sql', '_'], ['', '', ' '], $fileName);
                $split        = explode(' ', $filename);
                $filename     = $split[0] . ' ' . \str_replace('-', ':', $split[1]);
                $creationDate = \Carbon\Carbon::create($filename);
                $diff         = $creationDate->diff($now, true, ['y', 'm'])->d;
                if ($diff >= \DoEveryApp\Util\Registry::getInstance()->getKeepBackupDays()) {
                    if (false === \unlink($realPath)) {
                        \DoEveryApp\Util\DependencyContainer::getInstance()
                                                            ->getLogger()
                                                            ->error('Failed to delete backup file: ' . $realPath)
                        ;
                    }
                }
            }
        }
        $this->deleteEmptyDirectories($path);
    }


    protected function deleteEmptyDirectories($path): void
    {
        $fileCount = $this->countFiles($path);
        if (0 === $fileCount) {
            if (false === \rmdir($path)) {
                \DoEveryApp\Util\DependencyContainer::getInstance()
                                                    ->getLogger()
                                                    ->error('Failed to delete empty directory: ' . $path)
                ;
            }

            return;
        }
        foreach (\scandir($path) as $childPath) {
            if ('.' === $childPath || '..' === $childPath) {
                continue;
            }
            $childPath = $path . $childPath;
            if (true === \is_dir($childPath)) {
                $this->deleteEmptyDirectories($childPath . \DIRECTORY_SEPARATOR);
            }
        }
    }


    protected function countFiles($path): int
    {
        /**
         * @var \SplFileInfo $pathToScan
         */
        $count        = 0;
        $pathIterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        foreach ($pathIterator as $pathToScan) {
            if (false === $pathToScan->isDir()) {
                $count++;
                continue;
            }
            $basename = $pathToScan->getBasename();
            if ('.' === $basename || '..' === $basename) {
                continue;
            }
            $count += $this->countFiles($pathToScan->getRealPath());
        }

        return $count;
    }
}