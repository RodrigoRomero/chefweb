<?php
$cart = json_decode($order_info->full_cart);
$ticket_options = array();
$ticket_name_options = array();
$user_info_qty_ticket = 0;
$user_info_ticket_monto = 0;
$user_info_ticket_name = '';
$user_info_almuerzo = 0;
foreach($tickets as $tkt){
	$tiket_name_options[$tkt->nombre] = $tkt->nombre;
	$ticket_options[$tkt->precio_regular] = $tkt->precio_regular;
	$ticket_options[$tkt->precio_oferta] = $tkt->precio_oferta;
}

ksort($ticket_options);

foreach($cart as $cart_items){
	if($cart_items->options->ticket_id == $user_info->id_ticket){
		$user_info_ticket_name = $cart_items->name;
		$user_info_qty_ticket = $cart_items->qty;
		$user_info_ticket_monto = $cart_items->price;
	}

	if($cart_items->name == 'almuerzo'){
		$user_info_almuerzo = $cart_items->subtotal;
	}
}

$data = array ('id'=>'eventosForm', 'class'=>'form');
echo form_open($action,$data);





?>
<div class="row-fluid">
	<div class="box span12">
		<?php $this->load->view('layout/panels/box_header', array('title'=>'Ordenes', 'icon'=>'icon-pencil')) ?>
		<?php $this->load->view('alerts/error') ?>
	</div>
</div>
<div class="row-fluid">
	<div class="box span12">
		<?php $this->load->view('layout/panels/box_header', array('title'=>'Datos Generales', 'icon'=>'icon-pencil')) ?>
		<div class="box-content">
		<div class="row-fluid">
			<div class="span7">                <div class="row-fluid">
					<div class="span12">
						<h1>Order #<?php echo $order_info->id ?></h1>
					</div>
				</div>
				 <div class="row-fluid">

					<div class="span12">
						<p><?php echo $customer_info->nomnbre.' '.$customer_info->apellido ?></p>
						<p><?php echo $customer_info->email ?></p>
					</div>
				</div></div>
				<div class="box span5">

		<div class="row-fluid">
			<div class=" span12">
				<?php $this->load->view('layout/panels/box_header', array('title'=>'Datos Pago', 'icon'=>'icon-money', 'subaction'=>false)) ?>
				<div class="box-content">
					<div class="form_container">
						<?php


						$data = array('transferencia_bancaria'  => 'Transferencia Bancaria',
									  'mercado_pago'         	=> 'Mercado Pago',
									  'FOC'      				=> 'Free of Charge',
									  'Efectivo' 				=> 'Efectivo'
									  );


						echo control_group('Medio de Pago', form_dropdown('medio_pago',$data, $order_info->gateway),$attr = array());


						$data = array('approved'        => 'Aprobado',
									  'pending'         => 'Pendiente',
									  'in_process'      => 'En Proceso',
									  'in_progress'     => 'En Progreso',
									  'rejected'        => 'Rechazado',
									  'refunded'        => 'Devuelto al usuario',
									  'cancelled'       => 'Cancelado',
									  'in_mediation'    => 'En Mediación',
									  );
						echo control_group('Pago Status', form_dropdown('payment_status',$data, $pago_info->status),$attr = array());

						 $data = array('1'      => 'Pendiente',
									   '2'      => 'En Proceso',
									   '3'		=> 'En Entrega',
									   '4'		=> 'Entrada',
									   '5'		=> 'Archivada',
									  '-1'      => 'Cancelada'
									  );
						echo control_group('Order Status', form_dropdown('status',$data, $order_info->status),$attr = array());


						$fecha = getFechaView($order_info->fecha_delivery);
                    	$html  = '<div class="span6"><span class="add-on"><i class="icon-calendar"></i></span>'.form_input(array('class'=>'j-datepicker', 'data-date'=>date('d/m/Y'), 'value'=>$fecha, 'name'=>'fecha_delivery')).'</div>';
                    	echo control_group('Fecha Delivery', $html, $attr = array('class_controls'=>'', 'prepend'=>''));
						?>
					</div>
				</div>
			</div>
		</div>



	</div>
		</div>



			<div class="row-fluid">
	<div class="box span12">
		<?php $this->load->view('layout/panels/box_header', array('title'=>'Detalle Compra', 'icon'=>'icon-pencil')) ?>
		<div class="box-content">
			<div class="form_container">
				<table class="table table-condensed">
					<?php $this->load->view('panels/cart/cart', array('full_cart'=>$cart, 'total'=>$order_info->total_discounted_price)) ?>
				</table>
			</div>
		</div>
	</div>
</div>



		</div>
	</div>

</div>





<div class="row-fluid">
	<div class="box span12">
		<div class="box-content">
			<div class="form_container">
				<?php
				$buttons = '';
				$buttons .= '<span class="pull-left">';
				$data = array('type'=>'submit', 'value'=>'Guardar', 'class'=>'btn btn-primary', 'onclick'=>"validateForm('eventosForm')", 'style' =>'margin-right: 10px');
				$buttons .= form_input($data);
				$buttons .= anchor($back,'Cancelar',array('class'=>'btn btn-inverse'));
				$buttons .= '</span>';
				echo form_action($buttons);
				echo form_close();
				?>
			</div>
		</div>
	</div>
</div>
