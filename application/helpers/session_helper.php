<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
*
* @author Rodrigo Romero
* @version 1.0.0
* @description Guarda el valor enviado por params para una session
* @access public
* @param $id Tratamiento de la session
* @param $value Valor
* @param $system TRUE/FALSE
*/

function set_session($id, $value, $system=true){

	$CI    =& get_instance();
	$data  = array();
	$id    = strtolower($id);

	if($system){
		$data[config_item('site_pref')."system_".$id] = $value;
	}else{
		$data[config_item('site_pref')."usr_".$id]    = $value;
	}
	$CI->session->set_userdata($data);
}



/**
*
* @author Rodrigo Romero
* @version 1.0.0
* @description Recupera el valor establecido para una session
* @access public
* @param $id Tratamiento de la session
* @param $system TRUE/FALSE
* @return Valor de la session requerida
*/

function get_session($id, $system=true){

	$CI    =& get_instance();
	$id    = strtolower($id);
	if($system){
		$session = $CI->session->userdata(config_item('site_pref')."system_".$id);
		return $session;
	}else{
		$session = $CI->session->userdata(config_item('site_pref')."usr_".$id);
		return $session;
	}

}
