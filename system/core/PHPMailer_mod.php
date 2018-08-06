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
		$this->email->SMTPDebug = 4;
		$this->email->Host = 'email-smtp.us-east-1.amazonaws.com';
		$this->email->Port = 465;
		$this->email->SMTPAutoTLS = true;
		$this->email->SMTPSecure = true;
		$this->email->SMTPAuth = true;
		$this->email->Username = 'AKIAIBUSL26APKSM6A3A';
		$this->email->Password = 'As283IXESSt1x+IczXMNhTNBsWWDmQgk1a8I+AZbZ5gl';
	

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
