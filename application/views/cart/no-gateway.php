<?php
if($proceedToCheckout) {
$form_name = 'compleate-form';
$data   = array ('id'=>$form_name);
$action =  $gateway_form['action'];
echo form_open($action,$data);
?>
<div>
	<button class="button button-rounded nomargin fright" id="gateway-form-submit"  onclick="validateForm('<?php echo $form_name ?>')"><?php echo $gateway_form['btnTxt'] ?></button>
</div>
<?php
echo form_close();
} ?>