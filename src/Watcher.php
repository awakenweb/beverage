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

    const EVENT_CHANGE = 1;

    protected $listeners       = ['before' => [], 'after' => []];
    protected $files_iterators = [];

    public function run($output = null)
    {

        $files = [];

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
                    /**
                     * Register the file the first time it is encountered
                     */
                    if (!isset($files[$file->getBasename()])) {
                        $files[$file->getBasename()] = $file->getMTime();
                    }

                    /**
                     * Check if the file has changed
                     */
                    if ($files[$file->getBasename()] !== $file->getMTime()) {
                        if (!is_null($output)) {
                            $output->writeln('File ' . $file->getBasename() . ' has been modified');
                        }
                        $files[$file->getBasename()] = $file->getMTime();

                        $this->runBefore();

                        foreach ($fi['tasks'] as $task) {
                            if (!is_null($output)) {
                                $output->writeln('Running ' . $task . ' task');
                            }
                            ;
                            $task();

                            if (!is_null($output)) {
                                $output->writeln('Task ' . $task . ' successful');
                            }
                        }

                        $this->runAfter();
                    }
                }

                unset($finder);
            }
            sleep(2);
        } while (1);
    }

    /**
     *
     * Register a new filewatcher
     *
     * @param type $filepattern
     * @param array $tasks
     * @param type $dir
     * @param type $excludepattern
     * @return \Awakenweb\Beverage\Watcher
     */
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

    /**
     * hookable Before listeners
     *
     * @param \Awakenweb\Beverage\Listener $listener
     */
    public function beforeTasks(Listener $listener)
    {
        $this->listeners['before'][] = $listener;

        return $this;
    }

    /**
     * hookable After listeners
     *
     * @param \Awakenweb\Beverage\Listener $listener
     */
    public function afterTasks(Listener $listener)
    {
        $this->listeners['after'][] = $listener;

        return $this;
    }

    /**
     * Trigger the before listeners
     */
    public function runBefore()
    {
        foreach ($this->listeners['before'] as $listener) {
            $listener->update();
        }
    }

     /**
     * Trigger the after listeners
     */
    public function runAfter()
    {
        foreach ($this->listeners['after'] as $listener) {
            $listener->update();
        }
    }

}
