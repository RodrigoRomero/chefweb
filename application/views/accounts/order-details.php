<?php
$items = json_decode($order_info->full_cart);
switch($order_info->status){
    case 1:
    case '1':
        $row_color = 'warning';
        $status = 'Pendiente';
    break;

    case 2:
    case '2':
        $row_color = 'info';
        $status = 'En Proceso';
    break;

    case 3:
    case "3":
        $row_color = 'info';
        $status = 'Listo para Entregar';
    break;

    case 4:
    case "4":
    case 5:
    case "5":
        $row_color = 'success';
        $status = 'Entregado';
    break;

    case '-1':
    case -1:
        $row_color = 'danger';
        $status = 'Cancelada';
    break;
}
?>

<?php echo $this->load->view('accounts/partials/menu_account',[],true); ?>

<div class="col_two_third col_last">
        <div class="col_full">
        <div class="promo promo-border promo-mini">
            <h3><?php echo get_session("nombre", false). ' '.get_session("apellido",  false) ?></h3>
            <span><?php echo get_session("email",  false) ?></span>
        </div>
    </div>
    <div class="col_half">
        <div class="promo promo-border promo-mini center">
            <h3>Pedido # <?php echo $order_info->id ?></h3>
            <span>Efectivo contra Entrega</span>
            <!-- <span class="subtitle">Creada: <?php echo nice_date($order_info->fa, 'Y-m-d'); ?><br/>
            <?php if($order_info->fum) { ?>
            Ultima Actualización: <?php echo nice_date($order_info->fum, 'Y-m-d'); ?><br/>
            <?php } ?></span> -->
        </div>
    </div>
    <div class="col_half col_last">

        <div class="promo promo-border promo-mini center">

            <h3 class="label label-<?php echo $row_color?>"><?php echo $status ?></h3>
            <?php if($order_info->fecha_delivery) { ?>
            <span>
            Día Entrega: <?php echo nice_date($order_info->fecha_delivery, 'd-m-Y'); ?>
            </span>
            <?php } ?>

        </div>
    </div>



    <div class="col_full">
<div class="fancy-title title-border">
                        <h3>Resumen del Pedido</h3>
                    </div>
</div>
    <div class="col_full">
        <table class="table table-striped">
            <thead>
                 <tr>
                    <td>Producto</td>
                    <td class="center">Cantidad</td>
                    <td class="center">Precio</td>
                    <td class="tright">Subtotal</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $key => $product) { ?>
                <tr>
                    <td ><?php echo $product->name ?> (<?php echo $product->id?>)</td>
                    <td class="center"><?php echo $product->qty ?></td>
                    <td class="center">$ <?php echo $product->price ?></td>
                    <td class="tright">$ <?php echo $product->subtotal ?></td>
                </tr>
                <?php } ?>
                <tr class="total">
                    <td colspan="2"></td>
                    <td class="tright">Total:</td>
                    <td class="tright">$ <?php echo $order_info->total_discounted_price ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>