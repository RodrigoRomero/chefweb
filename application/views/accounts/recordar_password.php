<div class="container clearfix">

	<div class="col_half nobottommargin divcenter">

		<div class="nobottommargin">
		<?php
		$form_name = 'login-form';
		$data   = array ('id'=>$form_name);
		$action =  base_url('/reset');
		echo form_open($action,$data);
		?>

			<div class="col_full">
				<label for="login-form-username">Email:</label>
				<input type="text" id="login-form-username" name="email" value="" class="form-control required email" />
			</div>


			<div class="col_full nobottommargin">
				<button class="button button-3d btn-block nomargin" id="restore-form-submit"  onclick="validateForm('login-form')" >Recuperar</button>
			</div>

		<?php echo form_close() ?>
		</div>

	</div>
</div>