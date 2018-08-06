<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class lunchs_mod extends RR_Model {
	var $atributo       = 'lunch';
	var $table          = 'tickets';
	var $module         = 'lunchs';
	var $module_title   = "Lunch";
	var $id;
	var $eid;

	public function __construct() {
		parent::__construct();
		$this->eid   = !empty($this->params['eid']) ? $this->params['eid'] : '';
		$this->id    = !empty($this->params['id']) ? $this->params['id'] : '';
	}

	public function listado(){
		if(isset($this->params['f']) && !empty($this->params['f'])){
			$this->download_file();
			die;
		}
		$this->breadcrumb->addCrumb($this->module_title,'');
		$this->breadcrumb->addCrumb('Listado','','current');
		$datagrid["columns"][] = array("title" => "", "field" => "", "width" => "46");
		$datagrid["columns"][] = array("title" => "Nombre", "field" => "nombre", 'sort'=>'t.nombre');
		$datagrid["columns"][] = array("title" => "Precio", "field" => "precio_regular", 'sort'=>'t.precio_regular');
		$datagrid["columns"][] = array("title" => "Status", "field" => "status", 'format'=>'icon-activo');
#CONDICIONES & CACHE DE CONDICIONES
		$this->db->start_cache();
		$this->db->select('t.id, t.nombre, t.precio_regular, t.precio_oferta, t.status', false);
		$this->db->where('t.evento_id =',$this->eid);
		$this->db->where('t.status >=',0);
		$this->db->where('t.tipo',2);
		if(isset($_POST['search']) && !empty($_POST['search'])) {
			$like_arr = array('t.nombre');
			foreach($like_arr as  $l){
				$like_str .= $l." LIKE '%".$this->input->post('search',true)."%' OR ";
			}
			$like_str = '('.substr($like_str,0,-4).')';
			$this->db->where($like_str);
		}
		if(isset($_POST['order']) && !empty($_POST['order'])) {
			$order = explode("-",$this->input->post('order',true));
			$this->db->order_by($datagrid['columns'][$order[1]]['sort'],$order[0]);
		} else {
			$this->db->order_by('t.precio_regular','ASC');
		}
		$this->db->from($this->table.' t');
		$this->db->stop_cache();
#TOTAL REGISTROS
		$total = $this->db->count_all_results();
		$limit = isset($_POST['limit']) ? $this->input->post('limit',true) : '';
		switch($limit){
			case '-1':
			case '':
			break;
			case 'all':
			$this->limit = $total;
			break;
			default:
			$this->limit = $limit;
			break;
		}
#PAGINADO
		$page  = (isset($_POST['page']) && !empty($_POST['page'])) ? $this->input->post('page',true) : 1;
		if($page!="all"){
			$from  = ($page-1)*$this->limit;
			$this->db->limit($this->limit, $from);
		}
		$paginador = $this->paging_mod->get_paging($total, $this->limit);
		$query = $this->db->get();
		$this->db->flush_cache();
//CONFIG
		$lnk_del = set_url(array('a'=>'chk_deletea'));
		$html  = "<a class='ax-modal tip-top icon-trash' href='".$lnk_del."/id/{%id%}' data-original-title='Eliminar' style='margin-right:10px'></a>";
		$upd_del = set_url(array('a' =>'newa', 'iu'=>'update'));
		$html .= "<a class='tip-top' href='".$upd_del."/id/{%id%}' data-original-title='Editar'><span class='icon-pencil'></span></a>";
		$extra[] = array("html" => $html, "pos" => 0);
		$datagrid["rows"]      = $this->datagrid->query_to_rows($query->result(), $datagrid["columns"], $extra);
//echo $this->input->post('nombre');
		$filter_data = array('nombre' => $this->input->post('nombre',true),
			'limit'  => $this->limit
			);
		$action_links['new'] =  array('action' => set_url(array('a'=>'newa', 'iu'=>'new')), 'title' => 'Nuevo '.$this->module);
//$action_links['exporta'] =  array('action' => set_url(array('a' =>'exporta')), 'title' => 'Exportar');
		$filter = $this->view("filters/".$this->atributo, $filter_data);
		$dg = array("datagrid"   => $datagrid,
			"filters"    => $filter,
			'grid_lnk'   => $action_links,
			"paging"     => $paginador,
			'grid_title' => $this->module_title
			);
		$grid = $this->datagrid->make($dg);
		if(!$this->input->is_ajax_request()) {
			return $grid;
		} else {
			return array('success'=>false, 'value'=>$grid, 'responseType' => 'inject', 'inject'=>'j-a');
		}
	}

	public function newa(){
		$data_panel['action']      = set_url(array('a'=>'savea'));
		$data_panel['back']        = base_url('module/load/m/'.$this->module.'/a/listado/eid/'.$this->eid);
		$data_panel['title']       = $this->module_title;
		$this->breadcrumb->addCrumb($this->module_title,base_url('module/load/m/'.$this->module.'/a/listado/eid/'.$this->eid));
		$data_panel['oradores'] = $this->db->get_where('oradores', array('status'=>1, 'evento_id'=>$this->eid))->result();
		if(!empty($this->id)) {
			$this->breadcrumb->addCrumb('Editar','','current');
			$data_panel['row'] = $this->db->get_where($this->table, array('id'=>$this->id))->row();
		} else {
			$this->breadcrumb->addCrumb('Nueva','','current');
		}
		$panel = $this->view("panels/".$this->atributo, $data_panel);
		return $panel;
	}

	public function chk_deletea(){
		return $this->check_deletea();
	}

	public function deletea(){
		if(!empty($this->id)) {
			$values = array('status'=>-1);
			$this->db->where('id', $this->id);
			$query = $this->db->update($this->table, array_merge($this->u, $values));
			if($query){
				$success = true;
				$responseType = 'function';
				$function     = 'reloadTable';
				$status       = $this->view('alerts/generic', array('success'=>'Registro Eliminado Exitosamente', 'type'=>'success'));
				$data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>$function,  "html"=>base_url('module/load/m/'.$this->module.'/a/listado/eid/'.$this->eid), 'status'=>$status);
			}
		}
		return $data;
	}

	public function savea(){
		#VALIDO FORM POR PHP
		$success = 'false';
		$config = array(array('field' => 'nombre', 'label' => 'Nombre', 'rules' => 'trim|required'),
			array('field' => 'precio_regular', 'label' => 'Precio Regular', 'rules' => 'trim|required|numeric'),
			);
		$this->form_validation->set_rules($config);
		if($this->form_validation->run()==FALSE){
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$responseType = 'function';
			$function     = 'appendFormMessages';
			$messages     = validation_errors();
			$data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function);
		} else {
			$status = 0;
			if (isset($_POST['status'])) $status = 1;

			$agotadas = 0;
			if (isset($_POST['agotadas'])) $agotadas = 1;
			$values = array('evento_id'      => $this->eid,
				'nombre'         => $this->input->post('nombre',true),
				'bajada'         => $this->input->post('bajada', true),
				'precio_regular' => $this->input->post('precio_regular', true),
				'precio_oferta'  => 0,
				'fecha_baja'     => (filter_input(INPUT_POST,'fecha_baja')) ? getFechasSQL($this->input->post('fecha_baja', true)) : '',
				'descripcion'    => $this->input->post('descripcion', true),
				'status'         => $status,
				'agotadas'       => $agotadas,
				'background'     => $this->input->post('background', true),
				'sku'            => str_replace(' ', '_', strtolower($this->input->post('nombre',true)).'_'.$this->input->post('precio_regular', true).'-'.$this->eid) ,
				'min_qty'        => (filter_input(INPUT_POST,'min_qty')) ? $this->input->post('min_qty', true) : 0,
				'max_qty'        => (filter_input(INPUT_POST,'min_qty')) ? $this->input->post('max_qty', true) : 0,
				'tipo'			 => 2

				);
			switch($this->params['iu']) {
				case 'new':
				$query = $this->db->insert($this->table, array_merge($values,$this->i));
				$this->id = $this->db->insert_id();
				$this->session->set_flashdata('insert_success', 'Registro Insertado Exitosamente');
				break;
				case 'update':
				$this->db->where('id',$this->id);
				$query = $this->db->update($this->table, array_merge($values,$this->u));
				$this->session->set_flashdata('insert_success', 'Registro Actualizado Exitosamente');
				break;
			}
			if($query){
				$success = true;
				$responseType = 'redirect';
				$data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>base_url('module/load/m/'.$this->module.'/a/listado/eid/'.$this->eid));
			}
		}
		return $data;
	}

	public function getDescriptionLine() {
		$success = true;
		$responseType = 'function';
		$function     = 'appenLines';
		$rules        = $this->view('panels/plan_detail', array('pos'=>$this->params['pos']));
		$data         = array('success' =>$success,'responseType'=>$responseType, 'value'=>$function,  "html"=>$rules);
		return $data;
	}
}
