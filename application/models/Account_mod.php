<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 2.0.0
 *
 */


class account_mod extends RR_Model {
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
		$this->load->model('phpmailer_mod', 'Email');
	}

	public function create(){
		$success = 'false';
		$config = array();

		$config[1] = array('field'=>'email', 'label'=>'Email', 'rules'=>'trim|required|valid_email|is_unique[customers.email]');
		$config[2] = array('field'=>'nombre', 'label'=>'Nombre', 'rules'=>'trim|required');
		$config[3] = array('field'=>'apellido', 'label'=>'Apellido', 'rules'=>'trim|required');
		$config[4] = array('field'=>'password', 'label'=>'Password', 'rules'=>'trim|required');

		$this->form_validation->set_rules($config);

		try {
			if($this->form_validation->run()==FALSE){
				$this->form_validation->set_error_delimiters('', '<br/>');
				$errors = validation_errors();
				throw new Exception($errors, 1);
			}

			$customer = ['nombre' => filter_input(INPUT_POST,'nombre'),
						 'apellido' => filter_input(INPUT_POST,'apellido'),
						 'email' => filter_input(INPUT_POST,'email'),
						 'password' => md5(filter_input(INPUT_POST,'password')),
						 'newsletter' => 1
						];

			$values  = array_merge($customer, $this->i);
			$insert = $this->db->insert('customers', $values);


			if($insert){

				$subject    = "Hamburguesas Veganas : Cuenta Creada Exitosamente";
        		$body       = $this->view('email/welcome', ['customer'=>$customer]);
        		$email      = $this->Email->send('email_info', $customer['email'], $subject, $body);

        		if(!$email){
        			throw new Exception("Se ha producido un error por favor intente mas tarde.",1);
        		}

				$success = 'true';
	            $responseType = 'function';
	            $function     = 'appendFormMessagesModal';
	            $messages     = $this->view('alerts/modal_alert',
	            	['texto'=> "Sus datos han sido registrados exitosamente",
	            	 'title'=>'Registro de Usuarios',
	            	 'class_type'=>'error']);
	            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function, 'modal_redirect'=>base_url('/carrito/detalle'));
			}

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


	public function update($id){
		$success = 'false';
		$config = array();
		$config[1] = array('field'=>'empresa', 'label'=>'Empresa', 'rules'=>'trim|required');
		$config[2] = array('field'=>'cargo', 'label'=>'Cargo', 'rules'=>'trim|required');
		$config[3] = array('field'=>'email', 'label'=>'Email', 'rules'=>'trim|required|valid_email');
		$config[4] = array('field'=>'nombre', 'label'=>'Nombre', 'rules'=>'trim|required');
		$config[5] = array('field'=>'apellido', 'label'=>'Apellido', 'rules'=>'trim|required');

		$this->form_validation->set_rules($config);

		try {
			if($this->form_validation->run()==FALSE){
				$this->form_validation->set_error_delimiters('', '<br/>');
				$errors = validation_errors();
				throw new Exception($errors, 1);
			}

			$newsletter = (filter_input(INPUT_POST,'newsletter') == 'on') ? 1 : 0;
			$fecha_nacimiento = explode("-", filter_input(INPUT_POST,'fecha_nacimiento'));
			$fecha_nacimiento = $fecha_nacimiento[2].'-'.$fecha_nacimiento[1].'-'.$fecha_nacimiento[0];

			$customer = ['empresa' => filter_input(INPUT_POST,'empresa'),
						 'cargo' => filter_input(INPUT_POST,'cargo'),
						 'nombre' => filter_input(INPUT_POST,'nombre'),
						 'apellido' => filter_input(INPUT_POST,'apellido'),
						 'email' => filter_input(INPUT_POST,'email'),
						 'fecha_nacimiento' => empty($fecha_nacimiento) ? null : $fecha_nacimiento,
						 'dni' => filter_input(INPUT_POST,'dni'),
						 'telefono' => filter_input(INPUT_POST,'telefono'),
						 'conocio' => filter_input(INPUT_POST,'conocio'),
						 'newsletter' => $newsletter
						];


			$values  = array_merge($customer, $this->u);
			$this->db->where('id', $id);
			$update = $this->db->update('customers', $values);
			if($update){
				$success = 'true';
	            $responseType = 'function';
	            $function     = 'appendFormMessagesModal';
	            $messages     = $this->view('alerts/modal_alert',
	            	['texto'=> "Su cuenta ha sido actualizada exitosamente",
	            	 'title'=>'Registro de Usuarios',
	            	 'class_type'=>'error']);
	            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);
			}



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


	public function do_reset(){
		$success = 'false';
		$config = array();

		$config[1] = array('field'=>'email', 'label'=>'Email', 'rules'=>'trim|required|valid_email');

		$this->form_validation->set_rules($config);

		try {
			if($this->form_validation->run()==FALSE){
				$this->form_validation->set_error_delimiters('', '<br/>');
				$errors = validation_errors();
				throw new Exception($errors, 1);
			}

			$email = filter_input(INPUT_POST,'email');
			$customer = $this->_getCustomerByEmail($email);
			if(empty($customer) ){
				throw new Exception("No se registran usuarios con el mail indicado.",1);
			};

			$reset = ['email' => $customer->email,
					  'token' => md5('reset_'.$customer->id.$this->today)
					  ];

			$insert = $this->db->insert('password_reset', $reset);


			if($insert){

				$subject    = "Solicitud Recuperación Contraseña";
        		$body       = $this->view('email/restore', ['customer'=>$customer->nombre.' '.$customer->apellido, 'token'=>$reset['token']]);
        		$email      = $this->Email->send('email_info', 'rodrigo.romero@vnstudios.com', $subject, $body);

        		if(!$email){
        			throw new Exception("Se ha producido un error por favor intente mas tarde.",1);
        		}

				$success = 'true';
	            $responseType = 'function';
	            $function     = 'appendFormMessagesModal';
	            $messages     = $this->view('alerts/modal_alert',
	            	['texto'=> "Recuperación Exitosa.<br/>Se ha enviado un email a su casilla para completar el proceso.<br/>Por favor verifique la casilla de SPAM.",
	            	 'title'=>'Recuperar Contraseña',
	            	 'class_type'=>'error']);
	            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function, 'modal_redirect'=>base_url('/'));
			}



		} catch (Exception $error) {
			$error_code_id = $error->getCode();
			$message = $this->error_codes[$error_code_id];

			$success = 'false';
            $responseType = 'function';
            $function     = 'appendFormMessagesModal';
            $messages     = $this->view('alerts/modal_alert',
            	['texto'=> $error->getMessage(),
            	 'title'=>'Recordar Contraseña',
            	 'class_type'=>'error']);
            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);

		}

		return $data;

	}

	public function do_newPassword(){
		$success = 'false';
		$config = array();

		$config[1] = array('field'=>'hash', 'label'=>'Validación', 'rules'=>'trim|required');
		$config[2] = array('field'=>'password', 'label'=>'Password', 'rules'=>'trim|required');

		$this->form_validation->set_rules($config);

		try {
			if($this->form_validation->run()==FALSE){
				$this->form_validation->set_error_delimiters('', '<br/>');
				$errors = validation_errors();
				throw new Exception($errors, 1);
			}

			$hash = filter_input(INPUT_POST,'hash');
			$customer = $this->_getCustomerByPasswordReset($hash);

			$value = ['password' => md5(filter_input(INPUT_POST,'password'))];

			$values  = array_merge($value, $this->u);
			$this->db->where('id', $customer->id);
			$update = $this->db->update('customers', $values);

			if(!$update){
				throw new Exception("Se ha producido un error por favor intente mas tarde.",1);
			}

			$delete_hash = $this->db->delete('password_reset', ['id'=>$customer->reset_id]);

			if(!$delete_hash){
				throw new Exception("Se ha producido un error por favor intente mas tarde.",1);
			}

			$success = 'true';
            $responseType = 'function';
            $function     = 'appendFormMessagesModal';
            $messages     = $this->view('alerts/modal_alert',
            	['texto'=> "Su contraseña ha sido actualizada exitosamente.",
            	 'title'=>'Recordar Contraseña',
            	 'class_type'=>'error']);
            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function, 'modal_redirect'=>base_url('/ingresar'), 'extra'=>$hash);




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
	public function validPasswordResetHash($hash){
		$is_valid = false;
		$hash_exists = $this->db->get_where('password_reset',['token'=>$hash])->num_rows();

		if($hash_exists){
			$is_valid = true;
		}


		return $is_valid;
	}

	private function _getCustomerByPasswordReset($hash){

		$customer = $this->db->select('customers.*, password_reset.id reset_id, password_reset.token')->join('customers', 'password_reset.email = customers.email')->get_where('password_reset',['token'=>$hash])->row();

		return $customer;

	}

	public function getCustomerById(){
		$customer = $this->db->get_where('customers', ['id'=>get_session('id', false)])->row();

		return $customer;
	}


	private function _getCustomerByEmail($email){
		$customer = $this->db->get_where('customers', ['email'=>$email])->row();

		return $customer;
	}



	public function getOrdersByCustomerById(){



			$sql = 'SELECT o.id, o.total_price, o.discount_amount, o.total_discounted_price, o.status, p.status payment_status, ot.qty
					  FROM orders o
					  LEFT JOIN (SELECT SUM(quantity) qty, order_id FROM order_productos GROUP BY order_id) ot ON ot.order_id = o.id
					  LEFT JOIN pagos p ON p.order_id = o.id
					  WHERE o.customer_id = ?
					  ORDER BY o.id DESC';

	        $orders = $this->db->query($sql, [get_session('id', false)])->result();





     	return $orders;

	}

	public function getTicketsByOrderId($id){
		$tickets = $this->db->select('ot.*, t.nombre')
						    ->from('order_tickets ot')
						    ->where('ot.order_id', $id)
						    ->join('tickets t', 't.id = ot.ticket_id','INNER')
						    ->get()
						    ->result();
		return $tickets;
	}

	public function nominar(){
		$success = 'false';
		$config = array();
		$config[1] = array('field'=>'email', 'label'=>'Email', 'rules'=>'trim|required|valid_email');
		$config[2] = array('field'=>'nombre', 'label'=>'Nombre', 'rules'=>'trim|required');
		$config[3] = array('field'=>'apellido', 'label'=>'Apellido', 'rules'=>'trim|required');


		$this->form_validation->set_rules($config);

		try {


			if($this->form_validation->run()==FALSE){
				$this->form_validation->set_error_delimiters('', '<br/>');
				$errors = validation_errors();
				throw new Exception($errors, 1);
			}

			$ot  = filter_input(INPUT_POST,'ot_id');
			$row = filter_input(INPUT_POST,'row');

			if(!$ot || !$row){
				throw new Exception("Por favor intentelo mas tarde", 1);
			}



			#BUSCO SI ESTA NOMINADA Y LE ELIMINO
			$invitado_temp = $this->db->get_where('acreditados',['order_ticket_id'=>$ot, 'row'=>$row])->row();

			if(!empty($invitado_temp)){
				$this->db->delete('acreditados', array('id' => $invitado_temp->id));
			}

			$ot = $this->db->get_where('order_tickets', ['id'=>$ot])->row();


			$invitado = ['nombre'   	   => filter_input(INPUT_POST,'nombre'),
						 'apellido' 	   => filter_input(INPUT_POST,'apellido'),
						 'email'    	   => filter_input(INPUT_POST,'email'),
						 'row'	    	   => filter_input(INPUT_POST,'row'),
						 'order_id' 	   => $ot->order_id,
						 'evento_id'       => $ot->evento_id,
						 'order_ticket_id' => $ot->id,
						 'customer_id'     => $ot->customer_id

						];

			$values  = array_merge($invitado, $this->i);
			$insert = $this->db->insert('acreditados', $values);
			$inserted_id = $this->db->insert_id();
			$codeGenerated = getBarCode($inserted_id);
			$this->barcode->save($codeGenerated['barcode'],$codeGenerated['numbers']);

			$this->db->where('id', $inserted_id);
			$this->db->update('acreditados', ['barcode'=>$codeGenerated['barcode']]);

			if($insert){
				$success = 'false';
	            $responseType = 'function';
	            $function     = 'enableInvite';
	            $messages     = $this->view('alerts/modal_alert',
	            	['texto'=> "Nominación realizada exitosamente<br/>No olvide enviar la invitación correspondiente",
	            	 'title'=>'Invitación',
	            	 'class_type'=>'error']);
	            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function, 'extras'=>['data' => $inserted_id, 'row'=>$ot->ticket_id.$row]);
			}



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

	public function nominarOnTheFly($nombre, $apellido, $email,$order_id,$evento_id,$order_ticket_id,$customer_id, $template_email){

		$invitado = ['nombre'   	   => $nombre,
					 'apellido' 	   => $apellido,
					 'email'    	   => $email,
					 'row'	    	   => 1,
					 'order_id' 	   => $order_id,
					 'evento_id'       => $evento_id,
					 'order_ticket_id' => $order_ticket_id,
					 'customer_id'     => $customer_id,
					 'invitacion'	   => 1
					];

			$values  = array_merge($invitado, $this->i);
			$insert = $this->db->insert('acreditados', $values);
			$inserted_id = $this->db->insert_id();
			$codeGenerated = getBarCode($inserted_id);
			$this->barcode->save($codeGenerated['barcode'],$codeGenerated['numbers']);

			$this->db->where('id', $inserted_id);
			$this->db->update('acreditados', ['barcode'=>$codeGenerated['barcode']]);

			$acreditado = $this->db->get_where('acreditados', ['id'=>$inserted_id])->row();

			if($insert){
				$subject    = "Su Acreditación - ".$this->evento->nombre;
            	$body       = $this->view('email/'.$template_email, array('user_info'=>$acreditado, 'evento'=>$this->evento));
            	$email      = $this->Email->send('email_info', $acreditado->email, $subject, $body);

			}

	}


	public function sendInvite(){

		try {
			$id = $this->uri->segment(3);
			if(!($id)){
				throw new Exception("Por favor intentelo mas tarde", 1);
			}


			$acreditado = $this->db->get_where('acreditados', ['id'=>$id])->row();
			if(!($acreditado)){
				throw new Exception("Por favor intentelo mas tarde", 1);
			}
			#EVNITO LA INVITACION
			$subject    = "Su Acreditación - ".$this->evento->nombre;
            $body       = $this->view('email/invitaciones', array('user_info'=>$acreditado, 'evento'=>$this->evento));
            $email      = $this->Email->send('email_info', $acreditado->email, $subject, $body);

            if(!$email){
            	throw new Exception("Por favor intentelo mas tarde", 1);
            }

            $this->db->where('id', $acreditado->id);
            $upd = $this->db->update('acreditados', ['invitacion'=>1]);

            if(!$upd){
            	throw new Exception("Por favor intentelo mas tarde", 1);
            }

            $success = 'true';
        	$responseType = 'function';
            $function     = 'appendFormMessagesModal';
            $messages     = $this->view('alerts/modal_alert',
            	['texto'=> "Su invitación para ".$acreditado->nombre.' '.$acreditado->apellido." ha sido enviada exitosamente",
            	 'title'=>'Registro de Usuarios',
            	 'class_type'=>'error']);
            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);



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

		public function getOrderById($id){
		try {


			$order_cart = $this->db->get_where('orders',['id'=>$id, 'customer_id'=>get_session('id', false) ])->row();


			if(empty($order_cart)){
				throw new Exception("Orden Inválida",1);
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

		return $order_cart;

	}



}
