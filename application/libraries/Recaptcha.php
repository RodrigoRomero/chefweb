<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);


class Recaptcha {
	private $recaptcha;


	public function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->config('Recaptcha');
		$this->recaptcha =  $this->CI->config->item('recaptcha');
	}


	public function validate($g_response){
		$recaptcha = new \ReCaptcha\ReCaptcha($this->recaptcha['secret']);
		$resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])->verify($g_response, $_SERVER['REMOTE_ADDR']);

		return $resp->isSuccess();
	}

}
