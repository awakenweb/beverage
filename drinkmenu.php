<?php

use Awakenweb\Beverage\Beverage;

function defaultTask()
{
    Beverage::files('*.css', ['css']);
//        ->then($callbackname)
//        ->then($callbackname)
//        ->destination($directory);
}
