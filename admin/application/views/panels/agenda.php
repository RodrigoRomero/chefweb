<?php
$data = array ('id'=>'agendaForm', 'class'=>'form');
echo form_open($action,$data);
$social = json_decode($row->json_socials);
?>
<div class="row-fluid">
    <div class="box span12">
        <?php $this->load->view('layout/panels/box_header', array('title'=>$title, 'icon'=>'icon-pencil')) ?>
        <?php $this->view('alerts/error') ?>

        <div class="box-content">
            <div class="form_container">
                <?php
                $data = array('name'=>'title','id'=>'title','placeholder'=>'Título', 'class'=>'required input-xlarge', 'value'=>$row->title);
                echo control_group($data['placeholder'], form_input($data),$attr = array('append'=>'<a class="icon-question ax-modal tip-right" data-original-title="Ver ayuda" href="'.base_url('helps/general/1').'"></a>'));

                $data = array('name'=>'brief','id'=>'resumen_orador','placeholder'=>'Resúmen', 'data-maxlength'=>'500','class'=>'limited animated  input-xxlarge', 'value'=>$row->brief);
                echo control_group($data['placeholder'], form_textarea($data),$attr = array());

                $data = frm_select('',array('name'=>'orador_id'),$oradores, $row->orador_id,'',false,array(),'','Seleccione Orador');
                echo control_group('Oradores', $data, $attr = array('help-in-label'=>'<a class="fa fa-question ax-modal tip-right" data-original-title="Ver ayuda" href="'.base_url('helps/general/1').'"></a>'));

                $html  = '<div class="span6 bootstrap-timepicker"><span class="add-on"><i class="icon-time"></i></span>'.form_input(array('class'=>'j-timepicker input-small', 'id'=>'timepicker', 'value'=>$row->hora, 'name'=>'hora')).'</div>';
                echo control_group('Hora:', $html, $attr = array('class_controls'=>'', 'prepend'=>''));

                $checked = ($row->status==1) ? array('checked'=>true) : array();
                $data = array('name'=>'status','id'=>'status', 'class'=>'', 'type'=>'checkbox');
                echo control_group('Activo', form_input($data+$checked),$attr = array());

                $buttons = '';
                $buttons .= '<span class="pull-left">';
                $data = array('type'=>'submit', 'value'=>'Guardar', 'class'=>'btn btn-inverse', 'onclick'=>"validateForm('agendaForm')", 'style' =>'margin-right: 10px');
                $buttons .= form_input($data);
                $buttons .= anchor($back,'Cancelar',array('class'=>'btn btn-inverse'));
                $buttons .= '</span>';
                echo form_action($buttons);
                echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>


