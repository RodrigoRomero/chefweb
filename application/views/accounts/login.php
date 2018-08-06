<div class="container clearfix">

	<div class="col_half nobottommargin divcenter">

		<div class="nobottommargin">
		<?php
		$form_name = 'login-form';
		$data   = array ('id'=>$form_name);
		$action =  base_url('/auth/login');
		echo form_open($action,$data);
		?>

			<div class="col_full">
				<label for="login-form-username">Email:</label>
				<input type="text" id="login-form-username" name="username" value="" class="form-control required email" />
			</div>

			<div class="col_full">
				<label for="login-form-password">Password:</label>
				<input type="password" id="login-form-password" name="password" value="" class="form-control required" />
				<a href="<?php echo base_url('/recordar-password') ?>">Recordar contraseña</a>
			</div>

			<div class="col_full nobottommargin">
				<button class="button button-3d btn-block nomargin" id="login-form-submit"  onclick="validateForm('login-form')" >Ingresar</button>
				<a href="<?php echo base_url('/crear-cuenta')?>">Crear Cuenta</a>
			</div>

		<?php echo form_close() ?>
		</div>

	</div>
</div>