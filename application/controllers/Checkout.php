<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkout extends RR_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("checkout_mod","Checkout");
	}

	public function index(){}

	public function login(){
		$return = $this->Auth->do_login();
		echo json_encode($return);
	}

	public function close(){
		$return = $this->Checkout->mp();
        echo json_encode($return);
	}

}
