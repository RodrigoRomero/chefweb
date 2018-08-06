<?php
/**
* Image Asset Helper
* Helps generate CSS asset locations.
*
* @access		public
* @param		string    the name of the file or asset
* @param		string    optional, module name
* @return		string    full url to image asset
*/

function image_asset_url($asset_name, $module_name = NULL)
{
	return _other_asset_url($asset_name, $module_name, 'img');
}
/**
* Image Asset HTML Helper
* Helps generate image HTML.
*
* @access		public
* @param		string    the name of the file or asset
* @param		string    optional, module name
* @param		string    optional, extra attributes
* @return		string    HTML code for image asset
*/

function image_asset($asset_name, $module_name = '', $attributes = array())
{
	$attribute_str = _parse_asset_html($attributes);
	return '<img src="'.image_asset_url($asset_name, $module_name).'"'.$attribute_str.' />';
}

function up_asset($asset_name,  $attributes = array(), $exists=true){
	$obj                 =& get_instance();
	$file                = up_file($asset_name, $exists);


	if(empty($file)) return "";
	$attributes["alt"]   = ($attributes["alt"]) ? $attributes["alt"] : "";
	$attributes["title"] = ($attributes["title"]) ? $attributes["title"] : $attributes["alt"];
	$attribute_str       = _parse_asset_html($attributes);
	return '<img src="'.$file.'"'.$attribute_str.' />';
}
/**
 * Up File
 * @description Verifica si existe un archivo
 * @param $name Nombre del archivo / $exists muestra NONE en caso de que no exista el archivo
 * @access public
 */

function up_file($name, $exists=true){
	$obj      =& get_instance();
	$file     = config_item('base_url')."uploads/".$name;
	$abs_file = BASEPATH."../uploads/".$name;

	if(!file_exists($abs_file)){
		$file = ($exists) ? config_item('base_url')."uploads/none.jpg" : "";
	}
	return $file;
}

function upload_manager($title="", $array){
	$pos                 = $array["pos"];
	$resize              = (isset($array["resize"]) && !empty($array["resize"])) ?  explode(",", str_replace(" ","", $array["resize"])) : "";
	$original            = ($resize!="" && count($resize)>0) ? "original/" : "";
	$array["lang"]       = "sp";
	$array["serverPath"] = config_item("base_url");
	$array["sistemPath"] = BASEPATH."../";
	$file_name           = $array["id"]."_".$array["pos"].".".$array["filter"];
	if($array["id"]!=null){
		$array["file_name"]  = $array["sistemPath"].$array["uploadFolder"].$original;
	}else{
		$array["file_name"]  = "";
	}
	//echo $array["file_name"].$file_name;
	$array["file_name"]  = (file_exists($array["file_name"].$file_name)) ? $file_name : "" ;
	$json = json_encode($array);
	$html = "
	<span class='x-upload_manager-title'>$title</span>
	<div id='upload_manager_$pos'>$json</div>
	<div class='clear'></div>";
	return $html;
}
