<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 2.0.0
 *
 */



class cart_mod extends RR_Model {
	#private $payment_enabled;
	#private $cupons_enabled;

	private $error_codes = [
		1 => 'Sku inválido',
		2 => 'Missing Customer',
		3 => 'Missing Discount Code',
		4 => 'Code Not Exists',
		5 => 'Missing Price Rule',
		6 => 'Not Valid Customer - Cupon Applies Customers Created Before a Date',
		7 => 'Products in cart are not valid for this order',
		8 => 'Discount Code Expired',
		9 => 'Discount Code Not Started Yet',
		10 => 'Discount Code Usage Limit Reached',
		11 => 'Discount Code has already been used',
		12 => 'Customer Not in Saved Search',
		13 => 'Discount Code Minimun Amount Requerid',
		14 => 'Missing Allocation Method',
		15 => 'Missing Shipping Line',
		16 => 'Not Valid Customer - Cupon Applies Customers 1st Purchase'
	];

	public function __construct() {
		parent::__construct();
	    $this->load->model('account_mod','Account');
	    $this->load->model('phpmailer_mod','Email');
	    $this->load->model('cupons_mod','Cupons');
	    $this->load->model('checkout_mod','Checkout');

		$this->load->library('cart');

		/*echo '<pre>';
		print_r($this->cart->contents());
		echo '</pre>';
*/
	}


	public function add($modal=true) {
		//$this->cart->destroy();
		$options = [];
		$sku   = filter_input(INPUT_POST,'sku');
		$qty   = filter_input(INPUT_POST,'quantity');

		try{
			if(empty($qty) || $qty == 0 ){
				throw new Exception("Por favor seleccione la cantidad de productos deseados.",1);
			};

			if(empty($sku)){
				throw new Exception("Se ha producido un error al agregar al carrito, por favor intentelo nuevamente mas tarde.",1);
			};

			$producto = $this->validateSKU($sku);
			if($producto == null){
				throw new Exception("Se ha producido un error al agregar al carrito, por favor intentelo nuevamente mas tarde.",1);
			};

			if($producto->agotadas){
				throw new Exception("Se ha producido un error al agregar al carrito, por favor intentelo nuevamente mas tarde.",1);
			}


			$options['product_id'] = $producto->id;

			$price = (float)$this->getPrice($producto);

			$product = array(
				   'id'      => $sku,
				   'qty'     => $qty,
				   'price'   => $price,
				   'name'    => $producto->nombre,
				   'options' => $options
				);

			$cart_product_id = $this->cart->insert($product);

			//print_r($this->cart->total_items());



			$msg_modal = "Producto agregado correctamente a tu  carrito.";

			if($cart_product_id){
				if($modal){
					$success = 'true';
            		$responseType = 'function';
		            $function     = 'appendFormMessagesModal';
		            $messages     = $this->view('alerts/modal_alert',
		            	['texto'	=> $msg_modal,
		            	 'title'	=> "Tu Carrito",
		            	 'link' 	=> base_url('carrito/detalle'),
		            	 'class_type'=>'error']);
		            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function, 'items'=>$this->cart->total_items());

				} else {
					return $cart_product_id;
				}
			} else {
				throw new Exception("Se ha producido un error al agregar al carrito, por favor intentelo nuevamente mas tarde.",1);
			}

		}
		catch(Exception $error)
		{

			$error_code_id = $error->getCode();
			$message = $this->error_codes[$error_code_id];

			$success = 'false';
            $responseType = 'function';
            $function     = 'appendFormMessagesModal';
            $messages     = $this->view('alerts/modal_alert',
            	['texto'=> $error->getMessage(),
            	 'title'=> $this->evento->nombre,
            	 'class_type'=>'error']);
            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);


			#TODO LOG
			/*
			$error_code_id = $error->getCode();
			$message = $this->error_codes[$error_code_id];
			$success      = true;
			$responseType = 'function';
			$function     = 'showNotify';
			$components   = ['position'=> 'bottom-full-width', 'type'=> 'error', 'message'=>$error->getMessage(), 'time'=>5000, 'close'=>true];
			$data = array('success' =>$success,'responseType'=>$responseType, 'response'=>$components, 'value'=>$function);
			*/

		}

		return $data;


	}

	public function update($rowId, $value){
		//ep($this->cart->contents());

		//VERIFICO SI ESE TKT TIENE UN CUPON VINCULADO
		foreach ($this->cart->contents() as $key => $row) {
			if(preg_match('/^code/', $row['id'], $matches) === 1){
				$item = $this->cart->product_options($rowId);

				if($row['options']['plan_id'] == $item['ticket_id']){
					$this->cart->remove($row['rowid']);
				}



			}

		}

		//die;

		$data = array(
				'rowid' => $rowId,
				'qty'   => $value,
			);




		if($this->cart->update($data) && count($this->cart->contents())>0){
			$success     = true;
			$responseType = 'function';
			$function = 'reloadCart';
			$html = ['fullcart' => $this->view('cart/detail', ['delete'=>true]),
					 'resume'	=> $this->view('cart/resume'),
					 'payments' => $this->view('cart/gateways',['proceedToCheckout' => true, 'show_options' => true])
					 ];
			$data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$html,  'value'=>$function);

		} else {
			$success     = true;
			$responseType = 'redirect';
			$url     = base_url();

			$data = array('success' =>$success,'responseType'=>$responseType, 'value'=>$url);
		}
		 return $data;

	}


	private function getPrice($producto){
		$current_date = strtotime($this->today);


		if(strtotime($producto->fecha_baja) >= strtotime("+1 day", $current_date)){
			return $producto->precio_oferta;
		} else {
			return $producto->precio_regular;
		}

	}

	private function validateSKU($sku){
		return $this->db->get_where('productos',array('sku'=>$sku))->row();
	}

	public function setPayment(){


		$success = 'false';
		$config = array();
		$config[1] = array('field'=>'medio_pago', 'label'=>'Medio de Pago', 'rules'=>'trim|required');

		$this->form_validation->set_rules($config);

		try {
			if($this->form_validation->run()==FALSE){
				$this->form_validation->set_error_delimiters('', '<br/>');
				$errors = validation_errors();
				throw new Exception($errors, 1);
			}

			$medio_pago = filter_input(INPUT_POST,'medio_pago');
			set_session('cart_medio_pago',$medio_pago, false);
			$success = true;
			$responseType = 'redirect';
			$data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>base_url('cart/checkout'));

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

	public function finish(){
		if(!$this->auth->loggedin()){
			$success = true;
			$responseType = 'redirect';
			$data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>base_url('/ingresar'));
		} else {
			try {
				#GENERO LA ORDEN
				#
				$productos = [];
				$quantity = 0;
				$ticket_id = 0;

				$discount_code = [];
				$discount_amount = 0;

				$item_price = 0;
				$nominar = 0;

				$total_price = 0;
				$total_places = 0;

				foreach ($this->cart->contents() as $key => $row) {
					if(preg_match('/^code/', $row['id'], $matches) === 1){
						array_push($discount_code, $row);
						$discount_amount += $row['subtotal'];

					}  else {

					array_push($productos, ['quantity' => $row['qty'],  'product_price'=>$row['price'], 'product_id' =>  $row['options']['product_id'], 'customer_id' => get_session('id', false)]);
						$total_price = $total_price + ($row['qty']*$row['price']);
					}
				}


				$values = ['customer_id' 		    => get_session('id', false),
						   'total_price'  		    => $total_price,
	            		   'discount_amount'  	    => $discount_amount,
	        		 	   'total_discounted_price' => $this->cart->total(),
						   'gateway'                => 'Efectivo',
						   'full_cart'        	    => json_encode($this->cart->contents()),
						   'status'				    => 1,
						 ];


			    $this->db->trans_start();
				#GENERO LA ORDEN
				$values = array_merge($values, $this->i);
	          	$this->db->insert('orders',$values);
	          	$order_id = $this->db->insert_id();
	          	$codeGenerated = getBarCode($order_id);

	          	#GUARDO EL SECURITY
	          	$this->db->where('id',$order_id);
	          	$this->db->update('orders',array('salt'=>md5($codeGenerated['barcode'])));

	          	#BAJO LOS CUPONES PARA QUE NO SE PUEDAN USAR DE NUEVO
				$c = [];
	          	foreach($discount_code as $used_code){
	          		$discount = $this->Cupons->downCupons($used_code['options']['code'], $used_code['options']['plan_id'] );
	          		array_push($c, ['order_id'=>$order_id, 'discount_code'=>$discount->code, 'discount_id' =>$discount->id, 'discounted_amount' => $used_code['subtotal']]);
	          	}

	          	foreach($productos as $k=>$product){
	          		$productos[$k] = array_merge($product, ['order_id' => $order_id]);
	          	}

	          	#GUARDO LOS TICKETS Y LOS CUPONES
	          	if(!empty($c)) {
	          		$order_cupons  = $this->db->insert_batch('order_discounts', $c);
	          	}
	          	$order_products = $this->db->insert_batch('order_productos', $productos);

	      	 	#GENERO EL PAYMENT TRANSACTION -1 SIN REGISTRO
	          	$payment = array(
		            'order_id'            => $order_id,
		            'payment_type'        => 'Efectivo',
		            'transaction_amount'  => $this->cart->total(),
		            'currency_id'         => 'ARS',
		            'pago_status'         => 1,
		            'status'              => 'in_progress',
		          );
		        $order_payment = $this->db->insert('pagos',$payment);
		        $this->db->trans_complete();

		        if ($this->db->trans_status() === FALSE)
				{
					throw new Exception("Error Procesando la Orden", 1);

				}

				$subject    = "Pedido #".$order_id." Ingresado Correctamente";
				$customer   = $this->Account->getCustomerById();
				$order = (object)$values;
		    	$body  = $this->view('email/invoice', array('user_info'=>$customer, 'order'=>$order, 'id' => $order_id));
		    	$email = $this->Email->send('email_info', $customer->email, $subject, $body, array('bcc'=>'me+nuevaorden@rodrigoromero.life'));




		  		$success = true;
				$responseType = 'redirect';
				$data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>base_url('cart/thanks'));


		        /*switch($values['gateway']){
		        	case 'transferencia_bancaria':
		        		$subject    = "PreAcreditación ".$this->evento->nombre;
		        		$customer   = $this->Account->getCustomerById();
		        		$order = (object)$values;
	                	$body  = $this->view('email/transferencia_bancaria', array('user_info'=>$customer, 'evento'=>$this->evento, 'order_id'=>$order_id));
	                	$email = $this->Email->send('email_info', $customer->email, $subject, $body, array('cc'=>$customer->email));
			      		$success = true;
						$responseType = 'redirect';
						$data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>base_url('cart/thanks'));
		        		break;

		        	case 'mercado_pago':
		        		$mp = ['total' => round($this->cart->total()),
		        				'id' => $order_id,
		        				'barcode' =>$codeGenerated['barcode']  ];
		        		$data = $this->Checkout->getPreferences($mp);

		        		break;

		        	case 'pago_mis_cuentas':
		        		#TODO
		        		break;
	        		case 'foc':
		        		$subject    = "Acreditación ".$this->evento->nombre;
		        		$customer   = $this->Account->getCustomerById();
		        		$order = (object)$values;
	                	$body  = $this->view('email/pago_ok', array('user_info'=>$customer, 'evento'=>$this->evento, 'order_id'=>$order_id));
	                	$email = $this->Email->send('email_info', $customer->email, $subject, $body, array('cc'=>$customer->email));
			      		$success = true;
						$responseType = 'redirect';
						$data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>base_url('cart/thanks'));
		        		break;
		        }*/


			} catch (Exception $error) {
				$error_code_id = $error->getCode();
				$message = $this->error_codes[$error_code_id];

				$success = 'false';
	            $responseType = 'function';
	            $function     = 'appendFormMessagesModal';
	            $messages     = $this->view('alerts/modal_alert',
	            	['texto'=> $error->getMessage(),
	            	 'title'=>'Orden Error',
	            	 'class_type'=>'error']);
	            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);


			}
		}
		return $data;
	}

	public function addCupon($c,$ammount,$description, $qty, $plan_id){
		$data = array(
				   'id'      => 'code_'.$c,
				   'qty'     => $qty,
				   'price'   => $ammount,
				   'name'    => $description,
				   'options' => array('code'=>$c, 'plan_id'=>$plan_id)
				);
		return $this->cart->insert($data);
	}


	public function abandonment($salt){
		try {


			$order_cart = $this->db->get_where('orders',['salt'=>$salt])->row();


			if(empty($order_cart)){
				throw new Exception("Security Code Inválido",1);
			}




			if($order_cart->evento_id != $this->evento->id){
				throw new Exception("Evento no vigente",1);
			}

			$customer = $this->db->get_where('customers', ['id' =>$order_cart->customer_id])->row();


			if(empty($customer)){
				throw new Exception("No se pudo recuperar customer",1);
			}

			set_session("id", $customer->id, false);
			set_session("empresa", $customer->empresa, false);
			set_session("nombre", $customer->nombre, false);
			set_session("apellido", $customer->apellido, false);
			set_session("email", $customer->email, false);
			set_session("cart_medio_pago", $order_cart->gateway, false);
			set_session("cart_id", $order_cart->id, false);
			$cart = json_decode($order_cart->full_cart, true);

			foreach($cart as $product_in_cart){
				unset($product_in_cart['rowid']);
				$add = $this->cart->insert($product_in_cart);
			}

		} catch (Exception $error) {

			$error_code_id = $error->getCode();
			$message = $this->error_codes[$error_code_id];

			$success = 'false';
            $responseType = 'function';
            $function     = 'appendFormMessagesModal';
            $messages     = $this->view('alerts/modal_alert',
            	['texto'=> $error->getMessage(),
            	 'title'=>'Carrito Error',
            	 'class_type'=>'error']);
            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);


		}

	}






	public function addExtras($sku='',$name='',$price='',$qty='', $modal=true) {
		//$this->cart->destroy();
		$options = [];

		$name  = ($name) ? $name : filter_input(INPUT_POST,'ticket_name');
		$price = ($price) ? $price : filter_input(INPUT_POST,'ticket_ammount');



		try{
			$qty   =  ($qty) ? $qty : filter_input(INPUT_POST,'quantity');
			if(empty($qty) || $qty == 0 ){
				throw new Exception("Por favor seleccione la cantidad de almuerzos deseados.",1);
			};

			$sku   = ($sku) ? $sku : filter_input(INPUT_POST,'sku');
			if(empty($sku)){
				throw new Exception("Se ha producido un error al agregar al carrito, por favor intentelo nuevamente mas tarde.",1);
			};

			$ticket = $this->validateSKU($sku);
			if($ticket == null){
				throw new Exception("Se ha producido un error al agregar al carrito, por favor intentelo nuevamente mas tarde.",1);
			};

			if($ticket->agotadas){
				throw new Exception("Se ha producido un error al agregar al carrito, por favor intentelo nuevamente mas tarde.",1);
			}


			if($ticket->min_qty == 0  && $ticket->max_qty == 0 ){
				$options['nominar'] = $qty;
				$options['packs'] = 'N/A';;
			} elseif($ticket->min_qty>0 && $ticket->max_qty == 0 ) {
				$options['nominar'] = $qty;
				$options['packs'] = $qty/$ticket->min_qty;

			} elseif($ticket->min_qty>0 && $ticket->max_qty > 0 ) {
				  $options['nominar'] = $qty;
				  $options['packs'] = 'N/A';
			}

			$options['extras']    = (!empty($ticket->descripcion)) ? $ticket->descripcion : '';
			$options['ticket_id'] = (!empty($ticket->id)) ? $ticket->id : '';
			$options['tipo']      = (!empty($ticket->tipo)) ? $ticket->tipo : 1;

			$price = (float)$this->getPrice($ticket);

			$product = array(
				   'id'      => $sku,
				   'qty'     => $qty,
				   'price'   => $price,
				   'name'    => $ticket->nombre,
				   'options' => $options
				);
			$update = false;
			foreach ($this->cart->contents() as $key => $value) {

				if($value['id'] == $product['id']){
					$update = true;
					$data = array(
					'rowid' => $value['rowid'],
					'qty'   => $product['qty'],
					);
				}

			}

			if($update == true){
				$cart_product_id = $this->cart->update($data);
			} else {
				$cart_product_id = $this->cart->insert($product);
			};
			//print_r($this->cart->total_items());


			if($qty > 1){
				$msg_modal = "Se han agregado $qty almuerzos a su carrito.";
			} else {
				$msg_modal = "Se ha agregado $qty almuerzo a su carrito.";
			}
			if($cart_product_id){
				$success     = true;
			$responseType = 'function';
			$function = 'reloadCart';
			$html = ['fullcart' => $this->view('cart/detail', ['delete'=>true]),
					 'resume'	=> $this->view('cart/resume'),
					 'payments' => $this->view('cart/gateways',['proceedToCheckout' => true, 'show_options' => true])
					 ];
			$data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$html,  'value'=>$function);
				/*
				if($modal){
					$success = 'true';
            		$responseType = 'function';
		            $function     = 'appendFormMessagesModal';
		            $messages     = $this->view('alerts/modal_alert',
		            	['texto'	=> $msg_modal,
		            	 'title'	=> $this->evento->nombre,
		            	 'link' 	=> base_url('cart'),
		            	 'class_type'=>'error']);
		            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);

				} else {
					return $cart_product_id;
				}
				*/
			} else {
				throw new Exception("Se ha producido un error al agregar al carrito, por favor intentelo nuevamente mas tarde.",1);
			}

		}
		catch(Exception $error)
		{

			$error_code_id = $error->getCode();
			$message = $this->error_codes[$error_code_id];

			$success = 'false';
            $responseType = 'function';
            $function     = 'appendFormMessagesModal';
            $messages     = $this->view('alerts/modal_alert',
            	['texto'=> $error->getMessage(),
            	 'title'=> $this->evento->nombre,
            	 'class_type'=>'error']);
            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);


			#TODO LOG
			/*
			$error_code_id = $error->getCode();
			$message = $this->error_codes[$error_code_id];
			$success      = true;
			$responseType = 'function';
			$function     = 'showNotify';
			$components   = ['position'=> 'bottom-full-width', 'type'=> 'error', 'message'=>$error->getMessage(), 'time'=>5000, 'close'=>true];
			$data = array('success' =>$success,'responseType'=>$responseType, 'response'=>$components, 'value'=>$function);
			*/

		}

		return $data;


	}

/*




	public function add($sku='',$name='',$price='',$qty='', $modal=true){

		$options = [];
		$sku   = ($sku) ? $sku : filter_input(INPUT_POST,'ticket_sku');
		$name  = ($name) ? $name : filter_input(INPUT_POST,'ticket_name');
		$price = ($price) ? $price : filter_input(INPUT_POST,'ticket_ammount');
		$qty   =  ($qty) ? $qty : filter_input(INPUT_POST,'ticket_qty');
		$ticket = $this->validateSKU($sku);



		if($ticket->min_qty == 0  && $ticket->max_qty == 0 ){
			$options['nominar'] = $qty;
		} elseif($ticket->min_qty>0 && $ticket->max_qty == 0 ) {
			$options['nominar'] = $qty;
			$qty = $qty/$ticket->min_qty;

		} elseif($ticket->min_qty>0 && $ticket->max_qty > 0 ) {
			  $options['nominar'] = $qty;
		}


		if($ticket->precio_regular == $price || $ticket->precio_oferta == $price) {
			$options['extras'] = (!empty($ticket->descripcion)) ? $ticket->descripcion : '';
			$options['ticket_id'] = (!empty($ticket->id)) ? $ticket->id : '';

			$data = array(
				   'id'      => $sku,
				   'qty'     => $qty,
				   'price'   => (int)$price,
				   'name'    => $name,
				   'options' => $options
				);




			$cart_product_id = $this->cart->insert($data);

			if($cart_product_id){
				if($modal){
					$success = true;
					$responseType = 'function';
					$function     = 'appendFormMessagesModal';
					$messages     = $this->view('alerts/seleccion_entrada', array('ticket'=>$ticket->nombre, 'ammount'=>$price, 'title'=>$this->evento_name, 'class_type'=>'info'));
					$data = array('success' =>$success,'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function, 'modal_redirect'=>lang_url('cart/checkout'));
				} else {
					return $cart_product_id;
				}
			}
		} else {

		}

		return $data;
	}









	public function (){
		$almuerzo_sku    = filter_input(INPUT_POST,'ticket_sku');
		$almuerzo_nombre = filter_input(INPUT_POST,'ticket_name');
		$almuerzo_price  = filter_input(INPUT_POST,'ticket_ammount');

		$data = array(
				   'id'      => $almuerzo_sku,
				   'qty'     => 1,
				   'price'   => $almuerzo_price,
				   'name'    => $almuerzo_nombre,
				   'options' => array()
				);


		if($this->cart->insert($data)){
			$success     = true;
			$responseType = 'function';
			$function = 'reloadCart';
			$html = $this->view('pagos/cart', array('param'=>'checkout'));
			$data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$html,  'value'=>$function);
			return $data;
		}
	}



	public function restoreCart($security){


		$user = $this->db->select('o.*, p.status payment_status', false)
						 ->where('o.status =',1)
						 ->where('o.salt =',$security)
						 ->join('pagos p', 'p.order_id = o.id','LEFT')
						 ->from('orders o')
						 ->get();
		$values = $user->row();

		switch($values->payment_status){
			case 'approved':
				$module = $this->view('pagos/payment_status', array('user_info'=>$values, 'message'=>'Su Pago ya se encuentra acreditado'));
				break;

			case 'in progress':
			case 'in_process':
				$module = $this->view('pagos/payment_status', array('user_info'=>$values, 'message'=>'Su Pago se encuentra en proceso de revisi�n'));
				break;

			default:
				$this->cart->destroy();
				#ABRO EL CART
				$cart = json_decode($values->full_cart);

				#GUARDO EL SALT USUARIO
				$this->session->set_userdata('cart_id',$values->id);
				$this->session->set_userdata('cart_salt',$security);
				$this->session->set_userdata('cart_cupon',$values->discount_code);

				foreach ($cart as $key => $row) {
					unset($row->rowid);
					$this->cart->insert(json_decode(json_encode($row),true));
				}
				if($this->cart->contents()>0){
				   return true;
				}
				break;

		}



		return array('payment_status'=>$values->payment_status, 'module'=>$module);





	}


	public function getOrderById(){

		$this->db->select('o.*, p.*, c.*', false)
				 ->from('orders o')
				 ->where('o.id', $this->session->userdata('cart_order'))
				 ->join('pagos p', 'p.order_id = o.id','INNER')
				 ->join('customers c', 'c.id = o.customer_id','INNER');
		$order = $this->db->get()->row();


		return array('order'=>$order);
	}


	*/

}
