<?php

namespace Awakenweb\Beverage;

use Symfony\Component\Console\Application;

/**
 * Description of Bootstrapper
 *
 * @author Administrateur
 */
class Bootstrapper
{

    public static function registerCommands(Application $application, array $commands)
    {
        foreach ($commands as $command) {
            $commandInstance = new $command();
            $application->add($commandInstance);
        }

        return $application;
    }

}
