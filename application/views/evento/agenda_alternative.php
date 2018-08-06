<?php

$place = explode(",", $this->evento->direccion);
$fecha_inicio = explode(" ",$this->evento->fecha_inicio);
$fecha_cierre = explode(" ",$this->evento->fecha_baja);
$hora_inicio  = substr($fecha_inicio[1],0,-3);
$hora_cierre  = substr($fecha_cierre[1],0,-3);
$fecha_inicio_array = explode("-", $fecha_inicio[0]);
$fecha_cierre_array = explode("-", $fecha_cierre[0]);

?>
<section id="section-agenda" class="page-section topmargin-lg">

	<div class="">

	<div class="container clearfix">
	<div class="fancy-title title-double-border">
		<h1><span>A</span>genda</h1>
	</div>
	<!-- Posts
	============================================= -->
	<div id="posts" class="post-grid grid-container post-masonry post-timeline grid-2 clearfix">

		<div class="timeline-border"></div>



		<div class="entry entry-date-section notopmargin"><span><?php echo $fecha_inicio_array[2].' '.strtoupper(getMes($fecha_inicio_array[1])).' '.$hora_inicio.' Hs.' ?></span></div>

		<?php
			foreach($agenda as $k => $item){
				$this->load->view('evento/agenda-item', ['position'=>$k, 'item' => $item]);
			}
		?>

	</div><!-- #posts end -->

	</div>

	</div>



</section>
