<div class="box span12">
    <div class="box-header">
        <h2><i class="icon-search"></i> Filtros</h2>
    </div>
    <div class="box-content">
        <?php
        $data   = array ('id'=>'frmFilter');
        echo form_open($action,$data);
        ?>
        <div class="row" style="margin: 0;">
        <div class="span6">
            <?php
            $data = array('id'=>'', 'class'=>'filt', 'value'=>$nombre, 'name'=>'search', 'placeholder'=>'Buscar');
            echo form_label($data['placeholder']);
            echo form_input($data);
            ?>
        </div>
        <div class="span6">
            <?php
            $opciones = array('-1'                      =>'Seleccione una opción',
                              'FOC'                     =>'Free of Charge',
                              'mercado_pago'            =>'Mercado Pago',
                              'transferencia_bancaria'  =>'Transferencia Bancaria',
                              'pago_mis_cuentas'        =>'Pago Mis Cuentas',
                              'efectivo'								=>'Efectivo'
                              );
            echo form_label('Medio de Pago');
            echo form_dropdown('medio_pago',$opciones);
            ?>
        </div>
        </div>
        <div class="row" style="margin: 0;">

        <div class="span6">
            <?php
            $opciones = array('-1'                      =>'Seleccione una opción',
                              'approved'                =>'Aprobada',
                              'in_progress'             =>'En Proceso',
                              'rejected'                =>'Rechazado',
                              'cancelled'               =>'Cancelado'

                              );
            echo form_label('Status Pago');
            echo form_dropdown('payment_status',$opciones);
            ?>
        </div>
        </div>

        <div class="row"  style="margin: 0;">
        <div class="span12">
        <?php
        echo form_close();
        echo anchor_js('Buscar', array('class'=>"cg-filters btn btn-small btn-primary", 'id'=>'j-filter-send', 'style'=>'margin-right:10px'));
        echo anchor_js('Exportar', array('class'=>"cg-filters btn btn-small btn-primary", 'id'=>'j-filter-export', 'style'=>'margin-right:10px'));
        echo anchor_js('Resetear', array('class'=>"cg-filters btn btn-small btn-inverse", 'id'=>'j-filter-reset'));
        ?>
        </div>
        </div>
   </div>
</div>
