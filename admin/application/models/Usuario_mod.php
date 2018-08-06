<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);
/**
 * @author Rodrigo Romero
 * @version 1.0.0
 *
 *  TODO: LOG
 */
class Usuario_mod extends RR_Model {
    var $atributo       = 'usuarios';
    var $table          = 'admin';
    var $module         = 'usuario';
    var $module_title   = "Usuarios";
    private $check_pass = "orsoniaDigital";
    var $id;

	public function __construct() {
 		parent::__construct();
        $this->id   = !empty($this->params['id']) ? $this->params['id'] : '';
    }

    public function listado(){
        $this->breadcrumb->addCrumb($this->module_title,'');
        $this->breadcrumb->addCrumb('Listado','','current');
        $datagrid["columns"][] = array("title" => "", "field" => "", "width" => "46");
        $datagrid["columns"][] = array("title" => "Nombre", "field" => "nombre", 'sort'=>'nombre');
        $datagrid["columns"][] = array("title" => "Apellido", "field" => "apellido", 'sort'=>'apellido');
        $datagrid["columns"][] = array("title" => "Email", "field" => "email", 'sort'=>'email');
        $datagrid["columns"][] = array("title" => "Activo", "field" => "status", 'format'=>'icon-activo');
        $datagrid["columns"][] = array("title" => "Principal", "field" => "principal", 'format'=>'icon-level');
        #CONDICIONES & CACHE DE CONDICIONES
        $this->db->start_cache();
        $this->db->where('status >',0);
        if(isset($_POST['search']) && !empty($_POST['search'])) {
            $like_arr = array('nombre', 'apellido','email');
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
            $this->db->order_by('principal','DESC');
        }
        $this->db->from($this->table);
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
        $upd_del = set_url(array('a' =>'newa', 'iu'=>'update'));
        $html  = "<a class='ax-modal tip-top icon-trash' href='".$lnk_del."/id/{%id%}' data-original-title='Eliminar' style='margin-right:10px'></a>";
		$html .= "<a class='tip-top' href='".$upd_del."/id/{%id%}' data-original-title='Editar'><span class='icon-pencil'></span></a>";
        $extra[] = array("html" => $html, "pos" => 0);
        $datagrid["rows"]      = $this->datagrid->query_to_rows($query->result(), $datagrid["columns"], $extra);
        //echo $this->input->post('nombre');
        $filter_data = array('nombre' => $this->input->post('nombre',true),
                             'limit'  => $this->limit
                            );
        $action_links['new'] =  array('action' => set_url(array('a'=>'newa', 'iu'=>'new')), 'title' => 'Nuevo Usuario');
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
        $data_panel['back']        = base_url('module/load/m/'.$this->module.'/a/listado');
        $this->breadcrumb->addCrumb($this->module_title,'');
        if(!empty($this->id)) {
            $this->breadcrumb->addCrumb('Editar','','current');
            $data_panel['row'] = $this->db->get_where($this->table,array('id'=>$this->id))->row();
            $data_panel['row']->password = $this->check_pass;
        } else {
            $this->breadcrumb->addCrumb('Nueva','','current');
        }
        $panel = $this->view("panels/".$this->atributo, $data_panel);
        return $panel;
    }

    public function chk_deletea(){
       if(!empty($this->id)){
            $mainUser = $this->db->select('principal')->get_where($this->table,array('id'=>$this->id,'status'=>1))->row();
            if($mainUser->principal == 1) {
                $data = array('title'   => 'Eliminar Usuario',
                              'texto'   => 'No es posible eliminar el usuario que ha seleccionado, dado que el mismo es el usuario maestro del su sistema.<br/>Si desea eliminarlo por favor contactese con los administradores del sistema, para asignar un nuevo usuario maestro.',
                              'link'    => false,
                    );
            } else {
                $data = array('title'   => 'Eliminar Usuario',
                              'texto'   => 'Estas seguro que deseas eliminar este registro ?',
                              'link'    => set_url(array('a'=>'deletea')),
                    );
            }
            $success      = 1;
            $responseType = 'function';
            $html         = $this->view('alerts/modal_dialog', $data);
            $function     = 'open_modal';
            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$html, 'value'=>$function);
        }
        return $data;
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
                $data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>$function,  "html"=>base_url('module/load/m/'.$this->module.'/a/listado'), 'status'=>$status);
            }
        }
        return $data;
    }

    public function savea(){

    	//print_r($_POST);
    	//die;
        #VALIDO FORM POR PHP
         $success = 'false';
         if($this->form_validation->run('Usuarios')==FALSE){
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $responseType = 'function';
            $function     = 'appendFormMessages';
            $messages     = validation_errors();
            $data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function);
         } else {
            $activo = 0;
            if (isset($_POST['status'])) $activo = 1;
            $values = array('nombre'     => $this->input->post('nombre',true),
                            'apellido'   => $this->input->post('apellido', true),
                            'email'      => $this->input->post('email',true),
                            'status'     => $activo,
                            'principal'  => 0
                           );
            #SI EL PASS CAMBIA AL DEFAULT ORSONIA LO ACTUALIZO
            if($this->input->post('password') != md5($this->check_pass)) {
                    $values['password']   = $this->input->post('password');
            }
            switch($this->params['iu']) {
                case 'new':
                    $query = $this->db->insert($this->table, array_merge($values,$this->i));
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
                $data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>base_url('module/load/m/'.$this->module.'/a/listado'));
            }
        }
        return $data;
    }
}
