
<?php
$place = explode(",", $this->evento->direccion);
$fecha_inicio = explode(" ",$this->evento->fecha_inicio);
$fecha_cierre = explode(" ",$this->evento->fecha_baja);
$hora_inicio  = substr($fecha_inicio[1],0,-3);
$hora_cierre  = substr($fecha_cierre[1],0,-3);
$fecha_inicio_array = explode("-", $fecha_inicio[0]);
$fecha_cierre_array = explode("-", $fecha_cierre[0]);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
	<?php $this->view('layout/head.php')?>
</head>

<body class="stretched">
	<!-- <noscript>
 <img height="1" width="1"
src="https://www.facebook.com/tr?id=1748104025451888&ev=PageView
&noscript=1"/>
</noscript> -->
	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">
		<!-- Top Bar
		============================================= -->
		<div id="top-bar">

			<div class="container clearfix">
				<div class="col_half col_last fright nobottommargin">
				<?php echo $this->load->view('layout/toplinks', ['layout'=> 'one_page'], true) ?>
					<!-- Top Links
					============================================= -->

				</div>

			</div>

		</div><!-- #top-bar end -->
		<div id="home" class="page-section" style="position:absolute;top:0;left:0;width:100%;height:200px;z-index:-2;"></div>
		<section id="slider" class="slider-parallax full-screen with-header swiper_wrapper clearfix">
			<div class="slider-parallax-inner">
				<div class="swiper-container swiper-parent">
					<div class="swiper-wrapper">
						<div class="swiper-slide dark" style="background-image: url('<?php echo up_file('slider/'.$this->evento->id.'_0.jpg')?>');">
							<div class="container clearfix">
							<?php //ep($this->evento) ?>
								<div class="slider-caption slider-caption-center">
									<h3> 6to ENCUENTRO DE REFLEXIÓN</h3>
									<h2 data-caption-animate="fadeInUp" style="margin-bottom: 0"><?php echo $this->evento->nombre ?></h2>


						<h3 ><?php echo $this->evento->bajada ?></h3>




<div class="row">

									<div class="col-md-3 col-md-offset-3">

									<div class="venue_place">
                                <span class="icon-location"></span>
                                <p><?php echo $place[0] ?><br /><?php echo $this->evento->lugar ?></p>
                            </div>
									</div>
									<div class="col-md-3">
									 <div class="venue_date">
                                <span class="icon-calendar"></span>
                                <p>
                                <?php if($fecha_inicio[0]==$fecha_cierre[0]) { ?>
                                    <span class="day"><?php echo $fecha_inicio_array[2] ?></span>
                                    <span class="month"><?php echo strtoupper(getMes($fecha_inicio_array[1])) ?></span>
                                <?php } else { ?>
                                    <?php echo $fecha_inicio[0] ?><br />
                                    <?php echo $fecha_cierre[0] ?>
                                <?php } ?>
                                <br /><span><?php echo $hora_inicio.' a '.$hora_cierre.' hs.' ?></span>
                                </p>
                            </div>
                                </div>
                                </div>
                               <div class="center topmargin-lg one-page-menu" data-caption-animate="fadeInUp" data-caption-delay="200">
								<a href="javascript:void(0)" data-href="#section-tickets"" class="button button-xlarge button-white">Comprar Tickets</a>
								<a href="https://www.youtube.com/watch?v=-Q8m07fVPhY"  data-lightbox="iframe"  class="button button-xlarge button-inverse">Ver Video</a>

								</div>
								<!--
									<div  class="one-page-menu">
										<a href="#"" data-href="#section-tickets"" class="button button-3d button-white button-light button-rounded button-xlarge">Comprar Tickets</a>

									</div>
									-->
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>





		<!-- Header
		============================================= -->
		<header id="header" class="full-header">

			<div id="header-wrap">

				<div class="container clearfix">

					<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

					<!-- Logo
					============================================= -->
					<div id="logo">
						<a href="<?php echo base_url('/') ?>" class="standard-logo" data-dark-logo="images/logo-dark.png">
							<?php echo image_asset('logo.png', '','') ?>
						</a>
						<a href="<?php echo base_url('/') ?>" class="retina-logo" data-dark-logo="images/logo-dark@2x.png">
							<?php echo image_asset('logo.png', '','') ?>
						</a>
					</div><!-- #logo end -->

					<!-- Primary Navigation
					============================================= -->

					<?php echo $this->load->view('layout/main_navigation',['layout'=> 'one_page'],true); ?>



				</div>

			</div>

		</header><!-- #header end -->

		<div class="clear"></div>

		<!-- Content
		============================================= -->
		<section id="content">

			<div >

				<?php echo $module ?>

			</div>

		</section><!-- #content end -->

		<?php echo $footer ?>

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>
	<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDMxJ92oBkSnVNHFX3R8XhtYQPEgk1_IiI"></script>
	<script type="text/javascript" src="https://www.mercadopago.com/org-img/jsapi/mptools/buttons/render.js"></script>
	<?php
		foreach ($js_layout as $js) {
	    	echo js_asset($js.'.js');
		}
		echo js_asset('jquery.gmap.js');

		#WIDGETS
		foreach($widgets as $folder => $v){
		    $widgetFolder = $folder;
		    foreach ($v as $type => $file){
		        if($type=='css'){
		            if(is_array($file)){
		                foreach ($file as $f){
		                    echo css_asset($type.'/'.$f.'.'.$type,'../third_party/'.$widgetFolder);
		                }

		            } else {
		                echo css_asset($type.'/'.$file.'.'.$type,'../third_party/'.$widgetFolder);
		            }

		        } elseif ($type=='js'){
		            if(is_array($file)){
		                foreach ($file as $f){
		                    echo js_asset($type.'/'.$f.'.'.$type,'../third_party/'.$widgetFolder);
		                }
		            } else {
		                echo js_asset($type.'/'.$file.'.'.$type,'../third_party/'.$widgetFolder);
		            }
		        } else {
		            show_error('formato no valido',500,'Problema al parsear Widget');
		        }
		    }
		}
	?>







	<script type="text/javascript">
		var e = $("#google-map");

        $googlemap_latitude  = e.attr('data-lat');
        $googlemap_longitude = e.attr('data-lng');
        $google_place = e.attr('data-place');


		jQuery('#google-map').gMap({


			maptype: 'ROADMAP',
			zoom: 14,
			latitude: $googlemap_latitude,
			longitude: $googlemap_longitude,
			markers: [
				{
					latitude: $googlemap_latitude,
					longitude: $googlemap_longitude,
					html: '<div style="width: 300px;"><h4 style="margin-bottom: 8px;">'+$google_place+'</h4></div>',
					icon: {
						image: "images/icons/map-icon-red.png",
						iconsize: [32, 39],
						iconanchor: [32,39]
					}
				}
			],
			doubleclickzoom: false,
			controls: {
				panControl: true,
				zoomControl: true,
				mapTypeControl: true,
				scaleControl: false,
				streetViewControl: false,
				overviewMapControl: false
			}

		});

	</script>
<script type="text/javascript">

		jQuery(window).load(function(){

			var $container = $('#posts');

			$container.isotope({
				itemSelector: '.entry',
				masonry: {
					columnWidth: '.entry:not(.entry-date-section)'
				}
			});
			/*
			$container.infinitescroll({
				loading: {
					finishedMsg: '<i class="icon-line-check"></i>',
					msgText: '<i class="icon-line-loader icon-spin"></i>',
					img: "images/preloader-dark.gif",
					speed: 'normal'
				},
				state: {
					isDone: false
				},
				nextSelector: "#load-next-posts a",
				navSelector: "#load-next-posts",
				itemSelector: "div.entry",
				behavior: 'portfolioinfiniteitemsloader'
			},
			function( newElements ) {
				$container.isotope( 'appended', $( newElements ) );
				var t = setTimeout( function(){ $container.isotope('layout'); }, 2000 );
				SEMICOLON.initialize.resizeVideos();
				SEMICOLON.widget.loadFlexSlider();
				SEMICOLON.widget.masonryThumbs();
				var t = setTimeout( function(){
					SEMICOLON.initialize.blogTimelineEntries();
				}, 2500 );
			});
			*/

			var t = setTimeout( function(){
				SEMICOLON.initialize.blogTimelineEntries();
			}, 2500 );

			$(window).resize(function() {
				$container.isotope('layout');
				var t = setTimeout( function(){
					SEMICOLON.initialize.blogTimelineEntries();
				}, 2500 );
			});

		});

		$(".jRange").each(function(index,e){
			$(e).ionRangeSlider({
				min: $(e).attr('data-min'),
				max: $(e).attr('data-max'),
				step: $(e).attr('data-steps')
			});
			console.log(index,)


    	});

	$(".range_02").ionRangeSlider({


				min: 0,
				max: 10,
				step: 10
			});


	</script>
</body>
</html>
