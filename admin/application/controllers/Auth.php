<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth extends RR_Controller {

	public function __construct(){
		parent::__construct();
		$this->layout = 'login';
		$this->css_view = array('admin/orsonia.login');
		$this->widget_view = array('validate'=>array('js'=>array('jquery.validate','messages_es')));
		$this->load->model("auth_mod","Auth");
		//$this->output->enable_profiler(TRUE);
	   //
	}

	public function index(){


	}

	public function login(){
		 $module =	$this->view('auth/login');
		 $this->_show($module);
	}

	public function do_login(){
		/*
		$arg_list = func_get_args();
		$redirect = implode("/", $arg_list);
		if(empty($redirect))
			$redirect = "";
		  */
		$return = $this->Auth->do_login();
		echo json_encode($return);
	}

	public function logout(){
		$this->Auth->do_logout();
		redirect(lang_url());
	}

	private function _show($module){
		echo $this->show_main($module);
	}
}
