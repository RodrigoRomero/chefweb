

<div class="container clearfix">

					<div class="col_one_third nobottommargin">

						<div class="well well-lg nobottommargin">
							<?php
							$form_name = 'login-form';
							$data   = array ('id'=>$form_name);
							$action =  base_url('/auth/login');
							echo form_open($action,$data);
							?>


								<h3>Ingresar a mi cuenta</h3>

								<div class="col_full">
									<label for="login-form-username">Email:</label>
									<input type="text" id="login-form-username" name="username" value="" class="form-control required email" />
								</div>

								<div class="col_full">
									<label for="login-form-password">Password:</label>
									<input type="password" id="login-form-password" name="password" value="" class="form-control required" />
								</div>

								<div class="col_full nobottommargin">

									<button class="button button-rounded" id="login-form-submit"  onclick="validateForm('login-form')">Ingresar</button>

								</div>

							<?php echo form_close() ?>
						</div>

					</div>

					<div class="col_two_third col_last nobottommargin">




					</div>



				</div>
