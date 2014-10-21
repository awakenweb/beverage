<?php

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
}
