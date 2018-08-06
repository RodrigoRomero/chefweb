<section id="section-oradores" class="page-section topmargin-lg">
	<div class="container clearfix">
		<div class="fancy-title title-double-border">
			<h1><span>O</span>radores</h1>
		</div>
	<?php



	foreach($oradores as $k => $item) {
		if(!empty($item['oradores'])) {
			//$this->load->view('evento/orador-headline', ['position'=>$k, 'categoria'=>$item['categoria']]);
			foreach ($item['oradores'] as $key => $value) {
				$this->load->view('evento/orador-item', ['position'=>$key, 'item' => $value]);
			}
		}

		echo '<div class="clear"></div>';
	}
	?>

	</div>
</section>
