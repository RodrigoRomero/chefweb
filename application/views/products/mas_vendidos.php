<div class="heading-block">
	<h2>+ Vendidos</h2>
</div>


<div id="shop" class="shop grid-container clearfix" data-layout="fitRows">

<?php
$hoy = strtotime($this->today);
foreach($mas_vendidos as $product) {
	$file_name = 'products/original/'.$product->id.'_0.jpg';
	$timelimit = strtotime($product->fecha_baja);
	$data_price = (!empty($item->precio_oferta) && ($hoy < $timelimit)) ? $item->precio_oferta : $item->precio_regular;

	$link = '/productos/'.url_title($product->nombre,'-',true).'/'.$product->id;

?>
	<div class="product clearfix">
		<div class="product-image">

			<a href="<?php echo base_url($link); ?>" alt="<?php echo $product->nombre ?>" title="<?php echo $product->nombre ?>"><?php echo up_asset($file_name, ['alt' =>  $product->nombre, 'title'=> $product->nombre]); ?></a>

			<?php  if(!empty($product->precio_oferta) &&
		    	      ($hoy < $timelimit) &&
		    	      $product->precio_regular > $product->precio_oferta) { ?>
			<div class="sale-flash">Oferta</div>
		<?php } ?>
			<div class="product-overlay">

				<a href="<?php echo base_url($link); ?>" class="item-quick-view" alt="<?php echo $product->nombre ?>" title="<?php echo $product->nombre ?>"><i class="icon-zoom-in2"></i><span>Ver Detalle</span></a>
			</div>
		</div>
		<div class="product-desc">
			<div class="product-title"><h3><a href="<?php echo base_url($link); ?>" ><?php echo $product->nombre ?></a></h3></div>

			<div class="product-price">

		    <?php  if(!empty($product->precio_oferta) &&
		    	      ($hoy < $timelimit) &&
		    	      $product->precio_regular > $product->precio_oferta) { ?>
    	      	<span class="price-unit">$</span><?php echo number_format($product->precio_oferta, 0, ",", ". ") ?> - <span class="price-tenure"><del>$ <?php echo number_format($product->precio_regular, 2, ",", ". ") ?></del></span>
	   		<?php } else { ?>
	   			 <span class="price-unit">$</span><?php echo number_format($product->precio_regular, 0, ",", ". ") ?>
	   		<?php } ?>
	   		</div>
		</div>
	</div>
<?php } ?>

</div>