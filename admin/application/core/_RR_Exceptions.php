<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class RR_Exceptions extends CI_Exceptions{
    
     function __construct(){
        parent::__construct();
        
    }

	public function show_error($heading, $message, $template = 'error_general', $status_code = 500){
        $logTitle = 'error';
        $ci =& get_instance();
        if (!$page = $ci->uri->uri_string()) {
            $page = 'home';
        }
        switch($status_code) {
            case 403: 
                $heading = 'Access Forbidden';
                $logTitle = ''; 
                break;
            case 404: 
                $heading = 'Page Not Found';
                $logTitle = '';
                break;
            case 503:
                $template = 'sistema_status'; 
                $logTitle = 'Mantenimiento';
                break;
        }
        log_message($logTitle, $status_code . ' ' . $heading . ' --> '. $page);
        return parent::show_error($heading, $message, $template, $status_code);
    }

}