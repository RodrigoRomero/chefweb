<?php

$discount_total =  0;
$total_price    = 0;
foreach($this->cart->contents() as $product){
	$discount = ( preg_match('/^code/', $product['id'], $matches) === 1) ? 'discount' : '';
	if($discount){

		$discount_total += $product['subtotal'];
	} else {
		$total_price += $product['subtotal'];
	}
}


?>


<table class="table cart">
	<tbody>
		<tr class="cart_item">
			<td class="cart-product-name">
				<strong>Subtotal</strong>
			</td>

			<td class="cart-product-name">
				<span class="amount">$ <?php echo number_format(round($total_price), 2,",",".") ?></span>
			</td>
		</tr>
		<?php if($discount_total < 0) {  ?>
		<tr class="cart_item">
			<td class="cart-product-name">
				<strong>Descuentos</strong>
			</td>

			<td class="cart-product-name">
				<span class="amount text-danger">($ <?php echo number_format(round($discount_total), 2,",",".") ?>)</span>
			</td>
		</tr>
		<?php } ?>
		<tr class="cart_item">
			<td class="cart-product-name">
				<strong>Total</strong>
			</td>
			<td class="cart-product-name">
				<span class="amount color lead"><strong>$ <?php echo number_format(round($this->cart->total()), 2,",",".") ?></strong></span>
			</td>
		</tr>
	</tbody>
</table>
