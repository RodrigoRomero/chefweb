<tr>
	<?php

	$form_name = 'nominar-form-'.$item->id.'-'.$row;
	$hidden = array('ot_id'=>$item->id, 'row'=>$row);
	$data   = array ('id'=>$form_name);
	$action =  base_url('/account/nominar/'.$item->id.'/'.$row);
	echo form_open($action,$data,$hidden);

	$nominado = $this->db->get_where('acreditados', ['order_ticket_id' => $item->id, 'row'=>$row])->row();

	$show_hide = ($nominado->email) ? '' : 'hide';
	$row = 'tir-'.$item->ticket_id.$row;

	?>
	<td >

	<input type="text" id="nominar-nombre" name="nombre" value="<?php echo ($nominado->nombre) ? $nominado->nombre : '' ?>" class="form-control required" />
	</td>
	<td><input type="text" name="apellido" class="form-control required" value="<?php echo ($nominado->apellido) ? $nominado->apellido : '' ?>"></td>
	<td><input type="text" name="email" class="form-control required email" value="<?php echo ($nominado->email) ? $nominado->email : '' ?>"></td>
	<td>
		<button class="button button-mini" id="<?php echo $form_name ?>"  onclick="validateForm('<?php echo $form_name ?>')"><i class="icon-edit"></i>Nominar</button>
	</td>
	<?php echo form_close() ?>
	<td id="<?php echo $row ?>">

		<a href="javascript:void(0)" onclick="sendInvite($(this))" class="button button-mini <?php echo $show_hide?>" data-acreditacion="<?php echo $nominado->id ?>"><i class="icon-envelope"></i>Invitar</a>

	</td>
</tr>
