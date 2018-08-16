<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends RR_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$module = $this->view('home/index',
										[
										 'mas_vendidos'   => $this->getMasVendidos(4)
										 //'oradores' => $this->getOradores(),
										 //'sponsors' => $this->getSponsors(),
										 //'lugar'    => $this->getLugar(),
										 //'tickets'  => $this->getProductos(),
										]
							);

		echo $this->show_main($module);

	}

	public function evento(){
		$module = $this->view('evento/detail');

		echo $this->show_main($module);
	}

	public function getMasVendidos($limit){
		$module = $this->view('products/mas_vendidos', ['mas_vendidos' => $this->Productos->masVendidos($limit)]);
		return $module;
	}

	/*public function getLugar(){

		$module = $this->view('evento/lugar',['lugar' => $this->Main->getLugar()]);
		return $module;
	}

	public function getSlider(){
		$module = $this->view('evento/slider', ['evento' => $this->evento]);
		return $module;
	}

	public function getOradores(){
		$module = $this->view('evento/oradores', ['oradores' => $this->Main->getOradores()]);
		return $module;

	}

	public function getSponsors(){
		$module = $this->view('evento/sponsors', ['sponsors' => $this->Main->getSponsors()]);
		return $module;
	}

	public function getProductos(){
		$module = $this->view('evento/tickets', ['tickets' => $this->productos_mod->getProductos()]);
		return $module;
	}

	public function speaker($id){
		$speaker = $this->Main->getOradorById($id);
		$this->load->view('evento/speaker-detail', ['orador' => $speaker]);
	}*/
}
