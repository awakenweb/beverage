<?php

use Awakenweb\Beverage\Beverage;
use Awakenweb\Beverage\Modules\Css;
use Awakenweb\Beverage\Modules\Js;

function defaultTask()
{
    minifyCss();
    minifyJs();
}

function minifyCss()
{
    Beverage::files('*.css', ['css'])
            ->then(new Css())
            ->destination('build/css');
}

function minifyJs()
{
    Beverage::files('*.js', ['js'])
            ->then(new Js())
            ->destination('build/js');
}
