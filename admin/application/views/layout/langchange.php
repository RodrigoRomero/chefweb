<div class="row-fluid">
    <div class="span12 center">
        <div class="btn-group pull-right" style="width: auto;" id="jLangs"> 
        <?php          
            foreach ($langs as $pos => $row){
                echo '<a data-lang="'.$row.'" href="javascript:void(0)" class="btn btn-inverse" data-pos="'.$pos.'">'.lang($row).'</a>';
            }
        ?>
        </div>
    </div>
</div>