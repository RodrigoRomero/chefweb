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
class categoriasponsor_mod extends RR_Model {
    var $atributo       = 'categoriasponsor';
    var $table          = 'categoriasponsors';
    var $module         = 'categoriasponsor';
    var $module_title   = "Categorías Sponsors";
    var $id;

	public function __construct() {
 		parent::__construct();
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
        $datagrid["columns"][] = array("title" => "Nombre", "field" => "nombre", 'sort'=>'o.nombre');
        $datagrid["columns"][] = array("title" => "Status", "field" => "status", 'format'=>'icon-activo');
        $datagrid['columns'][] = array("title" => 'Ordenar',"field" => "", "width" => "46", "class"=>"hide");
        #CONDICIONES & CACHE DE CONDICIONES
        $this->db->start_cache();
        $this->db->select('o.id, o.nombre, o.status', false);
        $this->db->where('o.status >=',0);
        if(isset($_POST['search']) && !empty($_POST['search'])) {
            $like_arr = array('o.nombre', 'o.apellido', 'o.email');
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
            $this->db->order_by('o.orden','ASC');
        }
        $this->db->from($this->table.' o');
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

        $html2 = "<a class='tip-top' href=javascript:void(0)' data-original-title='Ordenar'><span class='icon-resize-vertical'></span></a>";

				$extra[1] = array("html" => $html2, "pos" => 3);


        $datagrid["rows"]      = $this->datagrid->query_to_rows($query->result(), $datagrid["columns"], $extra);
        //echo $this->input->post('nombre');
        $filter_data = array('nombre' => $this->input->post('nombre',true),
                             'limit'  => $this->limit,
                             'order' => set_url(array('a'=>'update_order'))
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
        $data_panel['back']        = base_url('module/load/m/'.$this->module.'/a/listado');
        $data_panel['title']       = $this->module_title;
        $this->breadcrumb->addCrumb($this->module_title,base_url('module/load/m/'.$this->module.'/a/listado'));
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
                $data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>$function,  "html"=>base_url('module/load/m/'.$this->module.'/a/listado'), 'status'=>$status);
            }
        }
        return $data;
    }

    public function savea(){
        #VALIDO FORM POR PHP
         $success = 'false';
         $config = array(array('field' => 'nombre', 'label' => 'Nombre', 'rules' => 'trim|required')
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
            $json_socials = array('twitter'=>$this->input->post('twitter',true), 'faceboook'=>$this->input->post('facebook',true));
            $json_socials = json_encode($json_socials);
            $values = array('nombre'        => $this->input->post('nombre',true),
                            'status'        => $status,
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
            $up = new UploadManager();
            $resize = $up->resize($this->id, BASEPATH . "../assets/widgets/uploadManager/");
        }
        return $data;
    }

    public function exporta(){
        $file_name = 'suscriptores_report';
        $result = $this->db->select('u.*',false)
                           ->from($this->table.' u')
                           ->get()
                           ->result();
        $alphas = array('A');
        $current = 'A';
        while ($current != 'ZZZ') {
            $alphas[] = ++$current;
        }
        $this->load->library('PHPExcel');
        $this->phpexcel->getProperties()->setCreator("Orsonia Digital")
							            ->setLastModifiedBy("Orsonia Digital")
							            ->setTitle("Orsonia Digital")
							            ->setSubject("Orsonia Digital")
							            ->setDescription("Orsonia Digital")
							            ->setKeywords("Orsonia Digital")
							            ->setCategory("Orsonia Digital");
        $columns[] = array("title" => "Nombre");
        $columns[] = array("title" => "Apellido");
        $columns[] = array("title" => "Email");
        $columns[] = array("title" => "Status");
        $nro_cols = (count($columns)-1);
        $this->phpexcel->getActiveSheet()->mergeCells('A1:'.$alphas[$nro_cols].'1');
        $this->phpexcel->getActiveSheet()->mergeCells('A2:'.$alphas[$nro_cols].'2');
        $this->phpexcel->getActiveSheet()->setCellValue("A2", "");
        $this->phpexcel->getActiveSheet()->setCellValue("A1", "Suscriptos al ".date('d-M-Y'));
        $this->phpexcel->getActiveSheet()->getStyle("A1:".$alphas[$nro_cols].'1')->applyFromArray(
                                                                            array('fill' => array(
    	                                                                                          'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
    	                                                                                          'color'   => array('rgb' => 'EFEFEF')
                                                                                                 ),
                                                                                  'font' => array(
                                                                                                  'bold' => true,
                                                                                                  'size' => 14
                                                                                                 ),
                                                                                  'alignment' => array(
                                                                                                       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                                                                      ),
                                                                                  'borders' => array(
                                                                                                     'outline' => array(
                                                                                                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                                                                                                            'color' => array('argb' => '0000000'),
                                                                                                     ),
                                                                                               ),
                                                                                  )
                                                                           );
        foreach($columns as $columnKey => $column){
            $this->phpexcel->getActiveSheet()->setCellValue($alphas[$columnKey]."3", $column['title']);
            $this->phpexcel->getActiveSheet()->getColumnDimensionByColumn($alphas[$columnKey]."3")->setAutoSize(true);
        }
        $this->phpexcel->getActiveSheet()->getStyle("A3:".$alphas[$nro_cols].'3')->applyFromArray(
                                                                            array(
                                                                                  'font' => array(
                                                                                                  'bold' => true,
                                                                                                  'size' => 12
                                                                                                 ),
                                                                                  'alignment' => array(
                                                                                                       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                                                                      ),
                                                                                  'borders' => array(
                                                                                                     'outline' => array(
                                                                                                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                                                                                                            'color' => array('argb' => '0000000'),
                                                                                                     ),
                                                                                               ),
                                                                                  )
                                                                           );
        $i = 4;
        foreach($result as $rowKey =>$row) {
            $this->phpexcel->getActiveSheet()->setCellValue("A".$i, $row->nombre);
            $this->phpexcel->getActiveSheet()->getStyle("A".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
            $this->phpexcel->getActiveSheet()->setCellValue("B".$i, $row->apellido);
            $this->phpexcel->getActiveSheet()->getStyle("B".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
            $this->phpexcel->getActiveSheet()->setCellValue("C".$i, $row->email);
            $this->phpexcel->getActiveSheet()->getStyle("C".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
            $this->phpexcel->getActiveSheet()->setCellValue("D".$i, $row->status);
            $this->phpexcel->getActiveSheet()->getStyle("D".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
            $i++;
        }
       $this->phpexcel->getActiveSheet()->setTitle('Suscriptores TSD Report');
       $this->phpexcel->setActiveSheetIndex(0);
       $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007');
       $objWriter->save('../uploads/data/'.$file_name.'.xlsx');
       $messages     = $this->session->set_flashdata('insert_success', 'Archivo Generado Exitosamente');;
       $success      = true;
       $responseType = 'function';
       $function     = 'appendExportSuccess';
       $extraUrl     = set_url(array('a'=>'listado', 'f'=>$file_name));
       $data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function, 'extraUrl'=>$extraUrl);
       return $data;
    }
    function download_file(){
       $this->load->helper('download');
       $data = file_get_contents('../uploads/data/'.$this->params['f'].'.xlsx');
       force_download($this->params['f'].'.xlsx',$data);
       return true;
    }


    public function update_order(){
			$update = [];

			foreach($this->input->post() as $row => $position){
				$id = explode("-",$row);

				$update[] = [
					'id' => end($id),
					'orden' => $position
				];

			}

			$query = $this->db->update_batch($this->table,$update,'id');
			if($query){
					$this->session->set_flashdata('insert_success', 'Orden Actualizado Exitosamente');
					$success = true;
					$responseType = 'redirect';
					$data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>base_url('module/load/m/'.$this->module.'/a/listado'));
			}

			return $data;
		}
}
