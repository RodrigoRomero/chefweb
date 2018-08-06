<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cupons extends RR_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('cupons_mod','Cupons');
	}


	public function validate_cupon($c=""){
        $data = $this->Cupons->validate_cupon($c);
        echo json_encode($data);
    }

}
