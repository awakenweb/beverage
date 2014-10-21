<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Awakenweb\Beverage\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class Run extends Command
{

    protected function configure()
    {
        $this
                ->setName('run')
                ->setDescription('Run all tasks')
                ->addArgument(
                        'tasks', InputArgument::OPTIONAL | InputArgument::IS_ARRAY, 'list of tasks to run specifically'
                )
                ->addOption(
                        'drinkmenu', 'd', InputOption::VALUE_REQUIRED, 'path to the "drinkmenu.php" file - default is current directory'
                )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = is_null($input->getOption('drinkmenu')) ? './drinkmenu.php' : $input->getOption('drinkmenu');
        try {
            if (!file_exists($filename)) {
                throw new FileNotFoundException('File ' . $filename . ' does not exist');
            }

            include($filename);

            $drinks = $input->getArgument('tasks');

            if (empty($drinks)) {
                defaultTask();
                return;
            }

            foreach ($drinks as $task) {
                $task();
            }
        } catch (\Exception $ex) {
            $output->writeln('<error>Execution has been interrupted by an error :</error>');
            $output->writeln('<error>' . $ex->getMessage() . '</error>');
        }
    }

}
