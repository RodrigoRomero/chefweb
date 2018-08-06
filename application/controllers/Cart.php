<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends RR_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('cart_mod','Cart');
		//$this->load->model('eventos_mod','Evento');
		$this->load->library('cart');
	}

	public function add(){
		if ($this->input->method(TRUE) != 'POST'){
			echo show_404();
		}

   		$data = $this->Cart->add();
   		echo json_encode($data);
	}

	public function remove($rowid){
		$data = $this->Cart->update($rowid,0);
	 	echo json_encode($data);
	}


	public function index(){
		$this->page_title = "Resumen de tu pedido";

		if($this->cart->total_items() > 0) {

			$module = $this->view('cart/index');
		} else {
			$module = $this->view('cart/empty');
		}

		echo $this->show_main($module);
	}

	public function checkout(){
		if(!$this->auth->loggedin()){
			redirect(base_url('/ingresar'));
		}

		$module = $this->view('cart/checkout');
		echo $this->show_main($module);
	}

	public function finish(){


		$data = $this->Cart->finish();
   		echo json_encode($data);
	}
	public function payments(){
		$data = $this->Cart->setPayment();
	 	echo json_encode($data);
	}

	public function thanks(){
		$this->page_title = "Gracias por tu Pedido";
		$this->cart->destroy();
		$module = $this->view('cart/thanks');
		echo $this->show_main($module);
	}



	public function restore($salt){
		$this->layout = 'layout/multi_page';
		$this->cart->destroy();
		$data = $this->Cart->abandonment($salt);
		$module = $this->view('cart/abandonment');
		echo $this->show_main($module);
	}


	public function process(){
		$this->load->model('checkout_mod','Checkout');

		if(get_session('cart_medio_pago',false) == 'mercado_pago'){
			$order_id = get_Session('cart_id',false);
			$total    = $this->cart->total();
			$barcode  = getBarCode($order_id);

			$values = ['id' => $order_id, 'total'=> $total, 'barcode'=>$barcode['barcode']];

			$data  = $this->Checkout->getPreferences($values);
			echo json_encode($data);
		}




	}

	public function addExtras(){
		$data = $this->Cart->addExtras();
		echo json_encode($data);
	}


	/*

	public function index(){
		$this->cart->destroy();
	   $this->session->sess_destroy();
		redirect(lang_url());
		die;
	}




	public function checkout($security=null){
		$this->layout = 'multi_page';
		$this->css_view = array('bootstrap.min2','site/main');
		if($security){
			$lateCheckout = $this->_latecheckout($security);
		}
		if($this->cart->total_items()==0 && is_null($security)){
			redirect(lang_url());
		} else if($lateCheckout['payment_status'] == 'approved' || $lateCheckout['payment_status'] == 'free'  || $lateCheckout['payment_status'] == 'pending'){
			$this->_show($lateCheckout['module']);
			die;
		}
		$evento = $this->Evento->getEvento();
		$data = array('cupons_enabled'   => $evento->cupons_enabled,
					  'payments_enabled' => $evento->payments_enabled,
					  'cupon'            => ($this->session->userdata('cart_cupon')) ? $this->session->userdata('cart_cupon') : '');
		$this->layout = 'multi_page';
		$module = $this->view('pagos/checkout', $data);
		$this->_show($module);
	}

	private function _latecheckout($security){
		return $this->Cart->restoreCart($security);
	}

	public function gateways(){
		$this->css_view = array('bootstrap.min2','site/main');
		if($this->cart->total_items()==0){
			redirect(lang_url());
		}
		$evento = $this->Evento->getEvento();
		$data = array('cupons_enabled'   => $evento->cupons_enabled,
					  'payments_enabled' => $evento->payments_enabled,
					  'gateway'          => ($this->session->userdata('cart_medio_pago')) ? $this->session->userdata('cart_medio_pago') : ''  );
		$this->layout = 'multi_page';
		$module = $this->view('pagos/gateways', $data);
		$this->_show($module);
	}

	public function finish(){
		$this->css_view = array('bootstrap.min2','site/main');
		if($this->cart->total_items()==0){
		 redirect(lang_url());
		}
		$evento = $this->Evento->getEvento();
		$data = array('cupons_enabled'   => $evento->cupons_enabled,
					  'payments_enabled' => $evento->payments_enabled,
					  'order_details'    => $this->Cart->getOrderById()
					  );
		$this->layout = 'multi_page';
		$module = $this->view('pagos/finish', $data);
		$this->cart->destroy();
		$this->session->unset_userdata('cart_medio_pago');
		$this->session->unset_userdata('cart_order');
		$this->session->unset_userdata('cart_cupon');
		$this->session->unset_userdata('cart_salt');
		$this->_show($module);
	}



	public function do_gateway(){
		$data = $this->Cart->set_gateway();
		echo json_encode($data);
	}

	private function _show($module){
		echo $this->show_main($module);
	}
	*/

}
