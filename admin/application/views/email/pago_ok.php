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

            <p style="<?php echo $p ?>"><?php echo $user_info->nombre.' '.$user_info->apellido ?><br />

           Este email confirma que el pago realizado para el evento <?php echo $evento->nombre ?> a llevarse a cabo el día <?php echo $fecha_inicio_array[2] ?> de <?php echo strtoupper(getMes($fecha_inicio_array[1])) ?>. fue aprobado.<br/>


    </p>
 <p style="<?php echo $p ?>">
            En caso de que haya comprado más de 1 ticket para el evento, para confirmar la inscripción de las entradas, deberá  ingresar los datos de cada uno de los asistentes siguiendo estos pasos: <br>
	            1. Haga click <a href="http://argentinavision2020.com/2018/account/summary"> AQUI </a> y complete los datos de su cuenta con su email y la password que utilizó para registrarse <br/>
	            2. Presione el botón que dice <b>"NOMINAR"</b> y por último <b>"INVITAR"</b> <br/>
	            
	            Si usted adquirió sólo 1 ticket no deberá hacer nada más.<br/>
          Muchas gracias.
    </p>
        </td>

    </tr>

</table>
