<div class="container clearfix">

	<div class="table-responsive bottommargin jFullCart">
		<?php $this->load->view('cart/detail', ['delete'=>true]);	?>
	</div>

	<div class="row clearfix">
	<div class="col-md-6 clearfix">


			<!-- <div class="panel panel-default">
				<div class="panel-body">
					<div class="col-md-8 col-xs-7 nopadding">
						<input type="text" value="" class="sm-form-control" name="cupon" placeholder="Ingrese código promocional..." />
					</div>
					<div class="col-md-4 col-xs-5">
						<a ref="javascript:void(0)" onclick="validateCupon()" class="button button-3d button-black nomargin">Usar Cupón</a>
					</div>
				</div>
			</div>
 -->


		</div>
		<div class="col-md-6  clearfix">

			<div class="table-responsive">
				<h4>Resúmen</h4>
				<div class="table-responsive bottommargin jResumeCart">
					<?php $this->load->view('cart/resume');	?>
				</div>
			</div>

			<?php $this->load->view('cart/no-gateway',  ['proceedToCheckout' => true, 'gateway_form' => ['action'=> base_url('/cart/finish'), 'btnTxt' => 'Confirmar Pedido']]); ?>
		</div>
	</div>
</div>
