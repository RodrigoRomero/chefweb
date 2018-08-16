<div class="top-links">
	<ul>
		<?php
		if($this->auth->loggedin()) { ?>
			<li><a href="<?php echo base_url('/salir') ?>" alt="Salir" title="Salir">Bienvenido <?php echo get_session('nombre',false).' '.get_session('apellido',false) ?> [X]</a></li>
			<li><a href="<?php echo base_url('/mi-cuenta') ?>">Mi Cuenta</a></li>
		<?php } else { ?>
			<li><a href="<?php echo base_url('/crear-cuenta') ?>">Registrarme</a></li>
			<li><a href="javascript:void(0)">Login</a>
			<div class="top-link-section">
				<?php
				$form_name = 'login-header-form';
				$data   = array ('id'=>$form_name);
				$action =  base_url('/auth/login');
				echo form_open($action,$data);
				?>
				<div class="col_full">
				<label for="login-form-username">Email:</label>
				<input type="text" id="login-username" name="username" value="" class="form-control required email" />
			</div>

			<div class="col_full">
				<label for="login-form-password">Password:</label>
				<input type="password" id="login-password" name="password" value="" class="form-control required" />
				<a href="<?php echo base_url('/recordar-password') ?>">Recordar contraseña</a>
			</div>

			<div class="col_full nobottommargin">

				<button class="button button-rounded btn-block nomargin" id="login-form-submit"  onclick="validateForm('<?php echo $form_name ?>')">Ingresar</button>
				<a href="<?php echo base_url('/crear-cuenta')?>">Crear Cuenta</a>
			</div>
				<?php echo form_close() ?>

			</div>
		</li>
		<?php } ?>
		<li><a href="<?php echo base_url('/carrito/detalle') ?>"><i class="icon-shopping-cart"></i></a></li>
	</ul>
</div><!-- .top-links end -->
