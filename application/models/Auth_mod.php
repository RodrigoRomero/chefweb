<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);


class Auth_mod extends RR_Model {


	private $zt_auth_prefs;
	private $max_login_attempts;

	public function __construct() {
		parent::__construct();
		$this->load->config('auth', TRUE);
		$this->_set_auth_prefs();
		$this->_setLoginAttempts();
	}


	/**
	 * @description Realiza el loguedo del usuario, guardando en session sus preferencias
	 * @return array
	 */


	public function do_login(){

		#VALIDO FORM POR PHP
		$success = 'false';
		$config = array();
		$config[1] = array('field'=>'username', 'label'=>'Usuario', 'rules'=>'trim|required');
		$config[2] = array('field'=>'password', 'label'=>'Contrasena', 'rules'=>'trim|required|md5');

		$this->form_validation->set_rules($config);

		try {
			if($this->form_validation->run()==FALSE){
				$this->form_validation->set_error_delimiters('', '<br/>');
				$errors = validation_errors();
				throw new Exception($errors, 1);
			}

			$table = 'customers';
			$user      = $this->input->post('username',true);
			$password  = $this->input->post('password',true);

			$customer = $this->db->get_where($table,array('email'=>$user,'password'=>$password,'status'=>1))->row();
			if(!$customer){
				throw new Exception("Usuario o Password incorrectos, por favor verifique los datos e intentelo nuevamente",1);
			}

			set_session("id", $customer->id, false);
			set_session("empresa", $customer->empresa, false);
			set_session("nombre", $customer->nombre, false);
			set_session("apellido", $customer->apellido, false);
			set_session("email", $customer->email, false);

			$success = true;
			$responseType = 'redirect';
			$data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>'comesfrom');

		} catch (Exception $error) {
			$error_code_id = $error->getCode();
			$message = $this->error_codes[$error_code_id];

			$success = 'false';
            $responseType = 'function';
            $function     = 'appendFormMessagesModal';
            $messages     = $this->view('alerts/modal_alert',
            	['texto'=> $error->getMessage(),
            	 'title'=>'Cupones',
            	 'class_type'=>'error']);
            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);

		}

		return $data;
	}



	public function do_logout(){
		$this->load->library('cart');
		$this->cart->destroy();
		foreach($this->session->userdata as $key=>$value){
			$name = explode("usr_", $key);
			if (count($name)==2){
				$this->session->unset_userdata($key);
			}
	   }
	}


	private function _set_auth_prefs(){
		$this->zt_auth_prefs = $this->config->item('zt_auth_prefs','auth');
	}



	private function _setLoginAttempts(){
		$tmp_max_login_attempts = $this->env->getEnv('login_attemps');
		if(!empty($tmp_max_login_attempts)){
			$this->max_login_attempts = $tmp_max_login_attempts;
		} else {
			$this->max_login_attempts = $this->zt_auth_prefs['max_login_attempts'];
		}

	}





}
