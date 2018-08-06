<?php

class Module extends RR_Controller {

    function Module(){
		parent::__construct();
        $this->layout = 'base';
        $this->js_view     = array('swfobject');
        $this->widget_view = array('validate'=>array('js'=>array('jquery.validate','messages_es')),
                                   'datepicker'=>array('css'=>array('datepicker'), 'js'=>array('bootstrap-datepicker','bootstrap-datepicker.es')),
                                   'timepicker'=>array('css'=>array('bootstrap-timepicker'), 'js'=>array('bootstrap-timepicker')),
                                   'shadowbox'=>array('css'=>array('shadowbox'), 'js'=>array('shadowbox')),
                                   'input'=>array('js'=>array('masked', 'limiter', 'jquery.autosize-min')),
                                   'cleditor' => array('js'=>array('jquery.cleditor.min'), 'css'=>array('jquery.cleditor')),
                                   );
	}

	function index(){
	}

    function load(){
        $module = $this->params["m"];
        $model  = $module."_mod";
        $action = $this->params["a"];

        $this->load->model($model);
        $html =  $this->$model->$action();

        if($this->input->is_ajax_request() && !isset($this->params['f'])){
           echo json_encode($html);
        } else {
            $this->_show($html);
        }
        /*
        $args   = $this->uri->uri_to_assoc(3);


        $hash   = "";
        foreach($args as $k=>$v){
            if($k=="%7Cnewa" || !empty($hash)){
                $k = str_replace("%7C", "#", $k);
                $hash .= $k."/".$v."/";
            }
        }
        $hash = (!empty($hash)) ? substr($hash, 0, -1) :  $hash;

        $this->load->Model("sections/".$model);

        $html =  $this->$model->$action($params);


        $data = array("content" =>$html,
                      "module"  =>$module );


        if(isset($args["ax"]) && $args["ax"]==1){
            echo json_encode($data);
		}else if(isset($args["empty"])){
        }else{
            $this->show($data);
        }
        */

    }

    public function add_line(){
        $this->load->model('productos_mod');
        $rules = $this->productos_mod->getDescriptionLine();
        echo json_encode($rules);
    }

    public function order(){


    }
    private function _show($module){
        echo $this->show_main($module);
    }


}
