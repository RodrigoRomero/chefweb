<?php
$data = array ('id'=>'eventosForm', 'class'=>'form');
echo form_open($action,$data);
$lat_lng = json_decode($row_lugar->json_direccion);
$social = json_decode($row_evento->json_socials);
?>
<div class="row-fluid">
    <div class="box span12">
        <?php $this->load->view('layout/panels/box_header', ['title'=>$title, 'icon'=>'icon-pencil']) ?>
        <?php $this->load->view('alerts/error') ?>
    </div>
</div>
<div class="row-fluid">
    <div class="box span7">
        <?php $this->load->view('layout/panels/box_header', array('title'=>'Datos Generales', 'icon'=>'icon-pencil')) ?>
        <div class="box-content">
            <div class="form_container">
                <?php
                $data = array('name'=>'evento[nombre]','id'=>'nombre','placeholder'=>'Nombre del Evento', 'class'=>'required input-xlarge', 'value'=>$row_evento->nombre);
                echo control_group('Nombre del Evento', form_input($data),$attr = array('append'=>'<a class="icon-question ax-modal tip-right" data-original-title="Ver ayuda" href="'.base_url('helps/general/1').'"></a>'));
                $data = array('name'=>'evento[bajada]','id'=>'nombre','placeholder'=>'Bajada Evento', 'class'=>'required input-xlarge', 'value'=>$row_evento->bajada);
                echo control_group('Bajada Evento', form_input($data),$attr = array('append'=>'<a class="icon-question ax-modal tip-right" data-original-title="Ver ayuda" href="'.base_url('helps/general/1').'"></a>'));
                $date = explode(" ",$row_evento->fecha_inicio);
                $fecha = getFechaView($date[0]);
                $html  = '<div class="span6"><span class="add-on"><i class="icon-calendar"></i></span>'.form_input(array('class'=>'j-datepicker input-small required', 'data-date'=>date('d/m/Y'), 'value'=>$fecha, 'name'=>'evento[dia_inicia]')).'</div>';
                $html .= '<div class="bootstrap-timepicker span6"><span class="add-on "><i class="icon-time"></i></span>'.form_input(array('class'=>'j-timepicker input-small', 'id'=>'timepicker', 'name'=>'evento[hora_inicia]', 'value'=>$date[1])).'</div>';
                echo control_group('Fecha Inicio:', $html, $attr = array('class_controls'=>'', 'prepend'=>''));
                $date = explode(" ",$row_evento->fecha_baja);
                $fecha = getFechaView($date[0]);
                $html  = '<div class="span6"><span class="add-on"><i class="icon-calendar"></i></span>'.form_input(array('class'=>'j-datepicker input-small', 'data-date'=>date('d/m/Y'), 'value'=>$fecha, 'name'=>'evento[dia_finaliza]')).'</div>';
                $html .= '<div class="bootstrap-timepicker span6"><span class="add-on "><i class="icon-time"></i></span>'.form_input(array('class'=>'j-timepicker  input-small', 'id'=>'timepicker', 'name'=>'evento[hora_finaliza]', 'value'=>$date[1])).'</div>';
                echo control_group('Fecha Finaliza:', $html, $attr = array('class_controls'=>'', 'prepend'=>''));
                $fecha = getFechaView($row_evento->reminder_one);
                $html  = '<div class="span6"><span class="add-on"><i class="icon-calendar"></i></span>'.form_input(array('class'=>'j-datepicker input-small', 'data-date'=>date('d/m/Y'), 'value'=>$fecha, 'name'=>'evento[reminder_one]')).'</div>';
                echo control_group('Recordatorio 1:', $html, $attr = array('class_controls'=>'', 'prepend'=>''));
                $fecha = getFechaView($row_evento->reminder_two);
                $html  = '<div class="span6"><span class="add-on"><i class="icon-calendar"></i></span>'.form_input(array('class'=>'j-datepicker input-small', 'data-date'=>date('d/m/Y'), 'value'=>$fecha, 'name'=>'evento[reminder_two]')).'</div>';
                echo control_group('Recordatorio 2:', $html, $attr = array('class_controls'=>'', 'prepend'=>''));
                $data = array('name'=>'evento[telefono]','id'=>'telefono','placeholder'=>'Teléfono', 'class'=>'j-mask-phone  input-xlarge', 'value'=>$row_evento->telefono);
                echo control_group('Teléfono', form_input($data,$json),$attr = array('append'=>'<a class="icon-question ax-modal tip-right" data-original-title="Ver ayuda" href="'.base_url('helps/general/2').'"></a>'));
                $data = array('name'=>'evento[brief]','id'=>'resumen','placeholder'=>'Resúmen', 'data-maxlength'=>'350','class'=>'required jCleditorSimple limited animated  input-xxlarge', 'value'=>$row_evento->descripcion);
                echo control_group('Resúmen', form_textarea($data),$attr = array());

                $checked = ($row_evento->cupons_enabled==1) ? array('checked'=>true) : array();
                $data = array('name'=>'evento[cupons]','id'=>'cupons_enabled', 'class'=>'', 'type'=>'checkbox');
                echo control_group('Cupones Habilitados?', form_input($data+$checked),$attr = array());
                $checked = ($row_evento->show_register==1) ? array('checked'=>true) : array();
                $data = array('name'=>'evento[show_register]','id'=>'registro_enabled', 'class'=>'', 'type'=>'checkbox');
                echo control_group('Formulario Registro Activo', form_input($data+$checked),$attr = array());
                $checked = ($row_evento->newsletter==1) ? array('checked'=>true) : array();
                $data = array('name'=>'evento[newsletter]','id'=>'suscribe_newsletter', 'class'=>'', 'type'=>'checkbox');
                echo control_group('Suscribe Newsletter', form_input($data+$checked),$attr = array());
                $checked = ($row_evento->status==1) ? array('checked'=>true) : array();
                $data = array('name'=>'status','id'=>'status', 'class'=>'', 'type'=>'checkbox');
                echo control_group('Activo', form_input($data+$checked),$attr = array());
                ?>
            </div>
        </div>
    </div>
    <div class="box span5">
        <div class="row-fluid">
            <div class="box span12">
                <?php $this->load->view('layout/panels/box_header', array('title'=>'El lugar', 'icon'=>'icon-map-marker', 'subaction'=>false)) ?>
                <div class="box-content">
                    <div class="form_container">
                    <?php
                    #HIDDENS
                    $data = array('name'=>'lugar[json_direccion]','id'=>'event_address_components','type'=>'hidden', 'value'=>$row_lugar->json_direccion);
                    echo form_input($data);
                    if($this->params['iu']=='u'){
                        $data = array('name'=>'lugar[id]','id'=>'id','type'=>'hidden', 'value'=>$row_lugar->id);
                        echo form_input($data);
                    }
                    $data = array('name'=>'lugar[place]','id'=>'place','placeholder'=>'Lugar', 'class'=>'required  input-xlarge', 'value'=>$row_lugar->lugar);
                    echo control_group('Lugar', form_input($data),$attr = array('append'=>'<a class="icon-question ax-modal tip-right" data-original-title="Ver ayuda" href="'.base_url('helps/general/2').'"></a>'));
                    $data  = array('name'=>'lugar[address]','id'=>'lugar','placeholder'=>'Dirección', 'class'=>'required input-xlarge', 'value'=>$row_lugar->direccion);
                    echo control_group('Dirección', form_input($data),$attr = array('append'=>'<a class="icon-question ax-modal tip-right" data-original-title="Ver ayuda" href="'.base_url('helps/general/2').'"></a>'));
                    ?>
                    </div>
                </div>
                <div id="map_canvas" class="span12" data-lat="<?php echo !empty($lat_lng->lat) ? $lat_lng->lat : "-34.6073283"  ?>" data-lng="<?php echo !empty($lat_lng->lng) ? $lat_lng->lng : "-58.4486622" ?>"></div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="box span12">
                <?php $this->load->view('layout/panels/box_header', array('title'=>'Configurar Oradores', 'icon'=>'icon-bullhorn', 'subaction'=>false)) ?>
                <div class="box-content">
                    <div class="form_container">
                        <?php
                     		$checked = ($row_evento->show_full_bio==1) ? array('checked'=>true) : array();
                			$data = array('name'=>'evento[show_full_bio]','id'=>'registro_enabled', 'class'=>'', 'type'=>'checkbox');
                			echo control_group('Mostrar Bio', form_input($data+$checked),$attr = array());
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="box span12">
                <?php $this->load->view('layout/panels/box_header', array('title'=>'Social Links', 'icon'=>'icon-thumbs-up', 'subaction'=>false)) ?>
                <div class="box-content">
                    <div class="form_container">
                        <?php
                        $data = array('name'=>'evento[twitter]','id'=>'twitter','placeholder'=>'Twitter del Evento', 'class'=>'', 'value'=>$social->twitter);
                        echo control_group('Twitter', form_input($data),$attr = array('prepend'=>'<i class="icon-twitter"></i>','append'=>'<a class="icon-question ax-modal tip-right" data-original-title="Ver ayuda" href="'.base_url('helps/general/2').'"></a>'));
                        $data = array('name'=>'evento[facebook]','id'=>'facebook','placeholder'=>'Facebook del Evento', 'class'=>'', 'value'=>$social->faceboook);
                        echo control_group('Facebook', form_input($data),$attr = array('prepend'=>'<i class="icon-facebook"></i>','append'=>'<a class="icon-question ax-modal tip-right" data-original-title="Ver ayuda" href="'.base_url('helps/general/2').'"></a>'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="box span12">
                <?php $this->load->view('layout/panels/box_header', array('title'=>'Medios de Pago', 'icon'=>'icon-money', 'subaction'=>false)) ?>
                <div class="box-content">
                    <div class="form_container">
                        <?php
                        $checked = ($row_evento->payments_enabled==1) ? array('checked'=>true) : array();
                        $data = array('name'=>'evento[payments_enabled]','id'=>'payments_enabled', 'class'=>'', 'type'=>'checkbox');
                        echo control_group('Pagos Habilitado', form_input($data+$checked),$attr = array());

                        $data = array('class'=>'gateways', 'required'=>false, 'title'=>'Gateways');
    echo control_group('Gateways', frm_select_multi_trasfer($gateways, 'gateways', $data, ""),$attr = array('class_controls'=>'clearfix'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="box span12">
                <?php $this->load->view('layout/panels/box_header', array('title'=>'Skin', 'icon'=>'icon-cog', 'subaction'=>false)) ?>
                <div class="box-content">
                    <div class="form_container">
                        <?php
                        echo control_group('Imágen Home', upload_manager("",array("id"=>$row_evento->id, "uploadFolder"=>"uploads/slider/", "filter"=>"jpg", "ratio"=>"1920x1000")),$attr = array('id'=>'uploadGroup', 'help-block'=>'(Imágen JPG - 1920x1000)'));
                        echo control_group('', $addImage,$attr = array());
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
                $data = array('type'=>'submit', 'value'=>'Guardar', 'class'=>'btn btn-inverse', 'onclick'=>"validateForm('eventosForm')", 'style' =>'margin-right: 10px');
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
