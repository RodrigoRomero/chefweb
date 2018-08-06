<?php
$name = 'sponsors/'.$item->id.'_0.jpg';
$image_url = up_file($name);
 ?>



<a href="<?php echo $image_url ?>" data-lightbox="gallery-item" class="bottommargin col-md-3 col-xs-12 col-sm-4"><?php echo up_asset($name, ['alt'=>$item->name, 'title'=>$item->name, 'class'=>'col-xs-12']); ?></a>

