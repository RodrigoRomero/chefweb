<div class="entry clearfix">
<div class="entry-timeline">
	<div class="timeline-divider"></div>
</div>

<div class="entry-title">
	<h2><?php echo $item->title ?></h2>
</div>
<ul class="entry-meta clearfix">
	<li><i class="icon-calendar3"></i><?php echo substr($item->hora, 0, -3).' Hs.'; ?></li>
</ul>
<?php
if(isset($item->brief) && !empty($item->brief)) { ?>
<div class="entry-content">
	<p><?php echo $item->brief ?></p>
	<?php if($item->orador_id>0){ ?>
       <p><?php echo $item->nombre ?></p>
    <?php } ?>

</div>
<?php } ?>

</div>
