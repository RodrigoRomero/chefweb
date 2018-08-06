	<!-- <a href="#" class="button button-desc"><div>Ya tengo cuenta</div><span>Logueate desde aquí</span></a> -->

	<p>Una vez registrado podras realizar el seguimiento de tus pedidos.</p>

	<?php
	$form_name = 'register-form';
	$data   = array ('id'=>$form_name);
	$action =  base_url('/account/create');
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

		<div class="col_half">
			<label for="register-form-password">Contraseña:</label>
			<input type="password" id="register-password" name="password" value="" class="required form-control" />
		</div>

		<div class="col_half col_last">
			<label for="register-form-repassword">Repetir Contraseña:</label>
			<input type="password" id="register-repassword" name="repassword" equalTo="#register-password" value="" class="form-control required" />
		</div>

		<div class="clear"></div>

		<div class="col_full nobottommargin">
			<button class="button button-3d nomargin" id="login-form-submit"  onclick="validateForm('<?php echo $form_name ?>')">Registrarme</button><br/>
			<a href="<?php echo base_url('/ingresar')?>">Ya tenés cuenta, ingresá desde acá</a>
		</div>

	<?php echo form_close() ?>