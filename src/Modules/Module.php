<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Awakenweb\Beverage\Modules;

/**
 *
 * @author Mathieu
 */
interface Module
{

    /**
     * 
     * @param array $current_state
     * 
     * @return array updated_state
     */
    public function process(array $current_state);
}
