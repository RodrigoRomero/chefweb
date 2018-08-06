<!-- BLOG -->
<div class="fancy-title title-double-border">
	<h1><span>A</span>lmuerzo de Networking</h1>
</div>

<?php

foreach($almuerzos as $k => $item) {
	$this->load->view('evento/almuerzo-item', ['position'=>$k, 'item' => $item]);
}
?>

