<table cellpadding="0" cellspacing="0">
    <tr class="information">
        <td>
        	<p>Hola <?php echo $customer ?></p>
            <p>Si haz solicitado recuperar tu contraseña por favor haz click en el siguiente enlace, de lo contrario desestima este email.</p>
            <p><a href="<?php echo base_url('/recuperar-password/'.$token) ?>">Recuperar Contraseña</a></p>
        </td>
    </tr>
</table>