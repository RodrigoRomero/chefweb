<div class="fancy-title title-bottom-border">
	<h4><span><?php echo substr($item->hora, 0, -3).' Hs.'; ?></span> - <?php echo $item->title ?></h4>
</div>
<?php
if(isset($item->brief) && !empty($item->brief)) { ?>
<div class="promo promo-border bottommargin">
	<div class="col-md-8"><span><?php echo nl2br($item->brief) ?></span></div>
	<div class="col-md-4">
		<span>
			<?php if($item->orador_id>0){ ?>
       		<b>Orador:</b> <br/><?php echo $item->nombre ?>
    <?php } ?></span>
	</div>
	<div class="clearfix"></div>

</div>
<?php } ?>
