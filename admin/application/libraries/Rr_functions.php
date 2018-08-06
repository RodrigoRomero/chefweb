<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author		Rodrigo Romero
 * @version     1.0.0
 */

class RR_Functions{
    
    public function arrayToObject($d) {
    	if (is_array($d)) {
    		return (object) array_map($this->arrayToObject, $d);
    	} else {
    		return $d;
    	}
    }
    
    function convert_array_to_obj_recursive($a) {
        if (is_array($a) ) {
            foreach($a as $k => $v) {
              
                    $a[$k] = $this->convert_array_to_obj_recursive($v);
                
            }
    
            return (object) $a;
        }
    
        // else maintain the type of $a
        return $a; 
    }
    
}