<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends RR_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model("auth_mod","Auth");
    }

	public function index(){}

    public function login(){
        $return = $this->Auth->do_login();
        echo json_encode($return);
    }

    public function logout(){
        $this->Auth->do_logout();
		redirect(base_url());
    }




}
