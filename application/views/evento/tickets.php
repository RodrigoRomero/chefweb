<section id="section-tickets" class="page-section topmargin-lg">
	<div class="container clearfix">
		<div class="fancy-title title-double-border">
			<h1><span>S</span>eleccioná tu entrada</h1>
		</div>

		<?php
	//	ep($this->evento);
		if($this->evento->show_register && (strtotime($this->evento->fecha_baja) > strtotime("+1 day",date('Y-m-d H:i:s')))) {
			if($this->evento->payments_enabled) {
				foreach($tickets as $k => $item) {
					$this->load->view('evento/ticket-item', ['position'=>$k, 'item' => $item]);
				}
			} else {
				echo 'armar free';
			}
		} else {

			echo 'no enabled';
		}
		?>
	</div>

</section>
