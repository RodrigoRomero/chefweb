<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8"/>

    <?php $this->load->view('layout/head.php')?>

</head>

<body>
        <!-- start: Header -->

	<div class="navbar">

		<div class="navbar-inner">

			<div class="container-fluid">

				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

				</a>

				<a id="main-menu-toggle" class="hidden-phone open"><i class="icon-reorder"></i></a>

				<div class="row-fluid">

				    <a class="brand span2" href="<?php echo base_url()?>"><span>Orsonia</span></a>

				</div>

				<!-- start: Header Menu -->

				<?php echo $menu_top ?>

				<!-- end: Header Menu -->



			</div>

		</div>

	</div>

	<!-- start: Header -->

    <div class="container-fluid-full">

        <div class="row-fluid">

            <!-- start: Main Menu -->

            <?php echo $menu ?>



			<!-- end: Main Menu -->



			<!-- start: Content -->

			<div id="content" class="span10">

            <?php

                echo '<div id="breadcrumb">'.$this->breadcrumb->makeBread().'</div>';

                $flashData = $this->session->flashdata('insert_success');



                $langs = $this->config->item("languages");

                if( (count($langs)>1) && $multilang==true){

                    $this->view('layout/langchange', array('langs'=>$langs));

                }

                ?>

                <div class="row-fluid">

                    <div class="span12" id="jMessages">

                    <?php

                    if(!empty($flashData)){

                        $this->view('alerts/success', array('success'=>$flashData));

                    }

                    ?>

                    </div>

                </div>

    			<div class="j-module" style="min-height: 600px;">

                    <?php echo $module ?>

                </div>

            </div>

            <div class="clearfix"></div>

            <footer>

                    <p>

                        <span style="text-align:left;float:left">&copy; <?php echo date('Y') ?> - <a href="http://www.orsonia.com.ar" title="Orsonia Digital :: Ideas que te vuela la peluca">Orsonia Digital <span class="hidden-phone">:: Ideas que te vuela la peluca</span></a></span>

                    </p>



                </footer>

        </div>

    </div>

 </body>
</html>

