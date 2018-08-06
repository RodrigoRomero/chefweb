<?php
$metas = array(
	array('name' => 'description', 'content' =>$description),
	array('name' => 'keywords', 'content' => $keywords),
);
echo "<title>$title_page</title>\n";
echo meta($metas);
#CSS
foreach ($css_layout as $css) {
	echo css_asset($css.'.css');
}
?>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&language=es&key=AIzaSyDQB2_9TmkE6x_OloHur9nvgFZbyPdj_k4"></script>
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

 <?php
#JS
foreach ($js_layout as $js) {
	echo js_asset($js.'.js');
}



#WIDGETS
foreach($widgets as $folder => $v){
	$widgetFolder = $folder;
	foreach ($v as $type => $file){
		if($type=='css'){
			if(is_array($file)){
				foreach ($file as $f){
					echo css_asset($type.'/'.$f.'.'.$type,'../widgets/'.$widgetFolder);
				}
			} else {
				echo css_asset($type.'/'.$file.'.'.$type,'../widgets/'.$widgetFolder);
			}
		} elseif ($type=='js'){
			if(is_array($file)){
				foreach ($file as $f){
					echo js_asset($type.'/'.$f.'.'.$type,'../widgets/'.$widgetFolder);
				}
			} else {
				echo js_asset($type.'/'.$file.'.'.$type,'../widgets/'.$widgetFolder);
			}
		} else {
			show_error('formato no valido',500,'Problema al parsear Widget');
		}
	}
}
?>

<script>
_base_url = "<?php echo config_item('base_url')?>"
_categoria_id = "<?php echo $this->params['c']?>"
_base_lang = "<?php echo $Clang ?>"
</script>
<link rel="shortcut icon" href="<?php echo image_asset_url('favicon.ico')?>" type="image/x-icon"/>
<link rel="apple-touch-icon" href="<?php echo image_asset_url('favicon.ico')?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
