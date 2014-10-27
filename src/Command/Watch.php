<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Awakenweb\Beverage\Command;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class Watch extends Command
{

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('beverage:watch')
            ->setDescription('Launch the watch task')
        ;
    }

    /**
     *
     * @param  InputInterface        $input
     * @param  OutputInterface       $output
     * @throws FileNotFoundException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {

            $output->writeln('<comment>Watcher started running. Ctrl/Cmd + C to quit</comment>');
            watch($output);
        } catch (Exception $ex) {
            $output->writeln('<error>Execution has been interrupted by an error :</error>');
            $output->writeln('<error>' . $ex->getMessage() . '</error>');
        }
    }

}
