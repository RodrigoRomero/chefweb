<div class="col_two_third j-clear-form">
	<?php
	$form_name = 'register-form';
	$data   = array ('id'=>$form_name);
	$action =  base_url('/institucional/mensaje');
	echo form_open($action,$data);
	?>



		<div class="col_half">
			<label for="register-form-username">Nombre:</label>
			<input type="text" id="register-nombre" name="nombre" value="" class="form-control required" />
		</div>

		<div class="col_half col_last">
			<label for="register-form-phone">Apellido:</label>
			<input type="text" id="register-apellido" name="apellido" value="" class="form-control required" />
		</div>
		<div class="clear"></div>

		<div class="col_full">
			<label for="register-form-email">Email:</label>
			<input type="text" id="register-email" name="email" value="" class="form-control required email" />
		</div>

		<div class="clear"></div>

		<div class="col_full">
			<label for="template-contactform-message">Mensaje <small>*</small></label>
			<textarea class="required sm-form-control" id="template-contactform-message" name="message" rows="6" cols="30"></textarea>
		</div>


		<div class="clear"></div>

		<div class="col_full nobottommargin">
			<button class="button button-rounded nomargin" id="login-form-submit"  onclick="validateForm('<?php echo $form_name ?>')">Enviar Mensaje</button><br/>
		</div>

	<?php echo form_close() ?>
</div>
<div class="col_one_third col_last">
	<address>
		<strong>Ciudad de Buenos Aires, Argentina</strong>
	</address>
	<abbr title="Teléfono Celular"><strong>Celular:</strong></abbr> (011) 1567825824<br>
	<abbr title="Email"><strong>Email:</strong></abbr> <?php
	$attributes = ["title"=>'Hablemos'];
	$string = 'hola@rodrigoromero.life';
	echo safe_mailto('hola@rodrigoromero.life', $string, $attributes) ?>

</div>