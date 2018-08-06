<?php


$data = array('name'=>'extras[private_id]','id'=>'private_key','placeholder'=>'Private ID', 'class'=>'required input-xlarge', 'value'=>"");
echo control_group($data['placeholder'], form_input($data));

$data = array('name'=>'extras[private_key]','id'=>'private_key','placeholder'=>'Private Key', 'class'=>'required input-xlarge', 'value'=>"");
echo control_group($data['placeholder'], form_input($data));

?>
