<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');



class institucional_mod extends RR_Model {

	public function __construct() {
		parent::__construct();
	}



	public function sendMessage(){
		$success = 'false';
		$config = array();

		$config[1] = array('field'=>'email', 'label'=>'Email', 'rules'=>'trim|required|valid_email');
		$config[2] = array('field'=>'nombre', 'label'=>'Nombre', 'rules'=>'trim|required');
		$config[3] = array('field'=>'apellido', 'label'=>'Apellido', 'rules'=>'trim|required');
		$config[4] = array('field'=>'message', 'label'=>'Mensaje', 'rules'=>'trim|required');

		$this->form_validation->set_rules($config);

		try {
			if($this->form_validation->run()==FALSE){
				$this->form_validation->set_error_delimiters('', '<br/>');
				$errors = validation_errors();
				throw new Exception($errors, 1);
			}

			$values = ['nombre'     => filter_input(INPUT_POST,'nombre'),
						 'apellido'  => filter_input(INPUT_POST,'apellido'),
						 'email'     => filter_input(INPUT_POST,'email'),
						 'tipo_form' => 'ctc',
						 'json'      => json_encode($_POST)
						];


			$insert = $this->db->insert('formularios', $values);

			if(!($insert) ){
				throw new Exception("Ha ocurrido un error por favor intente más tarde.",1);
			};





			$success = 'true';
            $responseType = 'function';
            $function     = 'appendFormMessagesModal';
            $messages     = $this->view('alerts/modal_alert',
            	['texto'=> "Mensaje enviado exitosamente",
            	 'title'=>'Hablemos',
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

}
