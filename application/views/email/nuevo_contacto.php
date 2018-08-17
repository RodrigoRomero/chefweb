<?php
$json = json_decode($values['json']);
?>

<table cellpadding="0" cellspacing="0">
    <tr class="information">
        <td>
        	<p>Nueva consulta a través de la web</p>
            <p>Nombre y Apellido: <?php echo $values['nombre'].' '.$values['apellido'] ?><br/>
            Usuario: <?php echo $values['email'] ?></p>
            <p>Mensaje: <?php echo $json->message ?></p>
        </td>
    </tr>
</table>