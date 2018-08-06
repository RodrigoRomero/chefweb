<?php
$data = array ('id'=>'gatewayForm', 'class'=>'form');
echo form_open($action,$data);
?>
<div class="row-fluid">
	<div class="box span12">
		<?php $this->view('layout/panels/box_header', array('title'=>$title, 'icon'=>'icon-pencil')) ?>
		<?php $this->view('alerts/error') ?>

		<div class="box-content">
			<div class="form_container">
				<?php
				$data = array('name'=>'name','id'=>'nombre','placeholder'=>'Nombre', 'class'=>'required input-xlarge', 'value'=>$row->nombre);
				echo control_group($data['placeholder'], form_input($data),$attr = array('append'=>'<a class="icon-question ax-modal tip-right" data-original-title="Ver ayuda" href="'.base_url('helps/general/1').'"></a>'));

				$checked = ($row->status==1) ? array('checked'=>true) : array();
				$data = array('name'=>'status','id'=>'status', 'class'=>'', 'type'=>'checkbox');
				echo control_group('Activo', form_input($data+$checked),$attr = array());

				$buttons = '';
				$buttons .= '<span class="pull-left">';
				$data = array('type'=>'submit', 'value'=>'Guardar', 'class'=>'btn btn-inverse', 'onclick'=>"validateForm('gatewayForm')", 'style' =>'margin-right: 10px');
				$buttons .= form_input($data);
				$buttons .= anchor($back,'Cancelar',array('class'=>'btn btn-inverse'));
				$buttons .= '</span>';
				echo form_action($buttons);
				echo form_close();
				?>
			</div>
		</div>
	</div>
</div>

