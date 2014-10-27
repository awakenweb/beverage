<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Awakenweb\Beverage\Command;

use BadFunctionCallException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class Run extends Command
{

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('beverage:run')
            ->setDescription('Run all tasks')
            ->addArgument(
                'tasks', InputArgument::OPTIONAL | InputArgument::IS_ARRAY, 'list of tasks to run specifically'
            )
        ;
    }

    /**
     *
     * @param  InputInterface            $input
     * @param  OutputInterface           $output
     * @return type
     * @throws FileNotFoundException
     * @throws BadFunctionCallException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $drinks = $input->getArgument('tasks');

            if (empty($drinks)) {
                defaultTask($output);

                return;
            }

            foreach ($drinks as $task) {
                if (!function_exists($task)) {
                    throw new BadFunctionCallException("Undefined task '$task'");
                }
                $task($output);
            }
        } catch (\Exception $ex) {
            $output->writeln('<error>Execution has been interrupted by an error :</error>');
            $output->writeln('<error>' . $ex->getMessage() . '</error>');
        }
    }

}
