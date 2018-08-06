<?php
$direccion = explode(",",$lugar->direccion);
$lat_lng = json_decode($lugar->json_direccion);
?>
<section id="section-lugar" class="page-section topmargin-lg">
	<div class="container clearfix">
		<div class="fancy-title title-double-border">
			<h1><span>L</span>ugar</h1>
		</div>
				<!-- Content
		============================================= -->
		<section id="content">

					<!-- Contact Info
					============================================= -->
					<div class="row clear-bottommargin">

						<div class="col-md-12 col-sm-12 bottommargin clearfix">
							<div class="feature-box fbox-center fbox-bg fbox-plain">
								<div class="fbox-icon">
									<a href="#"><i class="icon-map-marker2"></i></a>
								</div>
								<h3><?php echo $lugar->lugar?><span class="subtitle"><?php echo $direccion[1] ?>, <?php echo $direccion[2] ?></span></h3>
								<p><?php echo $lat_lng->place ?></p>
							</div>
						</div>







					</div><!-- Contact Info End -->





					<!-- Google Map
					============================================= -->
					<div class="col_full">

						<section id="google-map" class="gmap" style="height: 410px;" data-lat="<?php echo $lat_lng->lat ?>" data-lng="<?php echo $lat_lng->lng?>" data-place="<?php echo $lugar->lugar?>" ></section>

					</div><!-- Google Map End -->

					<div class="clear"></div>





		</section><!-- #content end -->

	<div class="clear"></div>
	</div>
</section>
