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
            <p style="<?php echo $p ?>"><?php echo $acreditado_info->nombre.' '.$acreditado_info->apellido ?><br />
            Su inscripción al evento <?php echo $evento->nombre ?> ha sido confirmada. aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa<br />
            <strong>Lo esperamos el <?php echo $fecha_inicio_array[2] ?> de <?php echo strtoupper(getMes($fecha_inicio_array[1])) ?> <?php echo $hora_inicio ?>Hs. <?php echo $evento->lugar ?></strong><br />
            </p>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo up_asset('barcodes/'.$acreditado_info->barcode.'.png', array('style'=>'display: block; margin: 0 auto;')) ?>
        </td>
    </tr>
    <tr>
        <td style="padding: 10px 0; border-top: 2px solid #ebebeb; border-bottom: 2px solid #ebebeb" colspan="3">
            <p style="text-transform: uppercase; text-align: center; color: #ce5c5f; font-size: 34px; font-weight: bold; margin: 0"><?php echo $evento->nombre ?></p>
        </td>
    </tr>
    <tr style="border-bottom: 2px solid #ebebeb;">
        <td style="width: 33%;">
            <?php if($fecha_inicio[0] == $fecha_cierre[0]) { ?>
            <p style="margin: 0; text-align: center; color: #444242; font-size: 30px;"><span style="font-weight: bold; font-size: 58px"><?php echo $fecha_inicio_array[2] ?></span><br /><?php echo strtoupper(getMes($fecha_inicio_array[1])) ?></p>
            <?php } ?>
        </td>
        <td style="width: 33%;">
            <table style="width: 80%; border-left: 2px solid #ebebeb; border-right: 2px solid #ebebeb; margin: 0 auto; padding:0 10%; color: #444242; font-size: 12px;">
                <tr>
                    <td style="border-bottom: 2px solid #ebebeb; padding: 10px 0; "><b>Desde</b> <?php echo $hora_inicio ?>Hs.</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0;"><b>Hasta</b> <?php echo $hora_cierre?>Hs.</td>
                </tr>
            </table>
        </td>
        <td style="width: 33%; text-align: center;">
            <p style="font-weight: bold; margin: 0;"><?php echo $evento->lugar ?></p>
            <p style="margin: 0;"><?php echo $evento->direccion ?></p>
        </td>
    </tr>
</table>
