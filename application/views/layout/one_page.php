<!DOCTYPE html><html dir="ltr" lang="en-US">
<head>

	<?php $this->view('layout/head.php')?>

</head>


<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		<!-- Top Bar
		============================================= -->
		<div id="top-bar">

			<div class="container clearfix">

				<div class="col_half nobottommargin">

					<p class="nobottommargin center"> <a href="<?php echo $this->zap_link ?>" target="_blank"  alt="Whatsapp Rodrigo Romero : Hamburguesas Veganas" title="Whatsapp Rodrigo Romero : Hamburguesas Veganas">Mandanos un <strong>Whatsapp</strong> </a></p>

				</div>

				<div class="col_half col_last fright nobottommargin">

					<!-- Top Links
					============================================= -->
					<div class="top-links">
						<?php echo $this->load->view('layout/partials/toplinks', ['layout'=> 'one_page'], true) ?>
					</div><!-- .top-links end -->

				</div>

			</div>

		</div><!-- #top-bar end -->

		<!-- Header
		============================================= -->
		<header id="header" class="sticky-style-2">

			<div class="container clearfix">
				<?php echo $this->load->view('layout/partials/logos', ['layout'=> 'one_page'], true) ?>
				<ul class="header-extras">
					<li>
						<i class="i-medium i-circled i-bordered icon-truck2 nomargin"></i>
						<div class="he-text">
							Delivery Sin Cargo
							<span>Consultar Zonas</span>
						</div>
					</li>
				</ul>

			</div>

			<div id="header-wrap">
				<?php echo $this->load->view('layout/partials/main_navigation',['layout'=> 'one_page'],true); ?>
			</div>

		</header><!-- #header end -->
		<?php if ($this->page_title) echo $this->load->view('layout/partials/page-title', ['layout'=> 'one_page'], true) ?>
		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap">

<div class="container clearfix">
					<?php echo $module ?>
				</div>

				</div>

			</div>
			<?php echo $this->load->view('layout/partials/social_links', ['layout'=> 'one_page'], true) ?>
		</section><!-- #content end -->

		<!-- Footer
		============================================= -->
		<footer id="footer" class="dark">



			<!-- Copyrights
			============================================= -->
			<div id="copyrights">

				<div class="container clearfix">

					<div class="col_full">
						<div class="fright clearfix">
							<a href="<?php echo $this->insta_link ?>" class="social-icon si-small si-borderless si-instagram" target="_blank" alt="Instagram Rodrigo Romero : Hamburguesas Veganas" title="Instagram Rodrigo Romero : Hamburguesas Veganas">
								<i class="fab fa-instagram"></i>
								<i class="fab fa-instagram"></i>
							</a>

							<a href="<?php echo $this->zap_link ?>" class="social-icon si-small si-borderless si-whatsapp" target="_blank" alt="Whatsapp Rodrigo Romero : Hamburguesas Veganas" title="Whatsapp Rodrigo Romero : Hamburguesas Veganas">
								<i class="fab fa-whatsapp"></i>
								<i class="fab fa-whatsapp"></i>
							</a>

						</div>

						<div class="clear"></div>
					</div>


				</div>

			</div><!-- #copyrights end -->

		</footer><!-- #footer end -->

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

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


</body>
</html>