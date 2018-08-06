<div id="j-paging" class="pagination">
    <ul class="pagination">



        <li><a class="j-paging-page btn btn-mini" data-page="<?php echo $first ?>">Primero</a></li>
        <li><a class="j-paging-page btn btn-mini" data-page="<?php echo $prev ?>">Anterior</a></li>
        <?php 
            for($i=0 ; $i<count($numbs) ; $i++){
                $num   = $numbs[$i]["page"];
                $lnk   = set_url(array("pag"=>$numbs[$i]["page"]));
                $class = ($numbs[$i]["selected"]) ? "active" : "";
                echo "<li><a class='j-paging-page btn btn-mini ".$class."' data-page='".$num."'>".$num."</a></li>\n";
            }
            
        ?>
        <li><a class="j-paging-page btn btn-mini" data-page='<?php echo $next ?>'>Siguiente</a></li>
        <li><a class="j-paging-page btn btn-mini" data-page="<?php echo $last ?>">Último</a></li>    
    </ul>
</div>
<div class="pull-right">
    <?php 

    $opciones = array(array('id'=>2, 'nombre'=>2),
                      array('id'=>10, 'nombre'=>10),
                      array('id'=>20, 'nombre'=>20),  
                      array('id'=>50, 'nombre'=>50),
                      array('id'=>100, 'nombre'=>100),
                      array('id'=>'all', 'nombre'=>'Todos')
                     );
    echo frm_select('Mostrar',array('id'=>'j-limit'),$opciones,$limit,'',false,array(),"",'Mostrar Resultados')
    
    ?>
    
</div>