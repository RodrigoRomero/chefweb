<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);


class Checkout_mod extends RR_Model {

 	var $id;
    var $codeBar;
    private $payment_enabled;
    private $cupons_enabled;
    private $evento_name;

	public function __construct() {
		parent::__construct();

		$this->load->config('mp', TRUE);
        $mp_config = $this->config->item('mp');

        $this->load->library('mp', $mp_config);
        #$this->mp->sandbox_mode(TRUE);
        $this->load->model('email_mod','Email');

	}





    public function getPreferences($values){


        $preference = array("items" => array(
                                             array("title"        => $this->evento->nombre,
                                                   "quantity"     => (int)1,
                                                   "currency_id"  => "ARS",
                                                   "unit_price"   => (int)$values['total'],
                                                   "picture_url"  => image_asset_url('logo_mp.jpg'),
                                                   "id"           => $values['id']
                                                   )
                                             ),

                           "payment_methods" => array('excluded_payment_types' => array (
                                                                                         array("id" => "debit_card"),
                                                                                         array("id" => "ticket" ),
                                                                                         array("id" => "bank_transfer"),
                                                                                         array("id" => "atm" )
                                                                                         ),
                                                       'installments' => 1
                                                      ),
                           "external_reference" => $values['id'].'-'.$values['barcode']
                           );

        $preferenceResult = $this->mp->create_preference($preference);
        $success      = true;
        $responseType = 'function';
        $function     = 'paymentLink';
        #$messages     = $preferenceResult['response']['sandbox_init_point'];
        $messages     = $preferenceResult['response']['init_point'];
        $data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function);
        return $data;
    }


	public function mp(){
		#Status 1 - Pago Acreditado
		#Status 2 - Pago Pendiente Acreditacion
		#Status 3 - Pago Rechazado
		#Status 0 - Pago NO Procesado
		/*
		#pending 	El usuario no completó el proceso de pago.
		#approved 	El pago fue aprobado y acreditado.
		#in_process 	El pago esta siendo revisado.
		#rejected 	El pago fue rechazado. El usuario puede intentar nuevamente.
		cancelled 	El pago fue cancelado por superar el tiempo necesario para realizar el pago o por una de las partes.
		refunded 	El pago fue devuelto al usuario.
		in_mediation 	Se inicio una disputa para el pago.
		* http://demo.omgeventos.com.ar/evento/payments/close/
		* id/41-0000000000413/
		* collection_id/1458191868/
		* collection_status/approved/
		* payment_type/credit_card/
		* preference_id/139398783-f15e9fed-d8d2-4895-b882-33b752144e86
		*/

		$id_barcode = explode("-", $this->params['id']);
		$id         = $id_barcode[0];
		$barcode    = $id_barcode[1];

		$order_info    = $this->db->get_where('orders',array('id'=>$id))->row();
		$customer_info = $this->db->get_where('customers',array('id'=>$order_info->customer_id))->row();

		$success = false;
		if($this->params['collection_id'] != 'null'){
			$payment_info = $this->mp->get_payment_info($this->params['collection_id']);



			$update  = array('collection_id'       => $payment_info['response']['collection']['id'],
							 'collection_status'   => $payment_info['response']['collection']['status'],
							'preference_id'       => $this->params['preference_id'],
							'currency_id'         => $payment_info['response']['collection']['currency_id'],
							'transaction_amount'  => $payment_info['response']['collection']['transaction_amount'],
							'payment_type'        => $payment_info['response']['collection']['payment_type'],
							'order_id'            => $payment_info['response']['collection']['order_id'],
							'status'              => $payment_info['response']['collection']['status_detail']
							);

			$this->db->where('order_id',$order_info->id);
			$query = $this->db->update('pagos',$update);

			if(!$query){

			} else {
				switch($payment_info['response']['collection']['status']){
					case 'approved':
					case 'accredited':
						$template =  'pago_ok';
						$subject    = "Acreditacion ".$this->evento_name;
						#ACTUALIZO PAGO STATUS
						$this->db->where('order_id',$order_info->id);
						$this->db->update('pagos', array('pago_status'=>$payment_info['response']['collection']['status']));

						$this->db->where('id',$order_info->id);
						$this->db->update('orders', array('status'=>1));

						$body    = $this->view('email/'.$template, array('user_info'=>$customer_info, 'datos'=>$payment_info,  'evento'=>$this->evento));

						$autonominar_ticket = false;
						$autonominar_lunch = false;

						$sql1 = "SELECT ot.*, t.tipo FROM order_tickets ot LEFT JOIN tickets t ON ot.`ticket_id` = t.`id` WHERE ot.order_id = ? AND t.tipo = ?";
						$find_tickets = $this->db->query($sql1,[$order_info->id, 1]);
						$total_rows = $find_tickets->num_rows();

						if(count($total_rows == 1)){
							$tid = $find_tickets->row();
							$is_nominated = $this->db->get_where('acreditados', ['order_ticket_id'=>$tid->id])->num_rows();
							if($tid->quantity == 1 && $is_nominated == 0){
								$autonominar_ticket = true;
							}

						}

						$find_tickets = $this->db->query($sql1,[$order_info->id, 2]);
						$total_rows = $find_tickets->num_rows();

						if(count($total_rows == 1)){
							$lid = $find_tickets->row();
							$is_nominated = $this->db->get_where('acreditados', ['order_ticket_id'=>$lid->id])->num_rows();
							if($lid->quantity == 1 && $is_nominated == 0){
								$autonominar_lunch = true;
							}

						}

						if($autonominar_ticket == true){
							//ACA TENDRÍA QUE NOMINAR Y ENVIAR EL EMAIL
							$this->load->model('account_mod','Account');
							$this->Account->nominarOnTheFly($customer_info->nombre, $customer_info->apellido,$customer_info->email,$tid->order_id,$tid->evento_id,$tid->id,$customer_info->id, 'invitaciones');
						}

						if($autonominar_lunch ==true){
							$this->load->model('account_mod','Account');
							$this->Account->nominarOnTheFly($customer_info->nombre, $customer_info->apellido,$customer_info->email,$lid->order_id,$lid->evento_id,$lid->id,$customer_info->id, 'almuerzo');
						}

					break;

					default:
						case 'in_process':
						case 'pending':
						case 'pending_contingency':
						#ACTUALIZO PAGO STATUS
						$this->db->where('order_id',$order_info->id);
						$this->db->update('pagos', array('pago_status'=>$payment_info['response']['collection']['status']));

						$this->db->where('id',$order_info->id);
						$this->db->update('orders', array('status'=>2));


						$subject    = "PreAcreditación ".$this->evento_name;
						$template   = 'pago_pendiente';

						$body    = $this->view('email/'.$template, array('user_info'=>$customer_info, 'datos'=>$payment_info,  'evento'=>$this->evento));










					break;

					case 'cancelled':
					case 'rejected':
					case 'cc_rejected_other_reason':
						#ACTUALIZO PAGO STATUS
						#ACTUALIZO PAGO STATUS
						$this->db->where('order_id',$order_info->id);
						$this->db->update('pagos', array('pago_status'=>$payment_info['response']['collection']['status']));

						$this->db->where('id',$order_info->id);
						$this->db->update('orders', array('status'=>3));



						$subject    = "Tarjeta Rechazada ".$this->evento_name;
						$template   = 'pago_rechazado';

						$body    = $this->view('email/'.$template, array('user_info'=>$customer_info, 'order_info'=>$order_info, 'datos'=>$payment_info,  'evento'=>$this->evento));
					break;
				}
				$email  = $this->Email->send('email_info', $customer_info->email, $subject, $body, array());
			}
		} else {
			$subject    = "Completar Pago ".$this->evento_name;
			$template   = 'pago_no_procesado';

			$body       = $this->view('email/'.$template, array('user_info'=>$customer_info, 'order_info'=>$order_info, 'evento'=>$this->evento));
			$email   = $this->Email->send('email_info', $customer_info->email, $subject, $body, array());

			$this->db->where('order_id',$order_info->id);
			$query = $this->db->update('pagos', array('status'=>'pending', 'preference_id'=>$this->params['preference_id'], 'pago_status'=>2 ));








		}

		if($query) {
			$success      = true;
			$responseType = 'redirect';
			$data         = array('success' =>$success, 'responseType'=>$responseType, 'value'=>base_url('cart/thanks'));
		}
		return $data;
	}



}
