<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 1.0.1
 */

class RR_Model extends CI_Model
{
    var $Clang;
    var $today;
    var $i;
    var $u;
    var $params;
    var $sistema_id;
    var $langs; 
    var $limit = 15;
    var $evento_id;
    public function __construct()
    {
        
        parent::__construct();
        $this->Clang = config_item("language");
        $this->today = date('Y-m-d H:i:s');
        $this->i = array("fa"  => date('Y-m-d H:i:s'), "status"=>1);  
        $this->u = array("fum"  => date('Y-m-d H:i:s'), "uum"=>get_session('admin_id',false));  
        $this->params = $this->uri->uri_to_assoc(1);
        $this->sistema_id = get_session('sistema_id',false);
        $this->langs = $this->config->item("languages");
        $this->evento_id = $this->get_evento()->id;
    }
    public function view($view, $vars = array(), $return = true)
    {
        $vars["Clang"] = $this->Clang;
        return $this->load->view($view, $vars, $return) . "\n";
    }
    
    function post_lang($str, $lang){
        return (!empty($_POST[$str.'_'.$lang])) ? $this->input->post($str.'_'.$lang) : $this->input->post($str.'_'.$this->langs[0]);
    }
    
    public function get_evento(){
        return $this->db->get_where('eventos',array('status'=>1))->row();        
    }
    /*
    public function _getAtributos($id, $child=NULL){        
        $this->db->select("id, nombre, status, json");
        if(is_null($child)){
            $return = $this->db->get_where("atributos", array("status >="=>0, "id >" => ($id*10000), "id <" => (($id+1)*10000) ))->result();
        } else {
            $return = $this->db->get_where("atributos", array("status >="=>0, "id" => $child, 'padre_id'=>$id))->row();
        }
        return $return;
    }
    */
    
    public function get_atributos($table, $row=false, $id=NULL, $order=NULL){       
       
        $this->db->select("*");
        if(!empty($id) && $id!=NULL){
            $this->db->where('id',$id);
        }
        
        if(!empty($order)){
            $this->db->order_by($order,"ASC");
        }
        
        $query = $this->db->get_where($table,array('status'=>1));
      
        if($row){
            $return = $query->row(); 
        } else {
            $return = $query->result();
        }
        
      
        return $return;
    }
    
    public function get_managers($id=false){
        $this->db->select('id, abr nombre',false);
        if($id) {
            $this->db->where('id',$id);
        }
        $result = $this->db->get_where('managers',array('status'=>1));
        
        if($id){
            return $result->row();
        } else {
            return $result->result();
        }
    }
    public function check_deletea(){        
        if(!empty($this->id)){           
            $success      = 1;
            $responseType = 'function';
            $data = array('title'   => 'Eliminar Registo',
                          'texto'   => 'Estas seguro que deseas eliminar este registro ?',
                          'link'    => set_url(array('a'=>'deletea')),                 
                    );
            $html         = $this->view('alerts/modal_dialog', $data);
            $function     = 'open_modal';
            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$html, 'value'=>$function);
        }
        return $data;
    }
    
    
   
}