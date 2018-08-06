<?php
$gateways = ['transferencia_bancaria' => ['id'=>'transferencia_bancaria', 'type'=>'radio','name'=>'medio_pago', 'class'=>'required', 'value'=>'transferencia_bancaria', 'class'=>'required'],
              'mercado_pago' => ['id'=>'mercado_pago', 'type'=>'radio','name'=>'medio_pago', 'class'=>'', 'value'=>'mercado_pago']
            ];
//$data   = array ('id'=>'gatewayForm', 'class'=>'');
//$action = lang_url('cart/do-gateway');
//echo form_open($action,$data);
?>


<div class="col_full jResumePayments" >


<?php

if($show_options) {
$form_name = 'payments-form';
$data   = array ('id'=>$form_name);
$action =  base_url('/cart/payments');
echo form_open($action,$data);

?>

<?php
if($this->cart->total() == 0) { ?>

<div>

<input id="free" class="radio-style free" name="medio_pago" type="radio" value="foc" checked="true" />
<label for="free" class="required radio-style-3-label">Sin cargo</label>
</div>

<?php } else {


foreach($gateways as $k=>$gateway) {


$name = ucwords(str_replace('_',' ',$k));
if(get_session('cart_medio_pago',false)){
	$gateway_selectd = get_session('cart_medio_pago',false);
}

$checked = ( $gateway['value'] == $gateway_selectd) ? 'checked' : '';
?>


<div>

<input id="<?php echo $gateway['id']?>" class="radio-style <?php echo $gateway['class']?>" name="<?php echo $gateway['name']?>" type="radio" value="<?php echo $gateway['value']?>" <?php echo $checked ?> r/>
<label for="<?php echo $gateway['id']?>" class="required radio-style-3-label"><?php echo $name ?></label>
</div>


<?php } } ?>




<?php if($proceedToCheckout) { ?>
<div>
	<button class="button button-3d nomargin fright" id="payments-form-submit"  onclick="validateForm('<?php echo $form_name ?>')">Finalizar</button>
</div>
<?php } ?>




<?php echo form_close();
} else {


$name = ucwords(str_replace('_',' ',get_session('cart_medio_pago',false)));


$name = ($name == 'foc') ? 'Sin Cargo' : $name;

?>
<div>
<input id="<?php echo get_session('cart_medio_pago',false) ?>" class="radio-style" name="<?php echo $name ?>" type="radio" value="<?php echo get_session('cart_medio_pago',false) ?>" checked>
<label class="radio-style-3-label"><?php echo $name ?></label>

</div>
<?php
if($proceedToCheckout) {
$form_name = 'compleate-form';
$data   = array ('id'=>$form_name);
$action =  $gateway_form['action'];
echo form_open($action,$data);
?>
<div>
	<button class="button button-3d nomargin fright" id="gateway-form-submit"  onclick="validateForm('<?php echo $form_name ?>')"><?php echo $gateway_form['btnTxt'] ?></button>
</div>
<?php
echo form_close();
} ?>
<?php }

?>

</div>
