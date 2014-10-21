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

function defaultTask()
{
    minifyCss();
    minifyJs();
}

function minifyCss()
{
    Beverage::files('*.css', ['css'])
            ->then(['Awakenweb\Beverage\Modules\Css', 'process'])
            ->destination('build/css');
}

function minifyJs()
{
    Beverage::files('*.js', ['js'])
            ->then(['Awakenweb\Beverage\Modules\Js', 'process'])
            ->destination('build/js');
}";

        $fs->dumpFile('./drinkmenu.php', $boilerplate);
    }

}
