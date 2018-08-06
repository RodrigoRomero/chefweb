<?php
/* VERSION: 2.0.0
 *
 *
 */

class Email_mod extends RR_Model {
	private $config;
	private $CI;
	private $email;
	function __construct() {
		parent::__construct();
		//$this->CI =& get_instance();
		//$this->CI->load->config('phpmailer', TRUE);
		//$this->prefs = $this->CI->config->item('phpmailer');

		$this->email = new \PHPMailer\PHPMailer\PHPMailer();
		$this->email->isSMTP();
		//$this->email->SMTPDebug = 4;
		$this->email->Host = 'smtp.mailtrap.io';
		$this->email->Port = 25;
		$this->email->SMTPAutoTLS = true;
		$this->email->SMTPSecure = true;
		$this->email->SMTPAuth = true;
		$this->email->Username = '303f9b6c2d7d25';
		$this->email->Password = '47ff21661ed17e';


	}



	function send($from, $to, $subject, $body, $extra=array()){
		if(count(explode("@", $from))==2){
			$from = $from_desc = $from;
		} else {
			$f         = $this->env->getEnv($from);
			$from      = $f->lang->{$this->Clang}->valor;
			$from_desc = $f->lang->{$this->Clang}->descripcion;
		};


		$html      = $this->view("email/template", array("body"=>$body, "extra"=>$extra));

		#echo $from;
		#echo $html;

		$this->email->setFrom($from, $from_desc);
		$this->email->addAddress($to);

		/*if(!isset($extra['bcc_no'])) {
			$this->email->bcc($from);
		}*/

		//if(isset($extra["cc"]))  $this->email->cc($extra["cc"]);
		//$this->email->set_mailtype('html');
		$this->email->Subject = utf8_decode($subject);
		$this->email->msgHTML($html);
		return $this->email->send();

	}

}

?>
