<?php
$hoy = strtotime($this->today);
$timelimit = strtotime($producto->fecha_baja);
$form_name = 'addProductForm_'.$producto->id;
$ingredientes = json_decode($producto->descripcion);
$fecha_venta = explode("-",$producto->fecha_baja);
$fecha_venta = implode("-",array($fecha_venta[2], getMes($fecha_venta[1]), $fecha_venta[0]));
$data   = array ('id'=>$form_name, 'class'=>'form relative');
$action = base_url('cart/add');
$data_price = (!empty($producto->precio_oferta) && ($hoy < $timelimit)) ? $producto->precio_oferta : $producto->precio_regular;

$step = 1;
$start = 0;
$end = 10;
if($producto->min_qty == 0  && $producto->max_qty == 0 ){
    $step = 1;
} elseif($producto->min_qty == 24 && $producto->max_qty == 0 ) {

    $step = $producto->min_qty;
    $end = ($producto->min_qty*$end);
} elseif($producto->min_qty>0 && $producto->max_qty == 0 ) {
    $step = $producto->min_qty;
} elseif($producto->min_qty>0 && $producto->max_qty > 0 ) {
     $step = 1;
     $start = $producto->min_qty;
     $end = $producto->max_qty;
}

$options = array_combine(range($start, $end, $step),range($start, $end, $step));

if(!array_key_exists ( 0 , $options )){
    $options[0] = 0;
}
ksort($options);


?>

<div class="col_three_fourth product" itemscope itemtype="http://schema.org/Product">
	<div class="col_half">

		<!-- Product Single - Gallery
		============================================= -->
		<div class="product-image">
			<div class="fslider" data-pagi="false" data-arrows="false" data-thumbs="false">
				<div class="flexslider">
					<div class="slider-wrap" data-lightbox="gallery">
						<div class="slide" data-thumb="<?php echo up_file('products/thumbs/'.$producto->id.'_0.jpg') ?>">
							<a href="<?php echo up_file('products/original/'.$producto->id.'_0.jpg') ?>" title="<?php echo $producto->nombre ?>" data-lightbox="gallery-item"><img itemprop="image" src="<?php echo up_file('products/original/'.$producto->id.'_0.jpg') ?>" alt="<?php echo $producto->nombre ?>"></a>
						</div>
					</div>
				</div>
			</div>
			<!-- <div class="sale-flash">Sale!</div> -->
		</div><!-- Product Single - Gallery End -->

		<div class="panel panel-default product-meta topmargin">
			<div class="panel-body">
				<span itemprop="productID" class="sku_wrapper">Código Producto: <span class="sku"><?php echo $producto->sku ?></span></span>
			</div>

		</div>

		<ul class="iconlist">
			<?php foreach($ingredientes as $ingredient) { ?>
			<li><i class="icon-caret-right"></i><?php echo $ingredient ?></li>
			<?php } ?>
		</ul>






	</div>
	<div class="col_half col_last">
		<h3 itemprop="name"><?php echo $producto->nombre ?></h3>
		<div class="product-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
					<meta itemprop="priceCurrency" content="ARS" />
		<?php  if(!empty($producto->precio_oferta) &&
		($hoy < $timelimit) &&
		$producto->precio_regular > $producto->precio_oferta) { ?>


			<span class="price-unit">$</span><?php echo number_format($producto->precio_oferta, 0, ",", ". ") ?> - <span class="price-tenure"><del>$ <?php echo number_format($producto->precio_regular, 2, ",", ". ") ?></del></span><br>
			<small class="price-tenure">Precio Oferta Válido hasta : <?php echo $fecha_venta ?></small>
		<?php } else { ?>
			<span class="price-unit">$</span><span itemprop="price"><?php echo number_format($producto->precio_regular, 0, ",", ". ") ?></span>
		<?php } ?>
		</div>
		<p class="topmargin" itemprop="description"><?php echo nl2br($producto->bajada) ?></p>

		<!--  -->
<!--
		<div class="panel panel-default product-meta">
			<div class="panel-body">
				<span itemprop="productID" class="sku_wrapper">Código Producto: <span class="sku"><?php echo $producto->sku ?></span></span>
			</div>
		</div> -->

		<!-- <ul class="iconlist">
			<?php foreach($ingredientes as $ingredient) { ?>
			<li><i class="icon-caret-right"></i><?php echo $ingredient ?></li>
			<?php } ?>
		</ul> -->

		<?php
		if($item->agotadas) {

		} else {
		echo form_open($action,$data);
		echo form_hidden('sku', $producto->sku);
		echo '<div class="form-group">';
		echo '<label for="quantity">Seleccione Cantidad:</label>';
		$css = 'class="form-control"';
		echo form_dropdown('quantity',$options, 0,  $css);
		echo '</div>';
		echo '<input type="submit" value="Comprar"  class="button button-rounded button-xlarge btn-block nomargin" onclick="validateForm(\''.$form_name.'\')" />';
		echo form_close();
		}
		?>
		<div class="line"></div>
		<div class="masonry-thumbs">

				<a onclick="javascript:void(0)" data-lightbox="gallery-item">
					<?php echo image_asset('100-vegano.png') ?>
				</a>
				<a onclick="javascript:void(0)" data-lightbox="gallery-item">
					<?php echo image_asset('sin-gluten.png') ?>
				</a>
		</div>
	</div>
</div>

<div class="col_one_fourth col_last">
	<!-- <?php ep($relacionados) ?> -->
	<div class="widget clearfix">

		<h4>Recomendados</h4>
		<div id="Popular-item">
			<?php foreach($relacionados as $relacionado) {
				$link = '/productos/'.url_title($relacionado->nombre,'-',true).'/'.$relacionado->id;
				$file_name = 'products/thumbs/'.$relacionado->id.'_0.jpg';

				?>
				<div class="spost clearfix">
				<div class="entry-image">
					<a href="<?php echo base_url($link); ?>"><?php echo up_asset($file_name, ['alt' =>  $relacionado->nombre, 'title'=> $relacionado->nombre]); ?></a>
				</div>
				<div class="entry-c">
					<div class="entry-title">
						<h4><a href="<?php echo base_url($link); ?>"><?php echo $relacionado->nombre ?></a></h4>
					</div>
					<ul class="entry-meta">

						<li><i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star3"></i> <i class="icon-star-half-full"></i></li>
					</ul>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class="widget clearfix">
		<?php echo $this->load->view('institucional/testimonios','',true) ?>
	</div>
</div>