<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Institucional extends RR_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('institucional_mod','Institucional');
	}


	public function contact() {
		$this->page_title = "Hablemos";
		$this->setMeta('title',"Hablemos");

		$module = $this->view('institucional/contact');
		echo $this->show_main($module);

	}

	public function sendMessage(){
		$data = $this->Institucional->sendMessage();
	 	echo json_encode($data);

	}

}
