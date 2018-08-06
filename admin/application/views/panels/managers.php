<div class="box span12">
<?php echo $this->view('layout/panels/box_header', array('title'=>'Inversores', 'icon'=>'icon-pencil')) ?>
<div class="box-content">
<?php $this->view('alerts/error') ?>
<?php
$checked = ($row->status==1) ? array('checked'=>true) : array();

$data = array ('id'=>'inversoresForm', 'class'=>'form-horizontal');
echo form_open($action,$data);

$data = array('name'=>'nombre','id'=>'nombre','placeholder'=>'Nombre', 'class'=>'required input-xlarge', 'value'=>$row->nombre);
echo control_group('Nombre', form_input($data),$attr = array());

$data = array('name'=>'apellido','id'=>'apellido','placeholder'=>'Apellido', 'class'=>'required input-xlarge', 'value'=>$row->apellido);
echo control_group('Apellido', form_input($data),$attr = array());
            
$data = array('name'=>'codigo','id'=>'codigo','placeholder'=>'Código', 'class'=>'required input-xlarge', 'value'=>$row->abr);
echo control_group('Código', form_input($data),$attr = array());

$data = array('name'=>'status','id'=>'status', 'class'=>'', 'type'=>'checkbox');
echo control_group('Status', form_input($data+$checked),$attr = array());

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