<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);


class rr_auth {

	private $or_auth_prefs;

	public function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->config('auth', TRUE);
		$this->_set_auth_prefs();
	}


	public function loggedin(){

	   if(!get_session("id")){

		return false;

	   } else {

		return true;

	   };
	}


	private function _set_auth_prefs(){

		$this->or_auth_prefs = $this->CI->config->item('rr_auth_prefs','auth');
	}


}
