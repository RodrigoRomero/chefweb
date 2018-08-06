<?php echo $this->load->view('accounts/partials/menu_account',[],true); ?>



		<div class="col_two_third col_last">

			<div class="heading-block noborder">
				<h3><?php echo $customer->nombre.' '.$customer->apellido?></h3>
			</div>



				<div class="col_full">
					<h4>Mis Pedidos</h4>
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Cantidad</th>
								<th class="hidden-xs">Total</th>
								<!-- <th class="hidden-xs">Descuentos</th> -->
								<!-- <th class="hidden-xs">Final</th> -->
								<th>Status</th>
								<th>Ver Detalle</th>
							</tr>
						</thead>
						<tbody>
						<?php
							foreach($orders as $order) {

							$row_color = '';
							$status = '';
							switch($order->status){
								case 1:
								case '1':
									$row_color = 'warning';
									$status = 'Pendiente';
								break;

								case 2:
								case '2':
									$row_color = 'info';
									$status = 'En Proceso';
								break;

								case 3:
								case "3":
									$row_color = 'info';
									$status = 'Listo para Entregar';
								break;

								case 4:
								case "4":
								case 5:
								case "5":
									$row_color = 'success';
									$status = 'Entregado';
								break;

								case '-1':
								case -1:
									$row_color = 'danger';
									$status = 'Cancelada';
								break;


								default:
									$nominar_link = false;
									$row_color = '';
								break;
							}

						?>


							<tr>
								<td><?php echo $order->id ?></td>
								<td><?php echo $order->qty ?></td>
								<!-- <td class="hidden-xs">$ <?php echo number_format($order->total_price, 2,",",".") ?></td>
								<td class="hidden-xs">$ <?php echo number_format($order->discount_amount, 2,",",".") ?></td> -->
								<td class="hidden-xs">$ <?php echo number_format($order->total_discounted_price, 2,",",".")  ?></td>

								<td><span class="label label-<?php echo $row_color?>"><?php echo $status ?></span></td>
								<td>
								<a href="<?php echo base_url('/mi-pedido/'.$order->id) ?>"><i class="i-plain icon-eye i-small" style=""></i></a>

								</td>
							</tr>
						<?php } ?>

						</tbody>
					</table>
				</div>
		</div>
	</div>

