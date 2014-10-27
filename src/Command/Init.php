<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Awakenweb\Beverage\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class Init extends Command
{
    protected function configure()
    {
        $this
            ->setName('beverage:init')
            ->setDescription('Create boilerplate drinkmenu file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fs = new Filesystem();

        $boilerplate = "<?php

/**
 * Import the modules you need.
 * All official available modules are listed on the Github repository of the project
 */
use Awakenweb\Beverage\Beverage;
use Awakenweb\Beverage\Modules\Css;
use Awakenweb\Beverage\Watcher;
use Awakenweb\BeverageScss\Scss; // this one is an optional module


/**
 * This init function allows you to add custom commands to the Beverage CLI tool
 * Simply add the full name of your command class (including namespace)
 * Your class should extend the Symfony\Component\Console\Command\Command class
 */
function register_custom_commands(){
    return [];
}


/**
 * The defaultTask is mandatory, as it is automatically called when no arguments
 * or command are provided to the Beverage CLI tool
 *
 * -----------------------------------------------------------------------------
 *
 * You can either use it as a standard task, or reuse already defined tasks in
 * it. If you want a task to be executed prior to another one, simply call it
 * before.
 */
function defaultTask()
{
    compileScssAndMinifyCss();
}

/**
 * This is a task. You create a task simply by creating a nammed function
 */
function compileScssAndMinifyCss()
{
    // Select the files you want to process.
    // Then define a module that will process these files. If a module requires
    // some configuration, you can pass it to the constructor.
    // Finally, define where you want to save the result
    Beverage::files('*.scss', ['scss'])
        ->then(new Scss('scss', Scss::USE_COMPASS, Scss::NESTED))
        ->then(new Css())
        ->destination('build/css');
}

/**
 * By adding \$output to your task, you gain access to writing to the CLI
 *
 * -----------------------------------------------------------------------------
 *
 * If you intend to use the watch command, create a task called watch that
 * accepts the \$output parameter and passes it to the run function.
 * Else, you can use the watch task as any other task
 */
function watch(\$output)
{
    // Create a watcher and define the files you want to watch and
    // the tasks that will be triggered on change
    // Then, launch the watcher
    (new Watcher(\$output))
        ->watch('*.scss', ['compileScssAndMinifyCss'], ['scss'])
        ->run();
}
";

        $fs->dumpFile('./drinkmenu.php', $boilerplate);
    }
}
