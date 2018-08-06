<?php

$data = array ('id'=>'loginform', 'class'=>'form-horizontal');
echo form_open('auth/do_login',$data); 


$data = array('name'=>'user','id'=>'user','placeholder'=>'Usuario', 'class'=>'input-large span12');
echo form_input($data);

$data = array('name'=>'password','id'=>'password','placeholder'=>'Password', 'class'=>'required input-large span12', 'type'=>'password');
echo form_input($data);



$data = array('type'=>'submit', 'value'=>'Login', 'class'=>'btn btn-primary span12', 'onclick'=>"validateLoginForm('loginform')");
echo form_input($data);


echo form_close();

?>