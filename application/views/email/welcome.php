<table cellpadding="0" cellspacing="0">
    <tr class="information">
        <td>
        	<p>Hola <?php echo $customer['nombre'].' '.$customer['apellido'] ?></p>
            <p>Bienvenido a Rodrigo Romero Hamburguesas Veganas. Acabas de registrarte en nuestra web.<br/>
            La web es una herramienta donde podras realizar tus pedidos, realizar el seguimiento de los mismos y enterarte de novedades y ofertas.</p>
            <p>Tus datos de acceso son:<br/>
            Usuario: <?php echo $customer['email'] ?><br/>
            Password: <?php echo word_censor($customer['password'], [$customer['password']], '******') ?>
            </p>
        </td>
    </tr>
</table>