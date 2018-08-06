<?php 
$data = array ('id'=>'fichasForm', 'class'=>'form-horizontal');
echo form_open($action,$data);

#HIDDENS
echo form_hidden('caballo_id',$caballo_id);
?>
<div class="widget-box">
    <div class="widget-title collapsed" >
        <span class="icon"><i class="icon-medkit"></i></span>
        <h5>Registro Ficha Médica</h5>        
        <a class="label btn btn-primary btn-mini" onclick="" href="javascript:void(0)" data-toggle="collapse" data-target="#collapseTwo">NUEVA REVISIÓN</a>
    </div>
    <div id="collapseTwo" class="widget-content collapse nopadding" style="height: 0px;">
    
    <div class="row-fluid">
        <div class="span3">
            <?php              
            $html = form_input(array('class'=>'datepicker fecha_revision input-small', 'data-date'=>date('d/m/Y'), 'value'=>date('d/m/Y'), 'name'=>'fecha_revision'));
            echo control_group('Fecha Revisión', $html, $attr = array());
            ?>  
        </div>
        <div class="span3">
            <?php              
            $html = form_input(array('class'=>'timepicker hora_revision input-small', 'id'=>'timepicker', 'name'=>'hora_revision'));
            echo control_group('Hora Revisión', $html, $attr = array('class_controls'=>'bootstrap-timepicker'));
            ?>  
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <?php
                $html = frm_multiples_radio($ovariosOpciones,array('name'=>'ovario_izquierdo'));                
                echo control_group('Ovario Izquierdo', $html, $attr = array());
                
                $html = frm_multiples_radio($ovariosOpciones,array('name'=>'ovario_derecho'));                
                echo control_group('Ovario Derecho', $html,$attr = array());
                
                $html = frm_multiples_radio($cervixOpciones,array('name'=>'cervix'));                
                echo control_group('Cervix', $html,$attr = array());
                
                $html = frm_multiples_radio($uteroOpciones,array('name'=>'utero'));                
                echo control_group('Utero', $html,$attr = array());
                
                $html = frm_multiples_radio($accionesMedicasOpciones,array('name'=>'acciones_medicas', 'id'=>'j-accionesMedicas', 'onclick'=>'getOpcionesMedicasExtras(this.value)'));                
                echo control_group('Acciones', $html, $attr = array('id'=>'jAccionesMedicas'));
                
                $html = frm_multiples_radio($drogasOpciones,array('name'=>'droga'));                
                echo control_group('Drogas', $html,$attr = array());
            ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6">
            <?php
                $data = array('name'=>'observaciones','id'=>'observaciones','placeholder'=>'Observaciones', 'class'=>'', 'value'=>'');
                echo control_group('Observaciones', form_textarea($data),$attr = array(),'observaciones');
            ?>
        </div>
        <div class="span3">
            <?php
            $proximaRevision = array(
                array('nombre'=>'+1 día','id'=>'+1'),
                array('nombre'=>'+2 días', 'id'=>'+2'), 
                array('nombre'=>'+3 días', 'id'=>'+3'),
                array('nombre'=>'+4 días', 'id'=>'+4'),
                array('nombre'=>'Otra Fecha', 'id'=>'+n', 'extra_input'=>form_input(array('class'=>'datepicker setFechaMedica input-small', 'data-date'=>date('d/m/Y'), 'value'=>'', 'name'=>'fecha_proxima_revision', 'disabled'=>'disabled'))),
                
            );            
            $html  = frm_multiples_radio($proximaRevision, array('name'=>'fecha_proxima_revision', 'onclick'=>'enableExtraFecha(this.value)'));                             
            echo control_group('Próxima Revisión', $html,$attr = array());
            ?>
        
        
        </div>
        <div class="span3 quick-actions">
            <?php
                        
            $data = array('type'=>'submit', 'value'=>'Guardar', 'class'=>'btn btn-primary btn-large', 'onclick'=>"validateForm('fichasForm')");
            $buttons .= form_input($data);
            $buttons .= br();
            $buttons .= anchor_js('Cancelar', array('data-toggle'=>"collapse", 'data-target'=>"#collapseTwo"));
            
            echo $buttons;
            ?>
        </div>
    </div>
    </div>
</div>

<?php echo form_close(); ?>