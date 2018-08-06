<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**

 * @author Rodrigo Romero

 * @version 1.0.0

 */



// --- CSS HELPERS --- //

/**

* CSS Asset Helper

* Helps generate CSS asset locations.

*

* @access		public

* @param		string    the name of the file or asset

* @param		string    optional, module name

* @return		string    full url to css asset

*/

function css_asset_url($asset_name, $module_name = NULL)

{

	return _other_asset_url($asset_name, $module_name, 'css');

}



/**

* CSS Asset HTML Helper

* Helps generate CSS asset locations.

*

* @access		public

* @param		string    the name of the file or asset

* @param		string    optional, module name

* @param		string    optional, extra attributes

* @return		string    HTML code for JavaScript asset

*/

function css_asset($asset_name, $module_name = NULL, $attributes = array())

{

	$attribute_str = _parse_asset_html($attributes);

	return '<link href="'.css_asset_url($asset_name, $module_name).'" rel="stylesheet" type="text/css"'.$attribute_str.' />'."\n";

}



//-- JS ASSETS --//

/**

	* JavaScript Asset URL Helper

	*

	* Helps generate JavaScript asset locations.

	*

	* @access		public

	* @param		string    the name of the file or asset

	* @param		string    optional, module name

	* @return		string    full url to JavaScript asset

	*/

function js_asset_url($asset_name, $module_name = NULL)

{

	return _other_asset_url($asset_name, $module_name, 'js');

}

// ------------------------------------------------------------------------

/**

	* JavaScript Asset HTML Helper

	*

	* Helps generate JavaScript asset locations.

	*

	* @access		public

	* @param		string    the name of the file or asset

	* @param		string    optional, module name

	* @return		string    HTML code for JavaScript asset

	*/

function js_asset($asset_name, $module_name = NULL)

{

	return '<script type="text/javascript" src="'.js_asset_url($asset_name, $module_name).'"></script>'."\n";

}



/**

* Parse HTML Attributes

* Turns an array of attributes into a string

*

* @access		public

* @param		array		attributes to be parsed

* @return		string 		string of html attributes

*/

function _parse_asset_html($attributes = NULL)

{

	if(is_array($attributes)):

		$attribute_str = '';

		foreach($attributes as $key => $value):

			$attribute_str .= ' '.$key.'="'.$value.'"';

		endforeach;

		return $attribute_str;

	endif;

	return '';

}



/**

	* General Asset Helper

	* Helps generate links to asset files of any sort. Asset type should be the

	* name of the folder they are stored in.

	*

	* @access		public

	* @param		string    the name of the file or asset

	* @param		string    the asset type (name of folder)

	* @param		string    optional, module name

	* @return		string    full url to asset

	*/

function _other_asset_url($asset_name, $module_name = NULL, $asset_type = NULL){

		if($asset_type=="css" && $asset_name=="style_lang.css"){
				$asset_name = "style.php?file=$asset_name&lang=".config_item("language");
		}

	$obj =& get_instance();
	$base_url        = $obj->config->item('base_url');
	$asset_location  = $base_url;
	$asset_location .= "assets/".$asset_type;

	if(!empty($module_name)):
		$asset_location .= '/'.$module_name;
	endif;
		$asset_location .= '/'.$asset_name;
	return $asset_location;

}



/**

* Last Query

* @description Devuelve el ultimo query realizado

* @access public

*/



function lq(){

		$CI   =& get_instance();

		echo $CI->db->last_query();

}







function replace_code($body, $replace){

		preg_match_all("/({%)(.*?)(%})/", $body, $matches, PREG_SET_ORDER);

		foreach ($matches as $k=>$val) {

				$val1 = $val[0];

				$val2 = $val[2];

				$body = str_replace($val1,  $replace[$val2], $body);

		}

		return $body;

}



/**

 * Echo Array

 * @description Parsea un array, para una lectura más fácil

 * @param $arr array información a parsear

 * @param $dump bool TRUE/FALSE

 */



function ep($arr, $dump=false){

		echo "<pre>";

		if($dump) {var_dump($arr);} else { print_r($arr);}

		echo "</pre>";

}



/**

 * Check Param

 * @description Verifico si el parametro enviado es Int

 * @param $string

 * @return bool TRUE/FALSE

 */

function checkParam($param){

		$return = false;

		if($param==='i' || $param==='u'){

				$return = true;

		}



		return $return;

}





function quitarAcentos($text,$cab=0,$snan=0,$sub='',$cr='') {

		// $text Cadena a procesar.

		// $cab Cambiar ALTAS-bajas: 0=no, 1=todas altas, 2=todas bajas.

		// $snan Sustituir no alfanumericas: 0=no, 1=todo, 2=las listadas, 3=las no listadas.

		// $sub Caracteres sustitutos (vacío para eliminar)(ver $snan).

		// $cr Caracteres no alfanumericos a buscar (ver $snan).

		$text = htmlentities($text, ENT_QUOTES, 'UTF-8');



		$patron = array (

		'/&(.)grave;/',

		'/&(.)acute;/',

		'/&(.)circ;/',

		'/&(.)tilde;/',

		'/&(.)uml;/',

		'/&(.)ring;/',

		'/&(.)cedil;/',

		);

		$text = preg_replace($patron,'$1',$text);

		$text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');



		if (($snan>1)&&($cr!='')) {

				$cr='\Q'.$cr.'\E';

				if ($snan==2) $cr='/['.$cr.']+/'; else $cr='/[^A-Za-z0-9'.$cr.']+/';

				$text = preg_replace($cr, $sub, $text );

		} else {

				if ($snan==1) $text = preg_replace('/[^A-Za-z0-9]+/', $sub, $text );

		}

		if ($cab==1) $text=strtoupper($text);

		else if ($cab==2) $text = strtolower($text);



		return $text;

}



function set_url($params=array()){

		$CI   =& get_instance();

		$segs = $CI->uri->uri_to_assoc(1);



		foreach($params as $key=>$value){

				$segs[$key] = $value;

		if($value=="")

			unset($segs[$key]);

		}

		$url  = config_item("base_url").$CI->uri->assoc_to_uri($segs);

		return $url;

}



function getFechasSQLFicha($fecha_revision, $fecha_proxima_revision, $hora_revision){

		#MES / DIA / AÑO

		$fecha_revision = explode("/",$fecha_revision);



		switch($fecha_proxima_revision){

				case '+1':

						$fecha_proxima_revision = mktime(0,0,0,$fecha_revision[1],$fecha_revision[0]+1,$fecha_revision[2]);

						break;



				case '+2':

						$fecha_proxima_revision = mktime(0,0,0,$fecha_revision[1],$fecha_revision[0]+2,$fecha_revision[2]);

						break;



				case '+3':

						$fecha_proxima_revision = mktime(0,0,0,$fecha_revision[1],$fecha_revision[0]+3,$fecha_revision[2]);

						break;



				case '+4':

						$fecha_proxima_revision = mktime(0,0,0,$fecha_revision[1],$fecha_revision[0]+4,$fecha_revision[2]);

						break;



				default:

						$fecha_proxima_revision = explode("/",$fecha_proxima_revision);

						$fecha_proxima_revision = mktime(0,0,0,$fecha_proxima_revision[1],$fecha_proxima_revision[0],$fecha_proxima_revision[2]);

						break;

		}





		$fecha_revision         = mktime(0,0,0,$fecha_revision[1],$fecha_revision[0],$fecha_revision[2]);



		$fecha_revison = date('Y-m-d',$fecha_revision);

		$fecha_proxima_revision = date('Y-m-d',$fecha_proxima_revision);



		return array('fecha_revision'=>$fecha_revison.' '.$hora_revision, 'fecha_proxima_revision'=>$fecha_proxima_revision);

}



function getFechasSQL($fecha,$array=false){

		if($array){

				$fecha = explode("/",$fecha);

		} else {

				$fecha = explode("/",$fecha);

				$fecha = mktime(0,0,0,$fecha[1],$fecha[0],$fecha[2]);

				$fecha = date('Y-m-d',$fecha);

		}

		return $fecha;

}



function getFechaView($fecha){

		$fecha = explode(" ",$fecha);

		$fecha = explode("-",$fecha[0]);

		$fecha = implode("/",array_reverse($fecha));

		return $fecha;

}



function anchor_js($title = '', $attributes = ''){

		$title = (string) $title;

				$uri = 'javascript:void(0)';



		if ($attributes != ''){

			$attributes = _parse_attributes($attributes);

		}



		return '<a href="'.$uri.'"'.$attributes.'>'.$title.'</a>';

}





function getAtributesCategories($atributos_id){

		$atributos_id = explode(",",$atributos_id);

		$atributos_id = implode(" ", array_filter($atributos_id,'filterValues'));

		return $atributos_id;

}



function filterValues($var){

		if($var>=10001 && $var<20000){

				return $var;

		}

}



function isJson($string) {

	return ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string))))) ? true : false;

}






function getMes($mes){

		$meses = array('Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic');

		return $meses[$mes-1];

}

 function SpanishDate($FechaStamp){
	 $FechaStamp = strtotime($FechaStamp);
	 $ano = date('Y',$FechaStamp);
	 $mes = date('n',$FechaStamp);
	 $dia = date('d',$FechaStamp);
	 $hora = date('H:i A',$FechaStamp);

	 $diasemana = date('w',$FechaStamp);
	 $diassemanaN= array("Domingo","Lunes","Martes","Miércoles",
									"Jueves","Viernes","Sábado");
	 $mesesN=array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio",
						 "Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	 return $diassemanaN[$diasemana].", $dia de ". $mesesN[$mes] ." de $ano, $hora";
}
