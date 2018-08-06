<!--tableHeader-->
 <thead>
<tr class="">
    <th>Tipo de entrada</th>
    <th>$ Precio</th> 
    <th>Cantidad</th>
    <th>Total</th>
</tr> 
</thead>
<tbody>
    

<!-- #tableHeader -->

<?php foreach ($full_cart as $key => $row) { ?>
<tr>
      <td><?php echo $row->name ?></td>
      <td><?php echo $row->price ?></td>
      <td><?php echo $row->qty ?></td>
      <td><?php echo $row->subtotal ?></td>
</tr>
<?php }  ?>
</tbody>
<tr>
    <td colspan="3">Total</td>
    <td><?php echo $total ?></td>
</tr>