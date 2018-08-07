<?php
/* VERSION: 2.0.0
 *
 *
 */

class PHPMailer_mod extends RR_Model {
	private $config;
	private $CI;
	private $email;
	function __construct() {
		parent::__construct();
		$this->CI =& get_instance();
		$this->CI->load->config('phpmailer', TRUE);
		$this->prefs = $this->CI->config->item('phpmailer');

		$this->email = new \PHPMailer\PHPMailer\PHPMailer();
		$this->email->isSMTP();
		$this->email->SMTPDebug = 2;
		$this->email->Host = ''; //$this->prefs['smtp_host'];
		$this->email->Port = ; //$this->prefs['smtp_port'];
		//$this->email->SMTPAutoTLS = false;
		//$this->email->SMTSecure = true;
		$this->email->SMTPAuth = true; //$this->prefs['smtp_auth'];
		$this->email->Username = ''; //$this->prefs['smtp_user']; //'noreply@argentinavision2020.com';
		$this->email->Password = ''; //$this->prefs['smtp_pass']; //'\-":kSOW;(@Tq5';

	}



	function send($from, $to, $subject, $body, $extra=array()){
		if(count(explode("@", $from))==2){
			$from = $from_desc = $from;
		} else {
			$f         = $this->env->getEnv($from);
			$from      = $f->lang->{$this->Clang}->valor;
			$from_desc = $f->lang->{$this->Clang}->descripcion;
		};




		#$from = "info@argentinavision2020.com";
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
		$this->email->Subject = $subject;
		$this->email->msgHTML($html);
		return $this->email->send();

	}

}

?>
