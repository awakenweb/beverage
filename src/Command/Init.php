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

class Init extends Command
{

    protected function configure()
    {
        $this
                ->setName('init')
                ->setDescription('Create boilerplate drinkmenu file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fs = new \Symfony\Component\Filesystem\Filesystem();

        $boilerplate = "<?php

use Awakenweb\Beverage\Beverage;


function defaultTask(){
    
}";

        $fs->dumpFile('./drinkmenu.php', $boilerplate);
    }

}
