<div class="box span12">
<?php echo $this->view('layout/panels/box_header', array('title'=>'Inversores', 'icon'=>'icon-pencil')) ?>
<div class="box-content">
<?php $this->view('alerts/error') ?>
<?php
$upd_pass     = ($this->params['iu']=='update') ? array('readonly'=>true) : array();
$default_pass = ($this->params['iu']=='new') ? array('onblur'=>'defaultPass($(this))') : array();
$checked = ($row->status==1) ? array('checked'=>true) : array();
?>

<div class="row-fluid">
    <div class="box span6">
        <?php echo $this->view('layout/panels/box_header', array('title'=>'Datos Personales', 'icon'=>'icon-pencil')) ?>
        <div class="box-content">
            <div class="form_container">
<?php
$data = array ('id'=>'inversoresForm', 'class'=>'form-horizontal');
echo form_open($action,$data);

$data = array('name'=>'nombre','id'=>'nombre','placeholder'=>'Nombre', 'class'=>'required input-xlarge', 'value'=>$row->nombre);
echo control_group('Nombre', form_input($data),$attr = array());

$data = array('name'=>'apellido','id'=>'apellido','placeholder'=>'Apellido', 'class'=>'required input-xlarge', 'value'=>$row->apellido);
echo control_group('Apellido', form_input($data),$attr = array());

$html = form_input(array('class'=>'datepicker fecha_nacimiento input-small', 'data-date'=>date('d/m/Y'), 'value'=>getFechaView($row->fecha_nacimiento), 'name'=>'fecha_nacimiento'));
echo control_group('Fecha Nacimiento:', $html, $attr = array());
            
$html = frm_multiples_radio($generos,array('name'=>'sexo_id'), $row->sexo_id);                
echo control_group('Género', $html,$attr = array());
            
$data = array('name'=>'dni','id'=>'dni','placeholder'=>'DNI', 'class'=>'required input-xlarge', 'value'=>$row->dni);
echo control_group('DNI', form_input($data+$default_pass),$attr = array('help-inline'=>'(Será el usuario para ingresar al sistema)'));

$data = array('name'=>'email','id'=>'email','placeholder'=>'Email', 'class'=>'required email input-xlarge', 'value'=>$row->email);
echo control_group('Email', form_input($data),$attr = array());

$data = array('name'=>'password','id'=>'password','placeholder'=>'Password', 'class'=>'password input-xlarge', 'value'=>$row->password, 'type'=>'password');
echo control_group('Password', form_input($data+$upd_pass),$attr = array());

$data = array('name'=>'valid_password','id'=>'valid_password','placeholder'=>'Repetir Password', 'class'=>'valid_password input-xlarge', 'value'=>$row->password, 'type'=>'password');
echo control_group('Repetir Password', form_input($data+$upd_pass),$attr = array());

$data = array('name'=>'observaciones','id'=>'observaciones_generales', 'class'=>'input-xlarge', 'value'=>$row->observaciones);
echo control_group('Observaciones Generales<span style="height:75px"></span>', form_textarea($data),$attr = array('help-block'=>'(Notas internas, el inversor nunca verá esta información)'),'observaciones_generales');
 
 
$data = array('name'=>'status','id'=>'status', 'class'=>'', 'type'=>'checkbox');
echo control_group('Status', form_input($data+$checked),$attr = array());


?>
            </div>
        </div>
    </div>
    <div class="box span6">
        <?php echo $this->view('layout/panels/box_header', array('title'=>'Datos Manager & Proyectos', 'icon'=>'icon-pencil')) ?>
        <div class="box-content">
            <div class="form_container">
                <?php
                    echo control_group('Manager', frm_select('',array('name'=>'manager_id', 'class'=>'input-xlarge'),$managers, $row->manager_id,"",false,array(),"","Seleccionar Manager"),$attr = array('class'=>''));

                    $data = array('class'=>'proyectos multitransfer', 'required'=>false);
                    echo control_group('Asigna Proyectos<span style="height:189px"></span>', frm_select_multi_trasfer($proyectos, 'proyectos', $data, $row->proyectos_id),$attr = array('class_controls'=>'clearfix', 'class'=>'input_group'));
                    
                    $data = array('name'=>'numero_inversor','id'=>'numero_inversor','placeholder'=>'Número Inversor', 'class'=>'required input-xlarge', 'value'=>$row->numero_inversor);
                    echo control_group('Número Inversor', form_input($data),$attr = array());
                ?>
            </div>
        </div>
    
    </div>
</div>
<?php

$buttons = '';

$buttons .= '<span class="">';
$data = array('type'=>'submit', 'value'=>'Guardar', 'class'=>'btn btn-primary', 'onclick'=>"validateForm('inversoresForm')", 'style' =>'margin-right: 10px');
$buttons .= form_input($data);
$buttons .= anchor($back,'Cancelar',array('class'=>'btn btn-inverse'));
$buttons .= '</span>'; 
echo form_action($buttons);

echo form_close();

?>
</div>
</div>