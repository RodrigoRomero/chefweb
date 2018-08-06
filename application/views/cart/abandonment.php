<div class="container clearfix">
	<div class="fancy-title title-double-border">
		<h1><span>Tus</span> Entradas</h1>
	</div>

	<div class="table-responsive bottommargin jFullCart">
		<?php $this->load->view('cart/detail', ['delete'=>true]);	?>
	</div>

	<div class="row clearfix">
	<div class="col-md-6 clearfix">
				<div class="table-responsive">
				<h4>Resúmen</h4>
				<div class="table-responsive bottommargin jResumeCart">
					<?php $this->load->view('cart/resume');	?>
				</div>
			</div>

		</div>
		<div class="col-md-6  clearfix">
			<h4>Elija Medio de Pago</h4>


			<?php $this->load->view('cart/gateways',  ['proceedToCheckout' => true,
				                                       'show_options' => false,
				                                        'gateway_form' => ['action' => base_url('/cart/process'), 'btnTxt' => 'Completar'],
				                                        ]);
				                                        ?>
		</div>
	</div>
</div>
