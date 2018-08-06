<?php
$data = array ('id'=>'gatewayForm', 'class'=>'form');
echo form_open($action,$data);
ep($row);
?>
<div class="row-fluid">
    <div class="box span12">
        <?php echo $this->view('layout/panels/box_header', array('title'=>$title, 'icon'=>'icon-pencil')) ?>
        <?php $this->view('alerts/error') ?>

        <div class="box-content">
            <div class="form_container">
                <?php
                $data = array('name'=>'nombre','id'=>'nombre','placeholder'=>'Nombre', 'class'=>'required input-xlarge', 'value'=>$row->nombre, 'readonly'=>true);
                echo control_group($data['placeholder'], form_input($data));

                $data = array('name'=>'descripcion','id'=>'descripcion','placeholder'=>'Descripción', 'data-maxlength'=>'200','class'=>'required limited animated  input-xxlarge', 'value'=>$row->descripcion);
                echo control_group($data['placeholder'], form_textarea($data),$attr = array());
                #TRANSFERENCIA BANCARIA
                if($row->id == 1){
                    $this->view('gateways/transferencia_bancaria',array('data'=>json_decode($row->extras)));
                }

                #MERCADO PAGO
                if($row->id == 2){
                    $this->view('panels/gateways/mercado_pago',array('data'=>''));
                }



                $checked = ($row->status==1) ? array('checked'=>true) : array();
                $data = array('name'=>'status','id'=>'status', 'class'=>'', 'type'=>'checkbox');
                echo control_group('Activo', form_input($data+$checked),$attr = array());

                $buttons = '';
                $buttons .= '<span class="pull-left">';
                $data = array('type'=>'submit', 'value'=>'Guardar', 'class'=>'btn btn-inverse', 'onclick'=>"validateForm('gatewayForm')", 'style' =>'margin-right: 10px');
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


