<?php
$file_name = 'oradores/'.$orador->id.'_0.jpg';
$speaker_url = base_url('evento/speaker/'.$orador->id);
$social_arr = json_decode($orador->json_socials);

?>
<div class="single-product shop-quick-view-ajax clearfix">
	<div class="row">
		<div class="col-sm-5" >
			<?php echo up_asset($file_name); ?>
		</div>

		<div class="col-sm-7 col-padding">
			<div>
			<div class="heading-block">
			<span class="before-heading color"><?php echo $orador->cargo ?></span>
			<h3><?php echo $orador->nombre ?></h3>
			</div>

			<div class="row clearfix">

			<div class="col-md-12">
			<p><?php echo $orador->brief ?></p>

			<?php if(!empty($social_arr->faceboook)) { ?>
			<a href="http://www.facebook.com/<?php echo $social_arr->faceboook ?>" class="social-icon si-borderless si-text-color si-facebook">
			<i class="icon-facebook"></i>
			<i class="icon-facebook"></i>
			</a>
			<?php } ?>
            <?php if (!empty($social_arr->twitter)) { ?>
			<a href="https://twitter.com/<?php echo $social_arr->twitter ?>" class="social-icon si-borderless si-text-color si-twitter">
			<i class="icon-twitter"></i>
			<i class="icon-twitter"></i>
			</a>
			<?php } ?>
             <?php if (!empty($social_arr->linkedin)) { ?>
			<a href="https://www.linkedin.com/in/<?php echo $social_arr->linkedin ?>" class="social-icon si-borderless si-text-color si-linkedin">
			<i class="icon-linkedin"></i>
			<i class="icon-linkedin"></i>
			</a>
			<?php } ?>
			</div>


			</div>

			</div>
		</div>
	</div>

</div>
