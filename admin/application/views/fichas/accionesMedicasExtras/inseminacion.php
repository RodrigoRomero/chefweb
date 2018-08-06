

<div class="row-fluid jAccionesMedicasExtras" style="border-bottom: 1px solid #eee">

    <?php if(count($padrillos)>0) { ?>

    <div class="span4">

    <?php

    echo control_group('Padrillo', frm_select('',array('name'=>'padrilloInseminacion'),$padrillos, 1),$attr = array('class'=>'jAccionesMedicasExtras'));

    ?>

    </div>

    <div class="span4">

    <?php

    echo control_group('Tipo de Semen', frm_select('',array('name'=>'tipoSemen'),$semenOpciones,1),$attr = array('class'=>'jAccionesMedicasExtras'));

    ?>

    </div>

    <div class="span4">

    <?php

    $ovariosInseminacion = array(

        array('nombre'=>'Ovario Izquierdo','id'=>'oi'),

        array('nombre'=>'Ovario Derecho', 'id'=>'od'),

    );



    $html = frm_multiples_radio($ovariosInseminacion,array('name'=>'ovarioInseminado'));

    echo control_group('', $html,$attr = array('class'=>'jAccionesMedicasExtras'));

    ?>

    </div>

    <?php } else { ?>

        <div class="container-fluid">

            <div class="row-fluid">

                <div class="span12">

                   <div class="alert">

                    	<button data-dismiss="alert" class="close">×</button>

                        <strong>Aviso!</strong>

                        La donante no posee padrillos asignados.

                        <a href="<?php echo base_url('caballos/asignar-padrillos/c/2/id/'.$this->params['id'])?>" class="ax-modal tip-top" data-toggle="modal" data-original-title="Haga Click para asignar padrillos">Asignar Padrillos</a>

                    </div>

                </div>

            </div>

        </div>

        <script>

            init_tooltips();

        </script>

    <?php }?>

</div>
