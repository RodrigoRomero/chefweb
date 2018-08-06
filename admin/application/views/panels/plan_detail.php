<?php
echo '<div class="row-fluid jPos jPos-'.$pos.'" data-pos="'.$pos.'">';
    echo '<div class="span4">';
        $data = array('name'=>'descripcion['.$pos.']','id'=>'descripcion_'.$pos.'','placeholder'=>'Descripcion '.($pos+1), 'class'=>'input-xlarge', 'value'=>$data);
        echo control_group($data['placeholder'], form_input($data));
    echo '</div>';
    echo '<div class="3">';
        echo '<a href="javascript:void(0)" class="btn btn-primary" onclick="addLine()" style="margin-top:25px">Add Line</a>';
        if($pos>0){
        echo '<a href="javascript:void(0)" class="btn btn-warning" onclick="removeLine('.$pos.')" style="margin-left: 10px;margin-top:25px">Remove</a>';
        }
    echo '</div>';
echo '</div>';
?>
