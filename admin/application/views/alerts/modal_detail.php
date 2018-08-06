<div class="modal-header">
	<button data-dismiss="modal" class="close" type="button">×</button>
	<h3><?php echo $title ?></h3>
</div>
<div class="modal-body">
	<?php echo $texto ?>
</div>
<div class="modal-footer">
    <?php if(!empty($link)) { ?>
	<a data-dismiss="modal" class="btn btn-primary ax-modal" href="<?php echo $link ?>">Confirm</a>
    <?php } ?>
	<a data-dismiss="modal" class="btn" href="#">Cancel</a>
</div>