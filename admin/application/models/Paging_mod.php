<?php
/* VERSION: 1.0.0
 * 
 * 
 */
 
class Paging_mod extends RR_Model {
    
    function Paging_mod() {	  
 		parent::__construct();
  	}
    
     
    function get_paging( $total, $limit, $all=false){
         
        $page       = (isset($_POST['page'])) ? $this->input->post('page',true) : 1;
        
        
        $url        = set_url();
        
        $paging     = $this->rr_paging->paging($page,$limit,$total,5);        
        $prev       = $paging['prev'];
        $next       = $paging['next'];
        $numbs      = array();
        $first      = $paging['first'];
        $last       = $paging['last'];

        for ($i=$paging['start'];$i<=$paging['end'];$i++) { 
           $current    = ($i==($paging['page']))? true : false;
           $numbs[]    = array("page" =>$i, "selected"=>$current);
        }
        $data = array("prev"      => $prev,
                      "next"      => $next,
                      "numbs"     => $numbs,
                      "all"       => $all,
                      "first"     => $first,
                      "last"      => $last,
                      'limit'     => ($limit==$total)  ? 'all' : $limit );
                      
        $html = $this->view('layout/paging/paging', $data);              
        return $html;
    }
}
?>