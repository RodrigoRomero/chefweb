<?php if(!$this->input->is_ajax_request()) { ?>
<div class="row-fluid">
    <?php echo $filter ?>
</div>
<div class="row-fluid">        
    <div class="box span12">
        <div class="box-header">		         
            <h2><i class="icon-th-list"></i> <?php echo $grid_title ?></h2>   
            <div class="box-icon">
            <?php if (isset($grid_lnk['new'])) { ?>
            <a class="btn-setting tip-top" data-original-title='Nuevo Registro' href="<?php echo $grid_lnk['new']['action'] ?>"><i class="icon-wrench"></i><?php echo $grid_lnk['new']['title'] ?></a>
            <?php } ?>
            <?php if (isset($grid_lnk['exporta'])) { ?>
            <a class="btn-setting tip-top ax-modal" data-original-title='Exportar Registros' href="<?php echo $grid_lnk['exporta']['action'] ?>"><i class="icon-download-alt"></i><?php echo $grid_lnk['exporta']['title'] ?></a>
            <?php } ?>
            <a class="btn-minimize" href="#"><i class="icon-chevron-up"></i></a>
        </div>     
        </div>    
        <div class="j-a box-content">
            <table class="table table-striped" id="">
                <thead>
                    <tr>
                        <?php echo $header?>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $rows ?>			
                </tbody>
            </table>  
            <?php echo $paging ?>
        </div>
    </div>
</div>
<?php } else { ?>
    <table class="table table-striped" id="">
        <thead>
            <tr>
                <?php echo $header?>
            </tr>
        </thead>
        <tbody>
            <?php echo $rows ?>			
        </tbody>
    </table>  
    <?php echo $paging ?>
<?php }  ?>
