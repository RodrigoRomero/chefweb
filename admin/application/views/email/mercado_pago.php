<?php
$fecha_inicio = explode(" ",$evento->fecha_inicio);
$fecha_cierre = explode(" ",$evento->fecha_baja);
$hora_inicio  = substr($fecha_inicio[1],0,-3);
$hora_cierre  = substr($fecha_cierre[1],0,-3);
$fecha_inicio_array = explode("-", $fecha_inicio[0]);
$fecha_cierre_array = explode("-", $fecha_cierre[0]);


$table = "width:600px;
         border: none;
         border-collapse: collapse;
         margin: 0 auto;
         font-family: arial, verdana, sans-serif;
         font-size: 14px;
         background: #F6F6F6;
         text-align: center;
         display:inline-block";

$p = "font-size:12px;
      color:#292C28;
      margin: 10px;
      text-align: left;";

$btn = "background: none repeat scroll 0 0 #62AF66;
        border: 2px solid #5f6464;
        color: #FFFFFF;
        display: inline-block;
        font-size: 14px;
        font-weight: bold;
        margin: 10px auto;
        padding: 10px;
        text-decoration: none;
        text-transform: uppercase;";

?>

<table width="600" cellpadding="0" cellspacing="0" style="<?php echo $table ?>">
    <tr>
        <td colspan="3">
            <p style="<?php echo $p ?>"><?php echo $user_info->nombre.' '.$user_info->apellido ?><br/>
            Usted ha solicitado el cambio de medio de pago para abonar las entradas al evento <?php echo $evento->nombre ?> a llevarse a cabo el día <?php echo $fecha_inicio_array[2] ?> de <?php echo strtoupper(getMes($fecha_inicio_array[1])) ?>.<br/>
            Si usted no solicitó el cambio de medio de pago, deje sin efecto este aviso.<br/>
            Presione en el siguiente link para acceder a pagar con Mercado Pago.</p>
             <a href="<?php echo config_item("front_url").'/cart/restore/'.$order_info->salt ?>" style="<?php echo $btn ?>">Realizar Pago</a><br/>
            <p style="<?php echo $p ?>">Muchas gracias</p>

        </td>

    </tr>









</table>









