

	<div class="col_half nobottommargin divcenter">

		<div class="nobottommargin">
		<?php
		$form_name = 'login-form';
		$data   = array ('id'=>$form_name);
		$action =  base_url('/nuevo-password');
		echo form_open($action,$data);
		echo form_hidden('hash', $hash);
		?>

			<div class="col_full">
				<label for="register-form-password">Contraseña:</label>
				<input type="password" id="register-password" name="password" value="" class="required form-control" />
			</div>

			<div class="col_full">
				<label for="register-form-repassword">Repetir Contraseña:</label>
			<input type="password" id="register-repassword" name="repassword" equalTo="#register-password" value="" class="form-control required" />
			</div>

			<div class="col_full nobottommargin">
				<button class="button button-rounded btn-block nomargin" id="login-form-submit"  onclick="validateForm('login-form')" >Ingresar</button>
			</div>

		<?php echo form_close() ?>
		</div>

	</div>