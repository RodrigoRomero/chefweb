<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <?php $this->view('layout/head.php')?>    
</head>
<body> 
    <div id="logo">
        <?php echo image_asset('admin/site-logo.png','', array('title'=>$title_page,'alt'=>$title_page)) ?>
    </div>  
    <div id="loginbox">    	
        <?php echo $module ?>
    </div>
</body>
</html>