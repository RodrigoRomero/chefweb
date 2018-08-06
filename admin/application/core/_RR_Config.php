<?php
/**
 * @author Rodrigo Romero
 * @version 1.0.0
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class RR_Config extends CI_Config {
    function RR_Config(){
        parent::__construct();
        $this->load('language');
    }
}