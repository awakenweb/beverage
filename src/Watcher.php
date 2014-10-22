<?php

namespace Awakenweb\Beverage;

use Symfony\Component\Finder\Finder;

/**
 * Description of Watcher
 *
 * @author Administrateur
 */
class Watcher
{
    protected $files_iterators = [];

    public function run($output = null)
    {
        do {
            foreach ($this->files_iterators as $fi) {
                $finder = new Finder();
                $finder->files()
                    ->ignoreUnreadableDirs()
                    ->name($fi['filepattern']);

                if ($fi['excludepattern']) {
                    $finder->notName($fi['excludepattern']);
                }

                foreach ($fi['dir'] as $directory) {
                    $finder->in($directory);
                }

                foreach ($finder as $file) {
                    if (!isset($files[$file->getBasename()])) {
                        $files[$file->getBasename()] = $file->getMTime();
                    }

                    if ($files[$file->getBasename()] !== $file->getMTime()) {
                        if (!is_null($output)) {
                            $output->writeln('File '.$file->getBasename().' has been modified');
                        }
                        $files[$file->getBasename()] = $file->getMTime();
                        foreach ($fi['tasks'] as $task) {
                            if (!is_null($output)) {
                                $output->writeln('Running '.$task.' task');
                            }
                            $task();
                            if (!is_null($output)) {
                                $output->writeln('Task '.$task.' successful');
                            }
                        }
                    }
                }

                unset($finder);
            }
            sleep(2);
        } while (1);
    }

    public function watch($filepattern, array $tasks, $dir = [__DIR__], $excludepattern = false)
    {
        $this->files_iterators[] = [
            'filepattern'    => $filepattern,
            'dir'            => $dir,
            'excludepattern' => $excludepattern,
            'tasks'          => $tasks,
        ];

        return $this;
    }
}
