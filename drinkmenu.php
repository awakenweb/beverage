<?php

/**
 * Import the modules you need.
 * All official available modules are listed on the Github repository of the project
 */
use Awakenweb\Beverage\Beverage;
use Awakenweb\Beverage\Modules\Css;
use Awakenweb\BeverageScss\Scss; // this one is an optional module
use Awakenweb\Beverage\Watcher;

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
 * By adding $output to your task, you gain access to writing to the CLI
 *
 * -----------------------------------------------------------------------------
 *
 * If you intend to use the watch command, create a task called watch that
 * accepts the $output parameter and passes it to the run function.
 * Else, you can use the watch task as any other task
 */
function watch($output)
{
    // Create a watcher and define the files you want to watch and
    // the tasks that will be triggered on change
    // Then, launch the watcher
    (new Watcher($output))
        ->watch('*.scss', ['compileScssAndMinifyCss'], ['scss'])
        ->run();
}
