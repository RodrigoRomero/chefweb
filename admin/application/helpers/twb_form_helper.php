<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function control_group($label_name = NULL, $element, $attr = NULL, $label_for = NULL)
	{
		//Declare and Initialize variables
		$cg_str='';
		
		//Basic HTML element attributes
		$attr['id']    = (isset($attr['id']))?$attr['id']:'';
		$attr['class'] = (isset($attr['class']))?$attr['class']:'';
		$attr['style'] = (isset($attr['style']))?$attr['style']:'';
        
        $attr['class_controls'] = (isset($attr['class_controls']))?$attr['class_controls']:'';
				
		//Twitter Bootstrap attributes
		$attr['validation']  = (isset($attr['validation']))?$attr['validation']:NULL;
		$attr['help-inline'] = (isset($attr['help-inline']))?$attr['help-inline']:NULL;
		$attr['help-block']  = (isset($attr['help-block']))?$attr['help-block']:NULL;
		$attr['uneditable']  = (isset($attr['uneditable']))?TRUE:FALSE;
		$attr['view']        = (isset($attr['view']))?TRUE:FALSE;
		
		//Append/Prepend Elements
		if((isset($attr['prepend']))):
			$attr['prepend'] = $attr['prepend'];
		else :
			$attr['prepend'] = NULL;
		endif;
		if((isset($attr['append']))):
			$attr['append'] = $attr['append'];
		else :
			$attr['append'] = NULL;
		endif;

		//Set the prepend/append checkbox status if it is checked by default		
		$attr['add-on-class'] = ((isset($attr['prepend']) and strpos($attr['prepend'],'checked')!==FALSE) or (isset($tb_attributes['append']) and strpos($tb_attributes['append'],'checked')!==FALSE))
									 ?'active'
									 :'';

		//Assign the label 'for' attribute to the first element's ID value for
		// label click functionality.
		if(is_array($element)):
			foreach($element as $e):
				$element_id[] = substr(substr($e,strpos($e,'id=')+4),0,strpos(substr($e,strpos($e,'id=')+4),'"'));
			endforeach;
		else :	
			$element_id[] = substr(substr($element,strpos($element,'id=')+4),0,strpos(substr($element,strpos($element,'id=')+4),'"'));
		endif;		
        
        
        if(!empty($label_for) || $label_for!=NULL){
            $label_for = 'for="'.$label_for.'"';
        }
        
		
		//Begin generating the control-group structure
		$cg_str .= '<div id="'.$attr['id'].'" class="control-group '.$attr['class'].' '.$attr['validation'].' " style="'.$attr['style'].'" >';
	    $cg_str .= '<label class="control-label" '.$label_for.'>'.$label_name.'</label>';
	    $cg_str .= '<div class="controls '.$attr['class_controls'].'">';
		    
				//Create prepend/append div
				if(isset($attr['prepend']))
					$cg_str .= '<div class="input-prepend ">';
				else if(isset($attr['append'])):
					$cg_str .= '<div class="input-append ">';
				endif;
				
					//Add prepend element
					if(isset($attr['prepend']) && !empty($attr['prepend'])):
						$cg_str .= '<span class="add-on '.$attr['add-on-class'].'">'.$attr['prepend'].'</span>';
					endif;
					
					//Add elements 
					// Check if element variable passed is an array or string
					if(is_array($element)):
						foreach($element as $e):
							$cg_str .= ($attr['uneditable'] or $attr['view']) ? '<span class="'. ($attr['view'] ? "view-input" : ($attr['uneditable'] ? "uneditable-input" : "")) .'">'.$e.'</span>' : $e;
						endforeach;
					else :
						$cg_str .= ($attr['uneditable'] or $attr['view']) ? '<span class="'. ($attr['view'] ? "view-input" : ($attr['uneditable'] ? "uneditable-input" : "")) .'">'.$element.'</span>' : $element;
					endif;

					//Add append element
					if(isset($attr['append'])):
						$cg_str .= '<span class="add-on '.$attr['add-on-class'].'">'.$attr['append'].'</span>';
					endif;

				
					//Add Help-inline text
					if(isset($attr['help-inline'])): 
						$cg_str .= '<span class="help-inline">'.$attr['help-inline'].'</span>';
					endif;
				
				//Close append/prepend div
				if(isset($attr['prepend']) or isset($attr['append'])):
					$cg_str .= '</div>';
				endif;

				//Add Help-block text
				if(isset($attr['help-block'])): 
					$cg_str .= '<p class="help-block">'.$attr['help-block'].'</p>';
				endif;
				
		  $cg_str .= '</div> <!-- END OF .controls -->';
		$cg_str .= '</div> <!-- END OF .control-group -->';
		
		return $cg_str;
	} //END OF control_group function


function form_action($button, $attr = NULL)
	{
			
		//Declare and Initialize variables
		$fa_str='';
		$array_count=0;
		
		//Basic HTML element attributes
		//$button = (isset($button)) ? $button : '';

		$attr['id'] = (isset($attr['id']))?$attr['id']:'';
		$attr['class'] = (isset($attr['class']))?$attr['class']:'';
		$attr['style'] = (isset($attr['style']))?$attr['style']:'';
			
		$fa_str = '<div id="'.$attr['id'].'" class="form-actions '.$attr['class'].' " style="'.$attr['style'].'" >';
		
			if(is_array($button)):
				foreach($button as $b):
					$fa_str .= ($array_count>0)?'&nbsp;'.$b:$b;
					$array_count++;
				endforeach;
			else :	
				$fa_str .= $button;
			endif;
		
		$fa_str .= '</div>';
		
		return $fa_str;
	} //END OF form_action function


    