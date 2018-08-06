<?php 
$json = json_decode($data->json);
if( is_array($json->padrillo_asignado)) {
    $padrillos_asignados_nombres = array();    
    foreach($json->padrillo_asignado as $padrillo){
            $padrillos_asignados_nombres[] =  $padrillo->nombre;
    }
    $padrillos_asignados_nombres = implode(", ",$padrillos_asignados_nombres);
}

?>
<div class="row-fluid">    
    <div class="span4 fichaMedicaCabeceras">
        <ul>
        	<li><span class="b">Temporada:</span> 2013/2014</li>
            <li><span class="b">Pelaje:</span> <?php echo $json->pelaje->nombre ?></li>
            <li><span class="b">Propietario:</span> <?php echo $json->propietario->nombre ?></li>
        </ul>
    </div>
    <div class="span4 fichaMedicaCabeceras">
    	<ul>
        	<li><span class="b">Fecha de Ingreso:</span> 2013/2014</li>
            <?php if($this->params['c']==2) { ?>
            <li><span class="b">Preñeces Solicitadas:</span> <?php echo $data->preneces_solicitadas?></li>
            <?php if (!empty($padrillos_asignados_nombres)){ 
                echo '<li><span class="b">Padrillos Asignados:</span> '.$padrillos_asignados_nombres.'</li>';
            } ?>
            
            <?php } ?>
        </ul>
    </div>
    <div class="span4 txt-center">
        <?php if($this->params['c']!=1){ ?>            
            <h2>OVACION 65</h2>
        <?php } else { ?>
            <h1><?php echo $data->nombre ?></h1>
        <?php }?>
    </div>
</div>