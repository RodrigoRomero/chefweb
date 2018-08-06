<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Breadcrumb{
    var $bread = '';
    var $crumbs = array();
    var $href_param;
    var $seperator;
    var $home_text;
    var $home_link;
    
    function Breadcrumb($seperator="", $href_param=NULL, $home_link='/', $home_text = "Inicio"){
        
        $this->href_param = $href_param;
        $this->seperator = $seperator;    
        $this->home_text = $home_text;
        $this->home_link = lang_url();
        $this->crumbs[] = array('crumb'=>$this->home_text, 'link'=>$this->home_link);
    }
    
    function addCrumb($this_crumb, $this_link = NULL, $this_class = NULL){
        $in_crumbs = false;
        // first check that we haven't already got this link in the breadcrumb list.
        foreach($this->crumbs as $crumb){
            if($crumb['crumb'] == $this_crumb ){
                $in_crumbs = true;
            }
            if($crumb['link'] == $this_link &&  $this_link != ''){
                $in_crumbs = true;
            }
        }
        if($in_crumbs == false){
            $this->crumbs[] = array('crumb'=>$this_crumb,'link'=>$this_link, 'class'=>$this_class);
        }
    }
    
    // call this to return your breadcrumb html
    function makeBread(){
        $sandwich = $this->crumbs;
        $slices = array();
        foreach($sandwich as $slice){           
            if (isset($slice['link']) && $slice['link'] != '') {
                if($slice['crumb']=='Inicio') {
                    $slices[] = '<a href="' . $slice['link'] . '" '.$this->href_param.'><i class="icon-home"></i>' . $slice['crumb'] . '</a>';
                } else {
                    $slices[] = '<a href="' . $slice['link'] . '" '.$this->href_param.' class="'.$slice['class'].'">' . $slice['crumb'] . '</a>';
                }
            } else {
                $slices[] = '<a href="javascript:void(0)" class="'.$slice['class'].'">'.$slice['crumb'].'</a>';
            }    
        }
        $this->bread = join($this->seperator, $slices);
        return $this->bread;
    }
}