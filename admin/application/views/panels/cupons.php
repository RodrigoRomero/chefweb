<?php
$data = array ('id'=>'agendaForm', 'class'=>'form');
echo form_open($action,$data);
?>
<div class="row-fluid">
    <div class="box span12">
        <?php $this->load->view('layout/panels/box_header', array('title'=>$title, 'icon'=>'icon-pencil')) ?>
        <?php $this->load->view('alerts/error') ?>

        <div class="box-content">
            <div class="form_container">
                <?php
                $data = array('name'=>'nombre','id'=>'nombre','placeholder'=>'Título', 'class'=>'required input-xlarge', 'value'=>$row->nombre);
                echo control_group($data['placeholder'], form_input($data),$attr = array('append'=>'<a class="icon-question ax-modal tip-right" data-original-title="Ver ayuda" href="'.base_url('helps/general/1').'"></a>'));

                if($this->params['iu']=='update'){
                    $data = array('name'=>'code','id'=>'code','placeholder'=>'Código', 'data-maxlength'=>'10','class'=>'required limited input-xlarge', 'value'=>$row->code, 'readonly'=>true);
                    echo control_group($data['placeholder'], form_input($data),$attr = array());
                } else {
                    $data = array('name'=>'code','id'=>'code','placeholder'=>'Código', 'data-maxlength'=>'10','class'=>'required limited input-xlarge', 'value'=>random_string('alnum',10), );
                    echo control_group($data['placeholder'], form_input($data),$attr = array());
                }

                $data = frm_select('',array('name'=>'plan_id'),$tickets, $row->plan_id,'',false,array(),'','Seleccione Ticket');
                echo control_group('Tickets', $data, $attr = array('help-in-label'=>'<a class="fa fa-question ax-modal tip-right" data-original-title="Ver ayuda" href="'.base_url('helps/general/1').'"></a>'));

                $data = array('name'=>'quantity','id'=>'quantity','placeholder'=>'Cantidad', 'class'=>'required number input-xlarge', 'value'=>$row->quantity);
                echo control_group($data['placeholder'], form_input($data),$attr = array('append'=>'<a class="icon-question ax-modal tip-right" data-original-title="Ver ayuda" href="'.base_url('helps/general/1').'"></a>'));

                $data = array('name'=>'value','id'=>'value','placeholder'=>'Porcentaje Descuento', 'class'=>'required number input-xlarge', 'value'=>$row->value);
                echo control_group($data['placeholder'], form_input($data),$attr = array('append'=>'<a class="icon-question ax-modal tip-right" data-original-title="Ver ayuda" href="'.base_url('helps/general/1').'"></a>'));

                /*$percent = ($row->percent==1) ? array('checked'=>true) : array();
                $data = array('name'=>'percent','id'=>'percent', 'class'=>'', 'type'=>'checkbox');
                echo control_group('Es porcentaje', form_input($data+$percent),$attr = array('help-block'=>'Chequee esta casilla si desea aplicar un % sobre el monto de la entrada.'));
                */
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
