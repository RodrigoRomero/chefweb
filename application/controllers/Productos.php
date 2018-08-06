<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Productos extends RR_Controller {

	public function __construct(){
		parent::__construct();


	}

	public function index(){
		$module = $this->view('products/index',
										['productos'  => $this->getProductos()
										]
							);

		echo $this->show_main($module);

	}


	public function getProductById($id){

		$producto = $this->productos_mod->getProductoById($id);
		$mas_vendidos =  $this->productos_mod->getMasVendidos($id);

		$this->setMeta('title',$producto->nombre);
		$this->setMeta('description', $producto->bajada);

		if(!$producto){
			echo show_404();
		}

		$module = $this->view('products/product-detail', [
				'producto' => $producto,
				'relacionados' => $mas_vendidos
			]);

		$this->page_title = $producto->nombre;
		echo $this->show_main($module);
	}


	public function getProductos(){
		$module = $this->view('products/products', ['productos' => $this->productos_mod->getProductos()]);
		return $module;
	}


}
