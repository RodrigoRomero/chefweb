<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 1.0.1
 */

abstract class RR_Controller extends CI_Controller {
	var $title;
	var $extra_title;
	var $description;
	var $keywords;
	var $metaTypes = array('title','keywords','description');
	var $params;
	var $Clang;
	var $skin_id;
	var $evento;
	var $page_title;
	var $today;
	var $zap_link;
	var $insta_link;
	var $canonical_url;

	protected $module_title;
	protected $layout     = 'layout/one_page';

	protected $css_layout = array('bootstrap', 'style', 'swiper', 'dark', 'font-icons', 'animate', 'magnific-popup', 'responsive', 'pricing-table', 'ion.rangeslider','components/radio-checkbox');
	protected $css_view   = array();

	protected $js_layout  = array('jquery','modernizr','plugins', 'functions', 'rangeslider.min', 'keeper', 'main');
	protected $js_view    = array();

	protected $widget_layout = array('validate'=>array('js'=>array('jquery.validate','messages_es')),
									 'datepicker'=>array('js'=>array('datepicker'), 'css'=> array('datepicker'))
									);
	protected $widget_view  = array();
	protected $class;

	public function __construct() {
		parent::__construct();
		$this->zap_link = 'https://wa.me/5491167825824?text='.urlencode('Hola! Quisiera que me envien info sobre las hamburguesas.');
		$this->insta_link = 'https://www.instagram.com/rodrigolromero/';
		$this->canonical_url = base_url($this->uri->uri_string());
		$this->load->model('main_mod','Main');
		$this->today  = date('Y-m-d H:i:s');

		#CONFIGURO LENGUAJE
		$this->Clang  = $this->config->item("language");

		#DEVUELVE NOMBRE DEL CLASS
		$this->class   = $this->router->fetch_class();

		#DEVUELVE NOMBRE DEL METHOD
		$method   = $this->router->fetch_method();
		$function = $this->uri->rsegment(2);

		#VERIFICAO ESTADO DE SISTEMA
		$this->_checkSistema();
		//$this->_setSkin($this->Main->getSkinId());

		foreach($this->metaTypes as $metas) {
			$this->setMeta($metas);
		}

		#VERIFICO SI EL USUARIO ESTA LOGUEADO Y LO REDIRECCIONO DONDE CORRESPONDE
		#SI NO ESTA LOGUEADO LO MANDO A LOGIN
		#SI ESTA LOGUEADO SIGO CARGANDO EL SISTEMA



		if($this->_loginRequired()==TRUE){
			$login_function = explode("login", $function);
			if($this->zt_auth->loggedin()==false && count($login_function)<2){
				redirect('/auth/login');
			};
		}


		$this->params    = $this->uri->uri_to_assoc(1);

		$this->evento = $this->Main->getActiveEvent();

	}


	public function view($view, $vars=array(), $return = TRUE){
		$vars["Clang"] = $this->Clang;

		return $this->load->view($view, $vars, $return)."\n";
	}

	public function show_main($module=null){

		$data = array(

					"module"      => $module,
					  //"menu_top"    => $this->view('layout/menu_top', array('title_page'=>$this->title, 'layout'=>$this->layout)),
					  //"section"     => $this->_getSectionTitle(),
					 // "data_menu"   => $this->Main->getCategoriesMenu(),
					"description" => $this->description,
				    "keywords"    => $this->keywords,
					"title_page"  => $this->title,
					"css_layout"  => $this->_getCss(),
					//  "skin"        => $this->skin_id,
					 "footer"      => $this->view('layout/footer', array("js_layout" => $this->_getJs(), "widgets" => $this->_getWidgets(), 'title_page'=>$this->title)),

		);
		return $this->view($this->layout, $data);
   }

   /**
	* Metas
	* @access		public
	* @param		string    meta
	* @param		string    tipo - title, keywords, description
	* @return		void
	*/

	public function setMeta($type,$str='') {

		$return = false;
		$Clang = $this->Clang;
		if(!empty($type)) {
			switch($type) {
				case 'title':
					$title = $this->env->getEnv('site_name');
					$str = (!empty($str)) ? $str.' : '.$title->lang->$Clang->valor  : $title->lang->$Clang->valor ;
				break;
				case 'keywords':
					$keywords = $this->env->getEnv('site_keywords');
					$str = (!empty($str)) ? $str.' : '.$keywords->lang->$Clang->valor : $keywords->lang->$Clang->valor;

				break;
				case 'description':
					$description = $this->env->getEnv('site_description');
					$str = (!empty($str)) ? $str.' : '.$description->lang->$Clang->valor : $description->lang->$Clang->valor;
				break;

			}

			$this->$type = $str;

		} else {
			return $return;
		}
	}


	/**
	* Metas
	* @access		public
	* @param		string    tipo - title, keywords, description
	* @return		return meta
	*/

	public function getMeta($type){
		$return = false;
		if(!empty($type)) {
			$type = strtolower($type);
			if(in_array($type, $this->metaTypes)){
				return $this->$type;
			}
		}

		return $return;
	}


	protected function _getCss(){
		return array_merge($this->css_layout, $this->css_view);
	}

	protected function _getJs(){
		return array_merge($this->js_layout, $this->js_view);
	}

	protected function _getWidgets() {
		return array_merge($this->widget_layout, $this->widget_view);
	}


	private function _checkSistema(){
		/*
		$result = $this->db->get_where('env',array('status'=>1, 'id'=>'sistema_status', 'system'=>1))
						   ->row();

		if($result->valor==0) {
		   show_error('Estamos trabajando en el mantenimiento del sitio en breve estará nuevamente en línea',503,'Sitio en Mantenimiento');
		}
		*/
	}

	private function _loginRequired(){
		$result = $this->db->get_where('env',array('status'=>1, 'id'=>'login_required', 'system'=>1))
						   ->row();

		if($result->valor==1) {
		   return 1;
		}
	}

	protected function _getSectionTitle(){
		if(!empty($this->module_title)){
			$sectionTitle = $this->module_title;
		} else {
			$sectionTitle = ucfirst($this->class).$this->extra_title;
		}
		return $sectionTitle;
	}

	private function _setSkin($data){
		 $skin = json_decode($data->skin);
		 $this->skin_id   = $skin->lang->{$this->Clang}->descripcion;
	}




}
