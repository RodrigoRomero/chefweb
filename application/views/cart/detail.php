<table class="table cart">
	<thead>
		<tr>
			<?php if($delete) { ?>
			<th class="cart-product-remove">&nbsp;</th>
			<?php } ?>
			<th class="cart-product-name">Entradas</th>
			<!-- <th class="cart-product-quantity">Packs</th> -->
			<th class="cart-product-quantity">Cantidad</th>
			<th class="cart-product-price">Precio Unitario</th>
			<th class="cart-product-subtotal">Total</th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach ($this->cart->contents() as $key => $row) {
	$discount = ( preg_match('/^code/', $row['id'], $matches) === 1) ? 'discount' : '';
	?>
		<tr class="cart_item">
			<?php if($delete) { ?>
			<td class="cart-product-remove">
				<a ref="javascript:void(0)" onclick="removeFromCart('<?php echo $row['rowid'] ?>')" class="remove" title="Remove this item"><i class="icon-trash2"></i></a>
			</td>
			<?php } ?>
			<td class="cart-product-name"><?php echo $row['name'] ?></td>
			<!-- <td class="cart-product-quantity"><?php echo $row['options']['packs'] ?></td> -->
			<td class="cart-product-quantity"><?php echo $row['qty'] ?></td>
			<td class="cart-product-price">
				<span class="amount">$ <?php echo number_format($row['price'], 2,",",".")  ?></span>
			</td>


			<td class="cart-product-subtotal">$ <?php echo number_format(round($row['subtotal']), 2,",",".") ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
