<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tickets extends RR_Controller {
	public function __construct(){
		parent::__construct();
		$this->layout = 'layout/multi_page';

	}

	public function index($security=null){
		$module = $this->view('accounts/index');
		echo $this->show_main($module);
	}


}
