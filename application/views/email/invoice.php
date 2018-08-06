<?php
$items = json_decode($order->full_cart)
?>


        <table cellpadding="0" cellspacing="0">
            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                <p><b>Pedido #: <?php echo $id ?></b><br/>
                                <?php echo $user_info->nombre.' '.$user_info->apellido ?></p>
                            </td>
                            <td>
                                 <p>
                                    <span class="warning">Pendiente</span><br/>
                                    Creada: <?php echo nice_date($this->today, 'Y-m-d'); ?>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="headingFp" >
                <td colspan="4">
                    Forma de Pago
                </td>


            </tr>

            <tr class="details" >
                <td colspan="4">
                    Efectivo contra Entrega
                </td>
            </tr>

            <tr class="heading">
                <td class="first">
                    Producto
                </td>
                <td>
                    Cantidad
                </td>
                <td>
                    Precio
                </td>
                <td>
                    Subtotal
                </td>
            </tr>

            <?php foreach ($items as $key => $product) { ?>
            <tr class="item">
                <td class="first">
                    <?php echo $product->name ?> (<?php echo $product->id?>)
                </td>
                <td>
                    <?php echo $product->qty ?>
                </td>
                <td>
                    $ <?php echo $product->price ?>
                </td>
                <td class="last">
                    $ <?php echo $product->subtotal ?>
                </td>
            </tr>
            <?php } ?>

            <tr class="total">
                <td colspan="3"></td>

                <td>
                   Total: $ <?php echo $order->total_discounted_price ?>
                </td>
            </tr>
            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td colspan="4">
                                En breve te estaremos contactando para reconfirmar tu pedido, y coordinar día / hora para la entrega de tus productos.
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

