<?php
$data = array ('id'=>'ticketsForm', 'class'=>'form');
echo form_open($action,$data);

?>
<div class="row-fluid">
	<div class="box span12">
		<?php $this->load->view('layout/panels/box_header', array('title'=>$title, 'icon'=>'icon-pencil')) ?>
		<?php $this->load->view('alerts/error') ?>

		<div class="box-content">
			<div class="form_container">

				<?php
				echo '<div class="row-fluid">';
					echo '<div class="span4">';
					$data = array('name'=>'nombre','id'=>'nombre','placeholder'=>'Título', 'class'=>'required input-xlarge', 'value'=>$row->nombre);
					echo control_group($data['placeholder'], form_input($data));
					echo '</div>';
					echo '<div class="span6">';
					$data = array('name'=>'bajada','id'=>'bajada','placeholder'=>'Bajada Precio', 'class'=>'input-xxlarge', 'value'=>$row->bajada);
					echo control_group($data['placeholder'], form_input($data));
					echo '</div>';
				echo '</div>';
				echo '<div class="row-fluid">';
					echo '<div class="span4">';
					$data = array('name'=>'precio_regular','id'=>'precio_regular','placeholder'=>'Precio', 'class'=>'required number input-xlarge', 'value'=>$row->precio_regular);
					echo control_group($data['placeholder'], form_input($data));
					echo '</div>';

					echo '<div class="span6">';

				 $data = array('name'=>'descripcion','id'=>'resumen','placeholder'=>'Resúmen', 'data-maxlength'=>'350','class'=>'required  limited animated  input-xxlarge', 'value'=>$row->descripcion);
                echo control_group('Resúmen', form_textarea($data),$attr = array());
                echo '</div>';

				echo '</div>';




				echo '<div class="row-fluid">';

					echo '<div class="span6">';
					$data = array('name'=>'background','id'=>'background','placeholder'=>'Hexadecimal Background', 'class'=>'required input-xlarge', 'value'=>$row->background);
					echo control_group($data['placeholder'], form_input($data));
					echo '</div>';
				echo '</div>';
				 echo '<div class="row-fluid">';
					echo '<div class="span6">';
					$data = array('name'=>'min_qty','id'=>'min_qty','placeholder'=>'Cantidad Mínima', 'class'=>'number input-xlarge', 'value'=>$row->min_qty);
					echo control_group($data['placeholder'], form_input($data));
					echo '</div>';
					echo '<div class="span6">';
					$data = array('name'=>'max_qty','id'=>'max_qty','placeholder'=>'Cantidad Máxima', 'class'=>'number input-xlarge', 'value'=>$row->max_qty);
					echo control_group($data['placeholder'], form_input($data));
					echo '</div>';
				echo '</div>';
				$checked = ($row->agotadas==1) ? array('checked'=>true) : array();
				$data = array('name'=>'agotadas','id'=>'agotadas', 'class'=>'', 'type'=>'checkbox');
				echo control_group('Almuerzo Agotado', form_input($data+$checked),$attr = array());

				$checked = ($row->status==1) ? array('checked'=>true) : array();
				$data = array('name'=>'status','id'=>'status', 'class'=>'', 'type'=>'checkbox');
				echo control_group('Activo', form_input($data+$checked),$attr = array());

				$buttons = '';
				$buttons .= '<span class="pull-left">';
				$data = array('type'=>'submit', 'value'=>'Guardar', 'class'=>'btn btn-inverse', 'onclick'=>"validateForm('ticketsForm')", 'style' =>'margin-right: 10px');
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
<script>
	function removeLine(pos){
		if(pos>0){
			$(".jPos-"+pos).remove();
		} else {
			alert('No se puede eliminar');
		}
	}
</script>
