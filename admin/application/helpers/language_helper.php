<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(E_ALL ^ E_NOTICE);



/**

*

* @author Rodrigo Romero

* @version 1.0.0

* @description

* @access public

*/



function lang($line, $replace=array(), $id = '', $param = '', $language = ''){

    $CI                   =& get_instance();
    $line                 = $CI->lang->line($line, $param, '', $language);
    $replace["site_name"] = $CI->env->getEnv("site_name");

    $line                 = replace_code($line, $replace);
    if ($id != ''){
        $line = '<label for="'.$id.'">'.$line."</label>";
    }

    return $line;

}



function lang_url($url=""){
    $params = explode("/", $url);
    $nurl   = array();

    foreach($params as $row){
        $nurl[] = url_title(convert_accented_characters((!empty($lang)) ? $lang : $row));
    }

    $url = implode("/", $nurl);
    $url = (config_item("language_show")) ? config_item("language")."/".$url : $url;
    return site_url($url);

}



function lang_change($lang){

    $CI =& get_instance();

    $segs = $CI->uri->segment_array();

    if(in_array($segs[1], config_item("languages"))){

        unset($segs[1]);

    }

    $url = implode("/", $segs);



    return site_url($lang."/".$url);

}
