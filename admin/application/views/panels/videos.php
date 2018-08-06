<div class="box span12">
<?php echo $this->view('layout/panels/box_header', array('title'=>'Videos', 'icon'=>'icon-pencil')) ?>
<div class="box-content">
<?php $this->view('alerts/error') ?>
<?php
$data = array ('id'=>'videosForm', 'class'=>'form-horizontal');
echo form_open($action,$data);

echo control_group('Período', frm_select('',array('name'=>'periodo_id', 'class'=>'input-xlarge'),$periodos, $row->periodo_id,"",false,array(),"","Seleccionar Período"),$attr = array('class'=>''));

$data = array('name'=>'nombre','id'=>'nombre','placeholder'=>'Nombre', 'class'=>'required input-xlarge', 'value'=>$row->nombre);
echo control_group('Nombre', form_input($data),$attr = array());

$data = array('name'=>'bajada','id'=>'bajada','placeholder'=>'Bajada', 'class'=>'input-xlarge', 'value'=>$row->bajada);
echo control_group('Bajada', form_textarea($data),$attr = array());

$data = array('name'=>'descripcion','id'=>'descripcion','placeholder'=>'Descripción', 'class'=>'input-xlarge', 'value'=>$row->descripcion);
echo control_group('Descripción', form_textarea($data),$attr = array());

echo control_group('Portada', upload_manager("",array("id"=>$row->id, "pos"=>'portada', "uploadFolder"=>"uploads/videos/", "filter"=>'jpg')),$attr = array());
echo control_group('Video', upload_manager("",array("id"=>$row->id, "pos"=>'video', "uploadFolder"=>"uploads/videos/", "filter"=>'mp4')),$attr = array());


$checked = ($row->status==1) ? array('checked'=>true) : array();
$data = array('name'=>'status','id'=>'status', 'class'=>'', 'type'=>'checkbox');
echo control_group('Status', form_input($data+$checked),$attr = array());

$buttons = '';

$buttons .= '<span class="">';
$data = array('type'=>'submit', 'value'=>'Guardar', 'class'=>'btn btn-primary', 'onclick'=>"validateForm('videosForm')", 'style' =>'margin-right: 10px');
$buttons .= form_input($data);
$buttons .= anchor($back,'Cancelar',array('class'=>'btn btn-inverse'));
$buttons .= '</span>'; 
echo form_action($buttons);

echo form_close();

?>
</div>
</div>