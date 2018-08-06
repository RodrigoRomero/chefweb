<!--tableHeader-->
 <thead>
<tr class="">
		<th>Ticket</th>
    <th>Nombre</th>
    <th>Apellido</th>
    <th>Email</th>
    <th>Barcode</th>
    <th>Acreditó</th>
    <th>Fecha Registro</th>
</tr>
</thead>
<tbody>


<!-- #tableHeader -->

<?php foreach ($acreditados as $key => $row) { ?>
<tr>
			<td><?php echo $row->ticket_name ?></td>
      <td><?php echo $row->nombre ?></td>
      <td><?php echo $row->apellido ?></td>
      <td><?php echo $row->email ?></td>
      <td><?php echo $row->barcode ?></td>
      <td><?php
      echo ($row->acreditado) ? 'Acreditado' : 'No Acreditado';
      ?></td>
      <td><?php
      echo $row->fa;
      ?></td>
</tr>
<?php }  ?>
</tbody>
