<?php
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
            Usted se ha pre-inscripto para participar del evento Argentina Visión 2020. <br />
Confirmando su  registro mediante el aporte del Bono Contribución a BisBlick – Compromiso Social, podemos asegurar su inscripción.<br /> 
Para pagar el bono contribucuón a través de PagoMisCuentas, por favor siga estos pasos:
<br /><br />
    Desde la PC o Cajeros automáticos, ingrese a <a href="http://www.pagomiscuentas.com/" target="_blank">Pagomiscuentas.com</a><br />
            De la solapa SERVICIOS, seleccione la opción DONACIONES<br />
            De la solapa EMPRESAS, seleccione BISBLICK<br />
            Indicá DNI y el monto a donar y aceptá. ¡LISTO!<br /><br />
            Agradecemos enviar el comprobante de transferencia a María Maestre <a href="mailto:mester@bisblick.org">mester@bisblick.org</a> para mayor certeza<br />
            Muchas gracias.</p>
        </td>        
    </tr>
</table>