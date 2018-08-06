<?php
/* VERSION: 2.0.0
 * 
 * 
 */
class email_mod extends RR_Model {
	function email_mod() {
 		parent::__construct();	
        
 	}
    function send($from, $to, $subject, $body, $extra=array()){
        
        
        if(count(explode("@", $from))==2){            
            $from = $from_desc = $from;
        } else {
            $f         = $this->env->getEnv($from);
            $from      = $f->lang->{$this->Clang}->valor;
            $from_desc = $f->lang->{$this->Clang}->descripcion;
            $from_desc = utf8_decode($from_desc);
        };
       
        $html      = $this->view("email/template", array("body"=>$body, "extra"=>$extra));   
  
        $this->email->from($from, $from_desc);               
        $this->email->to($to); 
        
        if(!isset($extra['bcc_no'])) { 
            $this->email->bcc($from);
        }
        
        if(isset($extra["cc"]))  $this->email->cc($extra["cc"]); 
       
        $this->email->set_mailtype('html');         
        $this->email->subject($subject);
        $this->email->message($html);  
        $email = $this->email->send(); 
        #echo $this->email->print_debugger();
        #file_put_contents("emails.txt",$this->email->print_debugger());
        
        /*
        $this->email->from('"aportes@bisblick.org', 'Your Name');
        $this->email->to($to);
      //  $this->email->cc('construirweb@hotmail.com');
      //  $this->email->bcc('holadiegol@gmail.com');

        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');

        $this->email->send();

        echo $this->email->print_debugger();
                */
        return  $email;
    }
}
?>