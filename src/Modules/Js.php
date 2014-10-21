<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Awakenweb\Beverage\Modules;

use MatthiasMullie\Minify;

class Js implements Module
{

    /**
     * @param array $current_state
     * 
     * @return array updated_state
     */
    public function process(array $current_state)
    {
        $minifier      = new Minify\Js();
        $updated_state = [];

        foreach ($current_state as $filename => $content) {
            $minifier->add($content);
        }

        $updated_state['all.min.js'] = $minifier->minify();

        return $updated_state;
    }

}
