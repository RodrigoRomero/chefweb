<?php

$ticket_options = array();
$ticket_name_options = array();
$user_info_qty_ticket = 0;
$user_info_ticket_monto = 0;
$user_info_ticket_name = '';
$user_info_almuerzo = 0;
foreach($tickets as $tkt){
    $tiket_name_options[$tkt->nombre] = $tkt->nombre;
    $ticket_options[$tkt->precio_regular] = $tkt->precio_regular;
    $ticket_options[$tkt->precio_oferta] = $tkt->precio_oferta;
}
ksort($ticket_options);



$data = array ('id'=>'eventosForm', 'class'=>'form');
echo form_open($action,$data);





?>
<div class="row-fluid">
    <div class="box span12">
        <?php $this->load->view('layout/panels/box_header', array('title'=>'Acreditados', 'icon'=>'icon-pencil')) ?>
        <?php $this->view('alerts/error') ?>
    </div>
</div>
<div class="row-fluid">
    <div class="box span7">
        <?php $this->load->view('layout/panels/box_header', array('title'=>'Datos Generales', 'icon'=>'icon-pencil')) ?>
        <div class="box-content">
            <div class="form_container">
                <?php
                 echo '<div class="row-fluid">';
                $data = array('name'=>'nombre','id'=>'nombre','placeholder'=>'Nombre', 'class'=>'required input-xlarge', 'value'=>$user_info->nombre);
                echo control_group('Nombre', form_input($data),$attr = array('class'=>'span6'));
                $data = array('name'=>'apellido','id'=>'apellido','placeholder'=>'Apellido', 'class'=>'required input-xlarge', 'value'=>$user_info->apellido);
                echo control_group('Apellido', form_input($data),$attr = array('class'=>'span6'));
                echo '</div>';
                echo '<div class="row-fluid">';
                $data = array('name'=>'email','id'=>'email','placeholder'=>'Email', 'class'=>'required input-xlarge', 'value'=>$user_info->email);
                echo control_group('Email', form_input($data),$attr = array('class'=>'span6'));
                echo '</div>';
                echo '<div class="row-fluid">';
                $data = array('name'=>'empresa','id'=>'empresa','placeholder'=>'Empresa', 'disabled'=>'disabled', 'class'=>'required input-xlarge', 'value'=>$empresa->empresa);
                echo control_group('Empresa', form_input($data),$attr = array('class'=>'span6'));

                echo '</div>';



                echo '<div class="row-fluid">';
                $checked = ($user_info->status==1) ? array('checked'=>true) : array();
                $data = array('name'=>'status','id'=>'status', 'class'=>'', 'type'=>'checkbox');
                echo control_group('Activo', form_input($data+$checked),$attr = array('class'=>'span4'));



                echo '</div>';
                ?>
            </div>
        </div>
    </div>
    <div class="box span5">
        <div class="row-fluid">
            <div class=" span12">
                <?php $this->load->view('layout/panels/box_header', array('title'=>'Datos Ingreso', 'icon'=>'icon-map-marker', 'subaction'=>false)) ?>
                <div class="box-content">
                    <div class="form_container">
                    <?php
                    $data = array('name'=>'barcode','id'=>'barcode','placeholder'=>'Código de Barras', 'disabled'=>'disabled', 'class'=>'required input-xlarge', 'value'=>$user_info->barcode);
                    echo control_group('Código de Barras', form_input($data),$attr = array());
                    ?>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<div class="row-fluid">
    <div class="box span12">
        <div class="box-content">
            <div class="form_container">
                <?php
                $buttons = '';
                $buttons .= '<span class="pull-left">';
                $data = array('type'=>'submit', 'value'=>'Guardar', 'class'=>'btn btn-primary', 'onclick'=>"validateForm('eventosForm')", 'style' =>'margin-right: 10px');
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
