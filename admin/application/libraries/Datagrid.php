<?php


if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Datagrid{


    var $CI;





    public function __construct(){


        $this->CI =& get_instance();


    }





    function make($args){


        $data        = $args["datagrid"];


        $filter      = $args['filters'];


        $paging      = (!empty($args["paging"])) ? $args["paging"] : "";





        $header      = (!empty($data)) ? $this->_get_header($data["columns"]) : "";


        $rows        = (!empty($data)) ? $this->_get_rows($data["rows"], $data["columns"]) : "";


        $grid_title  = (!empty($args['grid_title'])) ? $args['grid_title'] : "";


        $grid_type   = (!empty($args['grid_type'])) ? $args['grid_type'] : "jData-table";


        $grid_lnk    = (!empty($args['grid_lnk'])) ? $args['grid_lnk'] : "";





        //ep($data);


        $data = array('header'      => $header,


                      'rows'        => $rows,


                      'filter'      => $filter,


                      'fichaMedica' => $fichaMedica,


                      'grid_title'  => $grid_title,


                      'grid_type'   => $grid_type,


                      'paging'       => $paging,


                      'grid_lnk'    => $grid_lnk,


                     );


        $html =  $this->CI->view("layout/tables/datagrid", $data, true);


        return $html;


    }





   public function query_to_rows($result, $col, $extra=array(), $order_tree="", $order_tree_pos=1){


    //ep($col);


        $col[]      = array("field"=>"id");


        $order_tree = (empty($order_tree)) ? "" : $col[] = array("field"=>$order_tree);


        $data       = array();


        foreach($result as $cont=>$row){


            foreach($col as $value){


                if($value['field']=='json' || $value['field']=='valor'){


                    $json        = json_decode($row->$value["field"]);


                    $json_fields = explode("->", $value["json"]);


                    $field       = $json;





                    foreach($json_fields as $jrow){


					   $field   = $field->$jrow;


					}





                    $data[$cont][] = (!isset($field)) ? '' :$field;





                } else {


                    $field = !empty($value["field"]) ? $value['field'] : '';











                    $data[$cont][] = (!isset($row->$field)) ? '-' : $row->$field;


                }


            }


        }





        if(count($extra)>0){





	        foreach($result as $cont=>$row){


	            foreach($extra as $value){

	            	//ep($value);
                	preg_match_all("/({%)(.*?)(%})/", $value["html"], $matches, PREG_SET_ORDER);



	                if(!empty($matches) ){

		                foreach ($matches as $k=>$val) {

		                    $val1 = $val[0];
		                    $val2 = $val[2];
		                    $value_html = ($k==0) ? $value["html"] : $data[$cont][$value["pos"]];
		                    $data[$cont][$value["pos"]] = str_replace($val1, $row->$val2, $value_html);

		                }
	                } else {

						$data[$cont][$value["pos"]] = $value["html"];


	                }


	            }


	        }


		}



        if(!empty($order_tree)){


            $tmpArr    = array();


            $tmpArr[0] = "";


            array_splice($data, 0, 0, "");








            foreach($data as $key=>$row){


                if($row!=""){


                    $padre_id = array_pop($row);


                    $id       = array_pop($row);


                }


                $tmpArr[$id] = $key;


                $data[$key]["@parent"] =  ($padre_id>=1) ?  $tmpArr[$padre_id] : 0;


            }


            $data = $this->array_stack($data);


            array_shift($data['tree']);


            $this->array_elements = array();


            $this->get_array_elems($data['tree'], $order_tree_pos);


            $data = $this->array_elements;


        }





        return $data;


    }





    private function _get_header($data){


        $html = "";


        foreach($data as $k=>$row){


            $width = (isset($row["width"]) && !empty($row["width"])) ? "width='".$row["width"]."'" : '';

            $class = (isset($row["class"]) && !empty($row["class"])) ? "class='".$row["class"]."'" : '';

            $vars = array("title" => $row["title"], "width"=>$width, 'sort'=>$row["sort"], 'position'=>$k, "class"=>$class);


            $html .=  $this->CI->view("layout/tables/datagrid-row-header", $vars, true);


        }


        return $html;


    }





    private function _get_rows($data, $columns){


        $html = "";


        $c    = 0;








        foreach($data as $row){


        //    ep($row);


         //   ep($columns);








            $class = ($c%2) ? 'dg-tr-c' : '';


            $id  = array_pop($row);


            $html .= "<tr id='dg-tr-".$id."' class='".$class."'>\n";


            $column = 0;


            foreach($row as $col){


                $class = "";


                for($i=0;$i<count($columns);$i++){


                    if(in_array("setDefaultClass",$columns[$i])){


                        $class = $columns[$i]["class"]."-".convert_accented_characters(strtolower($row[$i]));


                    }


                }





                if(empty($class)) {


                    if(isset($columns[$column]["value"]) && isset($columns[$column]["class"])){


                       $class = $columns[$column]["value"].' '.$columns[$column]["class"]."-".strtolower($col);


                    }else if( !isset($columns[$column]["value"]) && isset($columns[$column]["class"])){


                        $class = $columns[$column]["class"];


                    } else if (isset($columns[$column]["value"])){


                        $class = $columns[$column]["class"]."-".strtolower($col);


                        $col   = "";


                    }


                }





                switch($columns[$column]["format"]){


                    case "datetime":


                        $col = date( 'd/m/Y  H:i', strtotime($col) );


                        break;


                    case "date":


                        $col = date( 'd/m/Y', strtotime($col) );


                        break;


                    case "time":


                        $col = date( 'H:i', strtotime($col) );


                        break;





                    case "image":


                        $col = "<img src='".$this->CI->config->item("base_url")."/".$col."' alt='' width='50' />";


                        break;





                    case "icon-activo":


                        if($col==1){


                            $col =  '<span class="icon-ok"></span>';


                        } else {


                            $col =  '<span class="icon-remove"></span>';


                        }


                        break;


                    case "icon-level":


                        if($col==1){


                            $col =  '<span class="icon-star"></span>';


                        } else {


                            $col =  '<span class="icon-star-empty"></span>';


                        }


                        break;
                    case 'money':
                        $col = '$ '.round($col, 2);
                        break;

                    case "important":


                        if(!empty($col))


                        $col = '<span class="badge badge-important">'.$col.'</span>';


                        break;


                }


                if(isset($columns[$column]["html"])){


                    $col .= $columns[$column]["html"];


                }





                $vars = array("title" => $col, "class" => $class);


                $html .= $this->CI->view("layout/tables/datagrid-row-body", $vars, true);


                $column++;


            }


            $html .= "</tr>\n";


            $c++;


        }


        return $html;


    }





    function array_stack (&$a, $p = '@parent', $c = '@children'){


      $l = $t = array();


      foreach ($a AS $key => $val):


        if (!$val[$p]) $t[$key] =& $l[$key];


        else $l[$val[$p]][$c][$key] =& $l[$key];


        $l[$key] = (array)$l[$key] + $val;


      endforeach;


      return $a = array('tree' => $t, 'leaf' => $l);


    }














    function get_array_elems($arrResult, $pos=1){


    	$fist_key   = key($arrResult);


		$parent_key = $arrResult[$fist_key]["@parent"];


        foreach($arrResult as $key=>$row){


            unset($row["@parent"]);


            $children = $row["@children"];


            unset($row["@children"]);


            array_pop($row);


			$this->parent_childs[$key] = $this->parent_childs[$parent_key]."&nbsp;&nbsp;&nbsp;";


			$nbsp                   = $this->parent_childs[$fist_key];


            $row[$pos]                 = ($parent_key==0) ? $row[$pos] : $nbsp." ∟ ".$row[$pos];


			//echo $key." - ".$row[1]." - ".$fist_key."<br/>";


            $this->array_elements[] = $row;


            if (is_array($children)){


                $this->get_array_elems($children, $pos);


            }


        }


    }


}
