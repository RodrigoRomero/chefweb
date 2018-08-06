<div class="alert alert-<?php echo $type ?>">
	<button data-dismiss="alert" class="close">×</button>	
    <?php echo $success ?>
    <?php 
    if($back) {
    echo anchor($back,'Volver al listado'); 
    }
    ?>
</div>