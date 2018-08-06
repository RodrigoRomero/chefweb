<?php
/* VERSION: 2.0.0
 *
 *
 */

class email_mod extends RR_Model {

	function __construct() {
		parent::__construct();
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

		$this->email->from($from, $from_desc);
		$this->email->to($to);

		if(!isset($extra['bcc_no'])) {
			$this->email->bcc($from);
		}

		if(isset($extra["cc"]))  $this->email->cc($extra["cc"]);
		$this->email->set_mailtype('html');
		$this->email->subject($subject);
		$this->email->message($html);
		return $this->email->send();
	}

}

?>
