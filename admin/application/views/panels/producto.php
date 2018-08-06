<?php
$data = array ('id'=>'ticketsForm', 'class'=>'form');
echo form_open($action,$data);
if(!empty($row->descripcion)){
	$descripcion = json_decode($row->descripcion);
}
?>
<div class="row-fluid">
	<div class="box span12">
		<?php $this->load->view('layout/panels/box_header', array('title'=>$title, 'icon'=>'icon-pencil')) ?>
		<?php $this->load->view('alerts/error') ?>

		<div class="box-content">
			<div class="form_container">

				<?php
				echo '<div class="row-fluid">';
					echo '<div class="span8">';

					$data = array('name'=>'nombre','id'=>'nombre','placeholder'=>'Nombre del Producto', 'class'=>'required', 'value'=>$row->nombre);
					echo control_group($data['placeholder'], form_input($data));

					 $data = array('name'=>'bajada','id'=>'bajada','placeholder'=>'Descripción Resumida', 'class'=>'input-xlarge',  'data-maxlength'=>'500','class'=>'limited animated  input-xxlarge', 'value'=>$row->bajada);
					echo control_group($data['placeholder'], form_textarea($data));

					echo '</div>';
					echo '<div class="span4">';

					$data = array('name'=>'sku','id'=>'sku','placeholder'=>'Código Producto', 'class'=>'input-xlarge', 'value'=>$row->sku);
					echo control_group($data['placeholder'], form_input($data));


					$data = array('name'=>'precio_regular','id'=>'precio_regular','placeholder'=>'Precio Regular', 'class'=>'required number input-xlarge', 'value'=>$row->precio_regular);
					echo control_group($data['placeholder'], form_input($data));

					$data = array('name'=>'precio_oferta','id'=>'precio_oferta','placeholder'=>'Precio Promocional', 'class'=>'number input-xlarge', 'value'=>$row->precio_oferta);
					echo control_group($data['placeholder'], form_input($data));

					$fecha = getFechaView($row->fecha_baja);
					$html  = '<div class="span6"><span class="add-on"><i class="icon-calendar"></i></span>'.form_input(array('class'=>'j-datepicker input-small', 'data-date'=>date('d/m/Y'), 'value'=>$fecha, 'name'=>'fecha_baja')).'</div>';
					echo control_group('Fecha Fin Precio Promocional', $html, $attr = array('class_controls'=>'', 'prepend'=>''));

					echo '</div>';
				echo '</div>';

				echo '<div id="jClone">';
				if(count($descripcion)>0){
					foreach($descripcion as $k => $desc){
						$this->load->view('panels/plan_detail', array('pos'=>$k, 'data'=>$desc ));
					}
				} else {
					$this->load->view('panels/plan_detail', array('pos'=>0));
				}
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
				echo control_group('Producto Agotado', form_input($data+$checked),$attr = array());

				$checked = ($row->status==1) ? array('checked'=>true) : array();
				$data = array('name'=>'status','id'=>'status', 'class'=>'', 'type'=>'checkbox');
				echo control_group('Activo', form_input($data+$checked),$attr = array());




				echo '<div class="row-fluid">';
					echo '<div class="span12">';
					 echo control_group('Fotos del Producto', upload_manager("",array("id"=>$row->id, "uploadFolder"=>"uploads/products/", "resize"=>"440", "filter"=>'jpg', "ratio"=>'720x960')),$attr = array('id'=>'uploadGroupNo', 'help-block'=>'(Imágen JPG - 720x960)'));

					echo '</div>';
				echo '</div>';



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
