<?php
$conocio = ['redes_sociales' => ['id'=>'transferencia_bancaria', 'type'=>'radio','name'=>'conocio', 'class'=>'', 'value'=>'redes_sociales'],
              'email' => ['id'=>'mercado_pago', 'type'=>'radio','name'=>'conocio', 'class'=>'', 'value'=>'email'],
              'referido' => ['id'=>'referido', 'type'=>'radio','name'=>'conocio', 'class'=>'', 'value'=>'referido']
			];

$fecha_nacimiento = explode("-", $customer->fecha_nacimiento);
$fecha_nacimiento = $fecha_nacimiento[2].'-'.$fecha_nacimiento[1].'-'.$fecha_nacimiento[0];

$newsletter = ($customer->newsletter == 1) ? 'checked' : ''


?>

<?php echo $this->load->view('accounts/partials/menu_account',[],true); ?>
<div class="col_two_third col_last">

	<?php
			$form_name = 'register-form';
			$data   = array ('id'=>$form_name);
			$action =  base_url('/account/update/'.$customer->id);
			echo form_open($action,$data);
			?>
				<div class="col_half">
					<label for="register-form-username">Nombre:</label>
					<input type="text" id="register-nombre" name="nombre" value="<?php echo $customer->nombre ?>" class="form-control required" />
				</div>

				<div class="col_half col_last">
					<label for="register-form-phone">Apellido:</label>
					<input type="text" id="register-apellido" name="apellido" value="<?php echo $customer->apellido ?>" class="form-control required" />
				</div>

				<div class="clear"></div>

				<div class="col_full">
					<label for="register-form-email">Email:</label>
					<input type="text" id="register-email" name="email" value="<?php echo $customer->email ?>" class="form-control required email" />
				</div>

				<div class="clear"></div>


				<div class="col_half ">
					<label for="register-form-phone">Fecha Nacimiento:</label>
					<input type="text" id="register-fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento ?>" class="form-control tleft past-enabled"  placeholder="DD-MM-YYYY"/>

				</div>


				<div class="clear"></div>
				<div class="col_half ">
					<label for="register-form-phone">Teléfono:</label>
					<input type="text" id="register-telefono" name="telefono" value="<?php echo $customer->telefono ?>" class="form-control" />
				</div>
				<div class="col_half col_last">
					<label></label>
					<div>
						<input id="register-form-newsletter" class="checkbox-style" name="newsletter" type="checkbox" <?php echo $newsletter ?>>
						<label for="register-form-newsletter" class="checkbox-style-3-label">Deseo recibir newsletter:</label>
					</div>
				</div>

				<div class="clear"></div>

				<div class="col_half">
				<label>Como nos conoció:</label>
				<?php
				foreach($conocio as $k=>$item) {
				$name = ucwords(str_replace('_',' ',$k));
				$v = ($customer->conocio == $item['value']) ? 'checked' : '';
				?>
				<div>
				<input id="<?php echo $item['id']?>" class="radio-style" name="<?php echo $item['name']?>" type="radio" value="<?php echo $item['value']?>" <?php echo $v ?>>
				<label for="<?php echo $item['id']?>" class="required radio-style-3-label"><?php echo $name ?></label>
				</div>


				<?php } ?>
				</div>

				<div class="col_full nobottommargin">
					<a class="button button-3d  nomargin" href="<?php echo base_url('/mi-cuenta')?>" >Cancelar</a>
					<button class="button button-3d button-black nomargin" id="login-form-submit"  onclick="validateForm('<?php echo $form_name ?>')">Actualizar</button>


				</div>

			<?php echo form_close() ?>

</div