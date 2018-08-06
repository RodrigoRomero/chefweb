<!DOCTYPE html>
<html dir="ltr" lang="en-US">
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

				<div class="col_half nobottommargin hidden-xs">

					<p class="nobottommargin"><strong>Whatsapp:</strong> <a href="https://wa.me/+5491167825824" target="_blank">bla bla</a></p>

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

		</section><!-- #content end -->

		<!-- Footer
		============================================= -->
		<footer id="footer" class="dark">



			<!-- Copyrights
			============================================= -->
			<div id="copyrights">

				<div class="container clearfix">

					<div class="col_half">
						<div class="copyright-links"><a href="#">Terms of Use</a> / <a href="#">Privacy Policy</a></div>
					</div>

					<div class="col_half col_last tright">
						<div class="fright clearfix">
							<a href="#" class="social-icon si-small si-borderless si-facebook">
								<i class="icon-facebook"></i>
								<i class="icon-facebook"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless si-twitter">
								<i class="icon-twitter"></i>
								<i class="icon-twitter"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless si-gplus">
								<i class="icon-gplus"></i>
								<i class="icon-gplus"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless si-pinterest">
								<i class="icon-pinterest"></i>
								<i class="icon-pinterest"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless si-vimeo">
								<i class="icon-vimeo"></i>
								<i class="icon-vimeo"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless si-github">
								<i class="icon-github"></i>
								<i class="icon-github"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless si-yahoo">
								<i class="icon-yahoo"></i>
								<i class="icon-yahoo"></i>
							</a>

							<a href="#" class="social-icon si-small si-borderless si-linkedin">
								<i class="icon-linkedin"></i>
								<i class="icon-linkedin"></i>
							</a>
						</div>

						<div class="clear"></div>
							<i class="icon-envelope2"></i>
						<?php
						$attributes = ["title"=>'Hablemos'];
						$string = 'Hablemos';
						echo safe_mailto('hola@rodrigoromero.life', $string, $attributes) ?>
						  <span class="middot">&middot;</span> <i class="icon-headphones"></i> +91-11-6541-6369 <span class="middot">&middot;</span>
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