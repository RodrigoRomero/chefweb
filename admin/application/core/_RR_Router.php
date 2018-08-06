<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class RR_Router extends CI_Router {
 
    function RR_Router(){
        parent::__construct();
    }
 
    function _validate_request($segments){
 
        //Permitir - en nombre function
        $segments = str_replace('-','_',$segments);
        // Does the requested controller exist in the root folder?
        if (count($segments)>0 && file_exists(APPPATH.'controllers/'.$segments[0].EXT)){
            return $segments;
        }
 
        // Is the controller in a sub-folder?
        if (count($segments)>0 && is_dir(APPPATH.'controllers/'.$segments[0]))
        {
            // Set the directory and remove it from the segment array
            $this->set_directory($segments[0]);
            $segments = array_slice($segments, 1);
 
            if (count($segments) > 0)
            {
                // Does the requested controller exist in the sub-folder?
                if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$segments[0].EXT))
                {
                    show_404($this->fetch_directory().$segments[0]);
                }
            }
            else
            {
                $this->set_class($this->default_controller);
                $this->set_method('index');
 
                // Does the default controller exist in the sub-folder?
                if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$this->default_controller.EXT))
                {
                    $this->directory = '';
                    return array();
                }
 
            }
 
            return $segments;
        }
 
        // Can't find the requested controller...
        if(count($segments)>0)
        show_404($segments[0]);
    }
 
}