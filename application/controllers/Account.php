<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends RR_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('account_mod','Account');
	}

	/*public function index($security=null){
		$module = $this->view('accounts/index');
		echo $this->show_main($module);
	}*/

	public function login($security=null){
		$this->page_title = "Ingresar a mi cuenta";
		$module = $this->view('accounts/login');
		echo $this->show_main($module);
	}

	public function register(){
		$this->page_title = "Crea tu cuenta";
		$module = $this->view('accounts/crear-cuenta');
		echo $this->show_main($module);
	}

	public function testmail(){
		$this->Account->testMail();
	}



	public function summary(){
		if(!$this->auth->loggedin()){
			set_session("comesFrom", 'account/summary', false);
			redirect(base_url('/crear-cuenta'));
		}

		$data = ['customer' => $this->Account->getCustomerById(),
				 'orders'	=> $this->Account->getOrdersByCustomerById(),
			    ];

		$module = $this->view('accounts/summary', $data);
		echo $this->show_main($module);
	}

	public function profile(){
		if(!$this->auth->loggedin()){
			redirect(base_url('/crear-cuenta'));
		}

		$this->page_title = "Mi Perfil";
		$data = ['customer' => $this->Account->getCustomerById()
			    ];

		$module = $this->view('accounts/profile', $data);
		echo $this->show_main($module);
	}



	public function create(){
		$data = $this->Account->create();
	 	echo json_encode($data);
	}

	public function recordar(){
		$this->page_title = "Recuperar Contraseña";

		$module = $this->view('accounts/recordar_password');
		echo $this->show_main($module);
	}


	public function restore_passwrod($hash){
		if(!$this->Account->validPasswordResetHash($hash)){
			redirect(base_url('/'));
		}

		$module = $this->view('accounts/generar_password', ['hash'=>$hash]);
		echo $this->show_main($module);
	}


	public function reset(){
        if ($this->input->method(TRUE) != 'POST'){
            echo show_404();
        }

        $return = $this->Account->do_reset();
        echo json_encode($return);





		/*$this->load->model('PHPMailer_mod','PHPMailer');

		$html     = $this->view("email/restore");
		$mailtest = $this->PHPMailer->send('email_info', 'rodrigo.thepulg@gmail.com', 'TEST', $html);


		echo '<pre>';
		print_r($mailtest);
		echo '</pre>';

		die;*/

/*
		$email = new \PHPMailer\PHPMailer\PHPMailer();



		//Set who the message is to be sent from
		$email->setFrom('rodrigo.romero@vnstudios.com', 'First Last');
		//Set an alternative reply-to address
		$email->addReplyTo('replyto@example.com', 'First Last');
		//Set who the message is to be sent to
		$email->addAddress('webmaster@orsonia.com.ar', 'John Doe');
		//Set the subject line
		$email->Subject = 'PHPMailer sendmail test';
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$html      = $this->view("email/template", array("body"=>$body, "extra"=>$extra));
		$email->msgHTML($html);
		//Replace the plain text body with one created manually
		$email->AltBody = 'This is a plain-text message body';
		//Attach an image file
		//$mail->addAttachment('images/phpmailer_mini.png');
		//send the message, check for errors
		if (!$email->send()) {
		    echo "Mailer Error: " . $email->ErrorInfo;
		} else {
		    echo "Message sent!";
		}



		print_r($email);
		die;
	*/	//$data = $this->Account->restore();

	}


	public function setNewPassword(){
		 if ($this->input->method(TRUE) != 'POST'){
            echo show_404();
        }

        $return = $this->Account->do_newPassword();
        echo json_encode($return);


	}
	public function getOrderById($id){
		if(!$this->auth->loggedin()){
			redirect(base_url('/crear-cuenta'));
		}

		$data = [
					'order_info' => $this->Account->getOrderById($id)
				];

		$module = $this->view('accounts/order-details', $data);
		echo $this->show_main($module);
	}

	public function update($id){
		$data = $this->Account->update($id);
	 	echo json_encode($data);
	}

	public function nominate($order_id){
		$data = ['tickets' => $this->Account->getTicketsByOrderId($order_id)
				];

		$module = $this->view('accounts/nominate', $data);
		echo $this->show_main($module);
	}

	public function nominar($id, $row){
		$data = $this->Account->nominar();
	 	echo json_encode($data);
	}

	public function invite(){
		$data = $this->Account->sendInvite();
	 	echo json_encode($data);
	}
}
