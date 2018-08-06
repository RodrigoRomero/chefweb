<div class="col-md-4 bottommargin">
	<div class="team team-list clearfix" style="height: 480px;">
		<?php

		$file_name = 'oradores/'.$item->id.'_0.jpg';
		$speaker_url = base_url('evento/speaker/'.$item->id);
		$social_arr = json_decode($item->json_socials);
		echo up_asset($file_name);
		?>
		<div class="team-title center">
			<h4><?php echo $item->nombre ?></h4><span><?php echo $item->cargo ?></span>
		</div>

			<!-- <p><?php echo $orador->brief ?></p> -->
			<?php if($this->evento->show_full_bio == 0) { ?>
			<div class="center">
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
		<?php } else { ?>
		<a href="<?php echo $speaker_url ?>" data-lightbox="ajax" class="button button-border button-rounded button-fill fill-from-bottom button-violet" style="text-align: center; position:absolute; width: 100%; bottom: 0px; margin: 0px"><span>Ver Bio</span></a>
		<?php } ?>
	</div>
</div>
