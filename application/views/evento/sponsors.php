<section id="section-sponsors" class="page-section topmargin-lg">
	<div class="container clearfix">
		<div class="fancy-title title-double-border">
			<h1><span>S</span>ponsors</h1>
		</div>
	<?php
		$total_items = count($sponsors);

		foreach($sponsors as $k => $item){

			$last_group = ($total_items == $k+1) ? true : false;
			$this->load->view('evento/sponsor-category', ['position'=>$k, 'item' => $item['categoria'], 'sponsors' => $item['sponsors'], 'last_group'=>$last_group]);

		}

	//foreach($oradores as $k => $item) {
	//
	//}
	?>
	<div class="clear"></div>
	</div>
</section>
