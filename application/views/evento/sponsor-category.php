<div class="title-block av2020">

	<?php
	if($position >= 3){
		$position = 4;
	} else {
		$position = $position+1;
	}

	echo heading($item->nombre, ($position))
	?>

</div>
	<div class=""  data-lightbox="gallery">
		<?php foreach ($sponsors as $sponsor){
			$this->load->view('evento/sponsor-items', ['item'=>$sponsor]);

		}
		?>

	</div>
	<div class="clear"></div>
