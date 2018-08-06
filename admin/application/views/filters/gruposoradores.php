<div class="box span12">

	<div class="box-header">

		<h2><i class="icon-search"></i> Filtros</h2>

	</div>


	<div class="box-content">



		<?php

		$data   = array ('id'=>'frmFilter');

		echo form_open($action,$data);

		$data = array('id'=>'', 'class'=>'filt', 'value'=>$nombre, 'name'=>'search', 'placeholder'=>'Buscar');

		echo form_label($data['placeholder']);

		echo form_input($data);

		echo form_close();



		echo anchor_js('Buscar', array('class'=>"cg-filters btn btn-small btn-primary", 'id'=>'j-filter-send', 'style'=>'margin-right:10px'));

		echo anchor_js('Resetear', array('class'=>"cg-filters btn btn-small btn-inverse", 'id'=>'j-filter-reset', 'style'=>'margin-right:10px'));

		echo anchor_js('Ordenar', array('class'=>"cg-filters btn btn-small btn-secondary", 'id'=>'j-enable-order', 'data-state'=>0, 'data-module'=>$order));


		?>

   </div>

</div>
