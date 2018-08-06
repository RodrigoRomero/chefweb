<?php
$data = array ('id'=>'oradoresForm', 'class'=>'form');
echo form_open($action,$data);
$social = json_decode($row->json_socials);
?>

<div class="row-fluid">
	<div class="box span12">
		<?php $this->load->view('layout/panels/box_header', array('title'=>$title, 'icon'=>'icon-pencil')) ?>
		<?php $this->load->view('alerts/error') ?>
	</div>
</div>

<div class="row-fluid">
	<div class="box span7">
		<?php $this->load->view('layout/panels/box_header', array('title'=>'Datos Generales', 'icon'=>'icon-pencil')) ?>
		<div class="box-content">
			<div class="form_container">
				<?php

			 	$data = frm_select('',array('name'=>'orador_grupo_id'),$categorias, $row->orador_grupo_id,'',false,array(),'','Seleccione Categoría');
                echo control_group('Categoría', $data, $attr = array('help-in-label'=>'<a class="fa fa-question ax-modal tip-right" data-original-title="Ver ayuda" href="'.base_url('helps/general/1').'"></a>'));

				$data = array('name'=>'cargo','id'=>'cargo','placeholder'=>'Cargo', 'class'=>'input-xlarge', 'value'=>$row->cargo);
				echo control_group($data['placeholder'], form_input($data));

				$data = array('name'=>'nombre','id'=>'nombre','placeholder'=>'Nombre y Apellido', 'class'=>'required input-xlarge', 'value'=>$row->nombre);
				echo control_group($data['placeholder'], form_input($data));

				$data = array('name'=>'brief','id'=>'resumen_orador','placeholder'=>'Resúmen Vitae', 'data-maxlength'=>'500','class'=>'limited animated  input-xxlarge', 'value'=>$row->brief);
				echo control_group($data['placeholder'], form_textarea($data),$attr = array());

				$data = array('name'=>'status','id'=>'status', 'class'=>'', 'type'=>'checkbox', 'checked'=>'checked');
				echo control_group('Activo', form_input($data),$attr = array());
				?>
			</div>



		</div>

	</div>

	<div class="box span5">

		<div class="row-fluid">

			<div class="box span12">

				<?php $this->load->view('layout/panels/box_header', array('title'=>'Social Links', 'icon'=>'icon-thumbs-up', 'subaction'=>false)) ?>

				<div class="box-content">

					<div class="form_container">

						<?php

						echo control_group('Foto Orador', upload_manager("",array("id"=>$row->id, "uploadFolder"=>"uploads/oradores/", "filter"=>'jpg', "ratio"=>'400x400')),$attr = array('id'=>'uploadGroupNo', 'help-block'=>'(Imágen JPG - 400x400)'));

						$data = array('name'=>'twitter','id'=>'twitter','placeholder'=>'Twitter del Orador', 'class'=>'', 'value'=>$social->twitter);
						echo control_group('Twitter', form_input($data),$attr = array('prepend'=>'<i class="icon-twitter"></i>','append'=>'<a class="icon-question ax-modal tip-right" data-original-title="Ver ayuda" href="'.base_url('helps/general/2').'"></a>'));

						$data = array('name'=>'facebook','id'=>'facebook','placeholder'=>'Facebook del Orador', 'class'=>'', 'value'=>$social->faceboook);
						echo control_group('Facebook', form_input($data),$attr = array('prepend'=>'<i class="icon-facebook"></i>','append'=>'<a class="icon-question ax-modal tip-right" data-original-title="Ver ayuda" href="'.base_url('helps/general/2').'"></a>'));

						$data = array('name'=>'linkedin','id'=>'linkedin','placeholder'=>'Linkedin del Orador', 'class'=>'', 'value'=>$social->linkedin);
						echo control_group('Linkedin', form_input($data),$attr = array('prepend'=>'<i class="icon-linkedin"></i>','append'=>'<a class="icon-question ax-modal tip-right" data-original-title="Ver ayuda" href="'.base_url('helps/general/2').'"></a>'));

						?>

					</div>

				</div>

			</div>

		</div>





	</div>

</div>

<div class="row-fluid">

	<div class="box span12">

		<div class="box-content">

			<div class="form_container">

				<?php

				$buttons = '';

				$buttons .= '<span class="pull-left">';

				$data = array('type'=>'submit', 'value'=>'Guardar', 'class'=>'btn btn-inverse', 'onclick'=>"validateForm('oradoresForm')", 'style' =>'margin-right: 10px');

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





