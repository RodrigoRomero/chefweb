<?php 
$data = array ('id'=>'fichasForm', 'class'=>'form-horizontal');
echo form_open($action,$data);

#HIDDENS
echo form_hidden('caballo_id',$caballo_id);
?>

<div class="widget-box">
    <?php $this->view('layout/fichas/fichaMedicaHeader', array('title'=>'Registro Ficha Semen', 'button_title'=>'NUEVA EXTRACCIÓN')) ?>
    <div id="collapseTwo" class="widget-content collapse nopadding" style="height: 0px;">
    <div class="row-fluid">
        <div class="span3">
            <?php              
            $html = form_input(array('class'=>'datepicker fecha_revision input-small', 'data-date'=>date('d/m/Y'), 'value'=>date('d/m/Y'), 'name'=>'fecha_revision'));
            echo control_group('Fecha Extracción', $html, $attr = array());
            ?>  
        </div>
        <div class="span3">
            <?php              
            $html = form_input(array('class'=>'timepicker hora_revision input-small', 'id'=>'timepicker', 'name'=>'hora_revision'));
            echo control_group('Hora Extracción', $html, $attr = array('class_controls'=>'bootstrap-timepicker'));
            ?>  
        </div>
    </div>
    <div class="row-fluid">
        <div class="span3">
            <?php              
            $html = form_input(array('class'=>'input-small', 'value'=>"", 'name'=>'numero_salto', "type"=>'number'));
            echo control_group('Número Salto', $html, $attr = array());
            ?>  
        </div>
        <div class="span3">
            <?php              
            $data = array('name'=>'gel','id'=>'gel', 'class'=>'', 'type'=>'checkbox');
            echo control_group('Gel', form_input($data),$attr = array());
            ?>  
        </div>        
    </div>
    <div class="row-fluid">
        <div class="span3">
            <?php              
            $html = form_input(array('class'=>'input-small', 'value'=>"", 'name'=>'volumen_ml'));
            echo control_group('Vol. (ml)', $html, $attr = array());
            ?>  
        </div>        
        <div class="span3">
            <?php              
            $html = form_input(array('class'=>'input-small', 'value'=>"", 'name'=>'vigor'));
            echo control_group('Vigor', $html, $attr = array());
            ?>  
        </div>
        <div class="span3">
            <?php              
            $html = form_input(array('class'=>'input-small', 'value'=>"", 'name'=>'concentracion'));
            echo control_group('Concentración', $html, $attr = array());
            ?>  
        </div>
    </div>
    <div class="row-fluid">
        <div class="span3">
            <?php              
            $html = form_input(array('class'=>'input-small', 'value'=>"", 'name'=>'motilidad_total'));
            echo control_group('Motilidad Total', $html, $attr = array());
            ?>  
        </div>        
        <div class="span3">
            <?php              
            $html = form_input(array('class'=>'input-small', 'value'=>"", 'name'=>'motilidad_progresiva'));
            echo control_group('Motilidad Progresiva', $html, $attr = array());
            ?>  
        </div>
        <div class="span3">
            <?php              
            $html = form_input(array('class'=>'input-small', 'value'=>"", 'name'=>'motilidad_circular'));
            echo control_group('Motilidad Circular', $html, $attr = array());
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