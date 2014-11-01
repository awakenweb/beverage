<?php

namespace Awakenweb\Beverage;

use Awakenweb\Beverage\Modules\Module;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Description of Beverage
 *
 * @author Administrateur
 */
class Beverage
{

    /**
     *
     * @var type
     */
    protected $current_state = [];

    /**
     * Factory method. Return a new instance of the Beverage task runner
     *
     * @param  string   $filepattern
     * @param  array    $directory
     * @param  string   $excludepattern
     * @return Beverage
     */
    public static function files($filepattern, $directory = [__DIR__], $excludepattern = false)
    {
        return new self($filepattern, $directory, $excludepattern);
    }

    /**
     * construct the Beverage task runner and select the files to manipulate
     *
     * @param string $filepattern
     * @param array  $dir
     * @param string $excludepattern
     *
     */
    protected function __construct($filepattern, $dir, $excludepattern)
    {
        $this->add($filepattern, $dir, $excludepattern);
    }

    /**
     * Run the modules
     *
     * @param Module module
     * @return Beverage
     */
    public function then(Module $module)
    {
        $this->current_state = $module->process($this->current_state);

        return $this;
    }

    /**
     * Define the directory where the files will be saved.
     * 
     * Once the files have been saves, the current state of files is unset to
     * save memory
     *
     * @param string $directory
     */
    public function destination($directory)
    {
        $filesystem = new Filesystem();

        foreach ($this->current_state as $filename => $file_content) {
            $filesystem->dumpFile($directory . '/' . $filename, $file_content);
        }

        unset($this->current_state);

        return $this;
    }

    /**
     * 
     * @param type $filepattern
     * @param type $dir
     * @param type $excludepattern
     * @return \Awakenweb\Beverage\Beverage
     */
    public function add($filepattern, $dir, $excludepattern)
    {

        $finder = new Finder();
        $finder->files()
                ->ignoreUnreadableDirs()
                ->name($filepattern);

        if ($excludepattern) {
            $finder->notName($excludepattern);
        }

        foreach ($dir as $directory) {
            $finder->in($directory);
        }

        foreach ($finder as $matching_file) {
            $basename = $matching_file->getBasename();

            $this->current_state[$basename] = $matching_file->getContents();
        }

        return $this;
    }

}
