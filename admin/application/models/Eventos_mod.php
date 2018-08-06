<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);
/**
 * @author Rodrigo Romero
 * @version 1.0.0
 *
 *  TODO: LOG
 */
require_once(BASEPATH."../assets/widgets/uploadManager/UploadManager.php");
class eventos_mod extends RR_Model {
    var $atributo       = 'eventos';
    var $table          = 'eventos';
    var $module         = 'eventos';
    var $module_title   = "Eventos";
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
        $datagrid["columns"][] = array("title" => "Fecha Inicio", "field" => "fecha_inicio", "format"=>'datetime', 'sort'=>'fecha_inicio');
        $datagrid["columns"][] = array("title" => "Secciones", "field" => "", "width" => "85");
        $datagrid["columns"][] = array("title" => "Activo", "field" => "status", 'format'=>'icon-activo');
        #CONDICIONES & CACHE DE CONDICIONES
        $this->db->start_cache();
        $this->db->where('status >=',0);
        if(isset($_POST['search']) && !empty($_POST['search'])) {
            $like_arr = array('e.nombre', 'e.bajada','e.descripcion');
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
            $this->db->order_by('e.id','DESC');
        }
        $this->db->from($this->table.' e');
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
        $lnk_del       = set_url(array('a'=>'chk_deletea', 'id'=>'{%id%}'));
        $upd_del       = set_url(array('a' =>'newa', 'iu'=>'update', 'id'=>'{%id%}'));
        $lnk_oradores  = set_url(array('m' =>'oradores', 'a'=>'listado', 'eid'=>'{%id%}'));
        $lnk_sponsors  = set_url(array('m' =>'sponsors', 'a'=>'listado', 'eid'=>'{%id%}'));
        $lnk_agenda    = set_url(array('m' =>'agenda', 'a'=>'listado', 'eid'=>'{%id%}'));
        $lnk_tickets   = set_url(array('m' =>'tickets', 'a'=>'listado', 'eid'=>'{%id%}'));
        $lnk_cupons    = set_url(array('m' =>'cupons', 'a'=>'listado', 'eid'=>'{%id%}'));
        $lnk_lunch     = set_url(array('m' =>'lunchs', 'a'=>'listado', 'eid'=>'{%id%}'));
        $html  = "<a class='ax-modal tip-top icon-trash' href='".$lnk_del."' data-original-title='Eliminar' style='margin-right:10px'></a>";
        $html .= "<a class='tip-top' href='".$upd_del."' data-original-title='Editar'><span class='icon-pencil'></span></a>";
        $html_secciones  = "<a class='tip-top icon-bullhorn' href='".$lnk_oradores."' data-original-title='Alta Oradores' style='margin-right:10px'></a>";
        $html_secciones .= "<a class='tip-top icon-globe' href='".$lnk_sponsors."' data-original-title='Alta Sponsors' style='margin-right:10px'></a>";
        $html_secciones .= "<a class='tip-top icon-calendar' href='".$lnk_agenda."' data-original-title='Alta Agenda' style='margin-right:10px'></a>";
        $html_secciones .= "<a class='tip-top icon-ticket' href='".$lnk_tickets."' data-original-title='Alta Tickets' style='margin-right:10px'></a>";
        $html_secciones .= "<a class='tip-top icon-usd' href='".$lnk_cupons."' data-original-title='Alta Cupones' style='margin-right:10px'></a>";
        $html_secciones .= "<a class='tip-top icon-food' href='".$lnk_lunch."' data-original-title='Alta Almuerzo'></a>";
        $extra[] = array("html" => $html, "pos" => 0);
        $extra[] = array("html" => $html_secciones, "pos" => 3);
        $datagrid["rows"]      = $this->datagrid->query_to_rows($query->result(), $datagrid["columns"], $extra);
        //echo $this->input->post('nombre');
        $filter_data = array('nombre' => $this->input->post('nombre',true),
                             'limit'  => $this->limit
                            );
        $action_links['new'] =  array('action' => set_url(array('a'=>'newa', 'iu'=>'new')), 'title' => 'Nuevo '.$this->module);
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
        $data_panel['title']        = 'Eventos';
        $this->breadcrumb->addCrumb($this->module_title,'');
        $data_panel['gateways'] = $this->db->get_where('gateways',array('status'=>1))->result();
        if(!empty($this->id)) {
            $this->breadcrumb->addCrumb('Editar','','current');
            $data_panel['row_evento']   = $this->db->get_where($this->table,array('id'=>$this->id))->row();
            $data_panel['row_lugar']    = $this->db->get_where('lugares',array('evento_id'=>$this->id))->row();
            $data_panel['row_oradores'] = $this->db->get_where('oradores',array('evento_id'=>$this->id))->result();
        } else {
            $this->breadcrumb->addCrumb('Nueva','','current');
        }
        $panel = $this->view("panels/".$this->atributo, $data_panel);
        return $panel;
    }
    /*
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
    */
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
        #VALIDO FORM POR PHP
        $success = 'false';
        $config = array(array('field' => 'evento[nombre]', 'label' => 'Nombre del Evento', 'rules' => 'trim|required'),
                     array('field'  => 'evento[bajada]', 'label' => 'Bajada del Evento', 'rules' => 'trim|required'),
                     array('field'  => 'evento[dia_inicia]', 'label' => 'Fecha Inicio del Evento', 'rules' => 'trim|required'),
                     array('field'  => 'evento[brief]', 'label' => 'Resumen del Evento', 'rules' => 'trim|required'),
                     array('field'  => 'lugar[place]', 'label' => 'Lugar del Evento', 'rules' => 'trim|required'),
                     array('field'  => 'lugar[address]', 'label' => 'Direcci�n del Evento', 'rules' => 'trim|required'),
                    );
         $this->form_validation->set_rules($config);
         if($this->form_validation->run()==FALSE){
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $responseType = 'function';
            $function     = 'appendFormMessages';
            $messages     = validation_errors();
            $data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function);
         } else {
            $data_evento   = $this->input->post('evento',true);
            $data_lugar    = $this->input->post('lugar',true);
            $status = 0;
            if (isset($_POST['status'])) $status = 1;
            $newsletter = 0;
            if (isset($data_evento['newsletter'])) $newsletter = 1;
            $show_register = 0;
            if (isset($data_evento['show_register'])) $show_register = 1;
            $payments_enabled = 0;
            if (isset($data_evento['payments_enabled'])) $payments_enabled = 1;
            $cupons_enabled = 0;
            if (isset($data_evento['cupons'])) $cupons_enabled = 1;

            $show_full_bio = 0;
            if (isset($data_evento['show_full_bio'])) $show_full_bio = 1;

            $json_socials  = array('twitter'=>$data_evento['twitter'], 'faceboook'=>$data_evento['facebook']);
            $values_evento = array ('nombre'            => $data_evento['nombre'],
                                    'bajada'            => $data_evento['bajada'],
                                    'descripcion'       => $data_evento['brief'],
                                    'fecha_inicio'      => getFechasSQL($data_evento['dia_inicia']).' '.$data_evento['hora_inicia'],
                                    'fecha_baja'        => getFechasSQL($data_evento['dia_finaliza']).' '.$data_evento['hora_finaliza'],
                                    'telefono'          => $data_evento['telefono'],
                                    'capacidad'         => 0,
                                    'costo'             => 0,
                                    'skin_id'           => $data_evento['skin'],
                                    'json_socials'      => json_encode($json_socials),
                                    'usuario_id'        => 1,
                                    'newsletter'        => $newsletter,
                                    'status'            => $status,
                                    'reminder_one'      => (!empty($data_evento['reminder_one'])) ? getFechasSQL($data_evento['reminder_one']): '',
                                    'reminder_two'      => (!empty($data_evento['reminder_two'])) ? getFechasSQL($data_evento['reminder_two']) : '',
                                    'show_register'     => $show_register,
                                    'payments_enabled'  => $payments_enabled,
                                    'cupons_enabled'    => $cupons_enabled,
                                    'show_full_bio'		=> $show_full_bio
                                    );
            $values_lugar = array('lugar'           => $data_lugar['place'],
                                  'direccion'       => $data_lugar['address'],
                                  'json_direccion'  => $data_lugar['json_direccion']
                                 );
           $this->db->trans_start();
            switch($this->params['iu']) {
                    case 'new':
                        $query = $this->db->insert($this->table, array_merge($values_evento,$this->i));
                        $this->id  = $this->db->insert_id();
                        if(!empty($this->id)){
                            $query = $this->db->insert('lugares', array_merge($values_lugar, array('evento_id'=>$this->id), $this->i));
                            if($query){
                                $this->session->set_flashdata('insert_success', 'Registro Insertado Exitosamente');
                            }
                        }
                        break;
                    case 'update':
                        $this->db->where('id',$this->id);
                        $query = $this->db->update($this->table, array_merge($values_evento,$this->u));
                        if($query) {
                            $this->db->where('evento_id', $this->id);
                            $query = $this->db->update('lugares', array_merge($values_lugar,$this->u));
                            if($query){
                                $this->session->set_flashdata('insert_success', 'Registro Actualizado Exitosamente');
                            }
                        }
                        break;
            }
            $this->db->trans_complete();
            if($this->db->trans_status()===FALSE){
            } else {
                $success = true;
                $responseType = 'redirect';
                $data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>base_url('module/load/m/'.$this->module.'/a/listado'));
            }
        }
        $up = new UploadManager();
        $resize = $up->resize($this->id, BASEPATH."../assets/widgets/uploadManager/");
        return $data;
    }
    public function getEvento(){
        $this->db->join('lugares','lugares.evento_id = eventos.id','left');
        $result = $this->db->get_where('eventos',array('eventos.status'=>1))->row();
		return $result;
    }
}
