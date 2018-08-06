<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**

 * @author		Rodrigo Romero

 * @version     1.0.0

 */

 

class Env {

	var $CI;

	var $Clang;

	public function __construct($params = array()){

		$this->CI =& get_instance();        

		//$this->CI->session->sess_destroy();

		$this->Clang = config_item("language");

		if (!get_session("config_env")){

			$this->_configEnv();

			//$this->_configModules();

			$this->Clang = config_item("language");

		}

		

		$base_url_lang = (config_item("language_show")) ? config_item("base_url").config_item("language")."/" : config_item("base_url").'sp';

		$this->CI->config->set_item('base_url_lang', $base_url_lang);

				

	}



	/**

	* @author		   Rodrigo Romero

	* @params          id de la base de datos

	* @params          atrib valor que se busca devolver (value/descripcion)

	* @description     Devuelve valor del ENV requerido, que se encuentra en la session

	*/

	public function getEnv($id,$atrib="value"){

		
		$env = get_session("config_env");

		return $env[$id][$atrib];

	}

	

	/**

	* @author		   Rodrigo Romero

	* @params          id de la base de datos

	* @params          value valor que se debe setear

	* @params          atrib valor que se busca devolver (value/descripcion)

	* @description     Setea valor de ENV de systema por fuera de la DB

	*/

	function set_env($id, $value, $atrib="value"){

		$env = get_session("config_env");

		$env[$id][$atrib] = $value;

		set_session("config_env", $env);

	}

	

	/**

	* @author		   Rodrigo Romero

	* @description     Guardo en Session la configuracion general del sitio

	*/

	private function _configEnv(){

		$configEnv = array();

		foreach($this->_envRead() as $row){

			if(isJson($row->valor)){                

				$valor = json_decode($row->valor);

			} else {

				$valor = $row->valor;

			}

			$data[$row->id] = array("tipo" => $row->tipo, "value" => $valor, "descripcion" =>$row->descripcion );

		}



		set_session("config_env", $data);

	}

	

	/**

	* @author		   Rodrigo Romero

	* @description     Guardo en Session la configuracion de los módulos disponibles para el sitio

	*/

	private function _configModules(){

		$configModules = array();

		foreach($this->_modulesRead() as $row){

			$json = json_decode($row->permisos);

			 

			foreach($json->permisos as $permisos){

				if($permisos->perfil==1 && $permisos->accede==1)

				$configModules[] = $row->id;    

			}

			

		}

		set_session("CONFIG_MODULES", $configModules);

	}

	

	/**

	* @author	  Rodrigo Romero

	* @return     Array all Elements ENV

	*/

	private function _envRead(){

		$query = $this->CI->db->get_where("env", array("status"=>1));        

		return $query->result();

	}

	

	/**

	 * @author		Rodrigo Romero

	 * @return      Array all Elements Modulos and Permisos

	 * @access	    public

	 */

	private function _modulesRead(){

		$query = $this->CI->db->get_where("sys_modulos");

		return $query->result();

	}

	

	/**

	 * TODO LOGIN REQUIRED

	 */

	   /*

		//LOGIN REQUIRED

		$login_function = explode("login", $function);

		if(get_env("site_login_required")==1 && !is_login() && count($login_function)<2){

			header("Location: ".lang_url("mi-cuenta/login"));

		}

		

		$this->Clang = config_item("language");   

		$this->lang->load('site', $this->Clang);

		*/

	

}
