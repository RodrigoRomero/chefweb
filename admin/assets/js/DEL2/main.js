$(document).ready(function(){
    init();    
    
});

function exists(el) {
    return ($(el).length > 0) ? true : false;
}
function init(){
    alert('1')
    init_tooltips()
    /*
    initMenu();
    
    $("a.ax-modal" ).live('click',function(event) {
        event.preventDefault();
        var url = $(this).attr('href');        
        frm_send('none',url,'abc');
        });
    */
        

}


/* FORM FUNCTIONS */

function validateForm(form) {
    if(typeof form == "string") e = $('#'+form);
    
    if($("select[id*=right]")){
        $("select[id*=right]").each(function(n,el){
            var id = $(el).attr('id');
            $('#'+id+' option').each(function(n,ele){
              $(ele).attr('selected','selected');  
            })
        })
    }

    var validate = e.validate({       
        debug: true,
        submitHandler: function () {
            frm_send($('#' + form));
        },
        errorClass: "help-inline",
		errorElement: "span",
        onblur: false,
        onkeyup: false,
        onsubmit: true,  
        rules: {
            password: {
                required: true,
                minlength: 7
            },
            valid_password:{            
                required: true,
                equalTo: "#password",
                minlength: 7
            },
        },
        
        highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}

    });
}

function clear_form_elements() {
    $(window).find(':input').each(function() {
        alert('this');
        switch(this.type) {
            case 'password':
            case 'select-multiple':
            case 'select-one':
            case 'text':
            case 'textarea':
                $(this).val('');
                break;
            case 'checkbox':
            case 'radio':
                this.checked = false;
        }
    });
}

/*
var _frm_progress = false;
function frm_send(form, ajaxUrl, ajaxId, extraData) {
    if(form=="none"){
        if(ajaxUrl==undefined || ajaxId==undefined)  { _exception.show(102, "frm_send"); return false;}
        var form = $("<form/>", {"id" : "frm"+ajaxId, "action":ajaxUrl});
    }
    
    if(extraData==undefined)
        extraData = new Array();
        
    if (!exists(form) && form != "none") {
        _exception.show(102, "frm_send");
        return false;
    }
    
    if (_frm_progress) {
        _exception.show(105, "frm_send");
        return false;
    }
    
    if (extraData.length > 0)
        extraData = "&" + extraData.join("&")
    
    _frm_progress = true
    $.ajax({
        type : 'POST',
        url  : form.attr('action'),
        data : form.serialize() + extraData,
        success : function(data) {
            _frm_progress = false;
            data = frm_jsonDecode(data)
            switch(data.success) {
                case "true":
                case true:
                case 1:
                case "1":
                    $('#'+form.attr('id')).reset();
                break;
                
                case "false":
                case false:
                case 0:
                break;
                
                case "error":
                case "-1":                    
                break;
                
                default:
                    _exception.show(103, form.attr("id"));
                    return false;
                break;
            }
            
            switch(data.responseType) {
                case "function":
                    if (data.value == "") {
                        _exception.show(106, form.attr("id"));
                    }
                    var fn = data.value
                    if (window[fn] != undefined) {
                        eval(fn)(data)
                    } else {
                        _exception.show(108, fn);
                    }
                break;
                case "redirect":
                    if (data.value == "") {
                        _exception.show(106, form.attr("id"));
                    }
                        window.location.href = data.value
                break;
   
                default:
                    _exception.show(104, form.attr("id"));
                break;
            }
        },
        
        error : function(data) {
            _frm_progress = false;
            _exception.show(101, form.attr("id"));
        }
    })
}

function frm_jsonDecode(data) {
	try {
		data = jQuery.parseJSON(data);
	} catch(err) {
		_exception.show(107, err);
		data = '{"success":"error"}';
		data = jQuery.parseJSON(data);
	}
	return data
}
$.fn.reset = function () {
  $(this).each (function() { this.reset(); });
}


function appendFormMessages(data){
    if(exists(('#jAppendFormErrors'))) {  
        $("#jAppendFormErrors").css('display','block');
        $("#jAppendFormErrors ul").css('display','block').html(data.messages);
    } else {
        console.log('TODO - SI EL ELEMENTO NO EXISTE');
        console.log(data)    
    }
}

function appendFormMessagesModal(data){
    if(data.success==true){
        clear_form_elements();
    }    
    open_modal(data);
}
function open_modal(data){
    var dialog = $("#modal");
    if(!exists(('#modal'))) {    
        dialog = $('<div id="modal" class="modal fade" style="display:hidden"></div>').appendTo('body');
    } 
    dialog.html(data.html).modal();  
}
*/


function init_tooltips(){
    $('.tip').tooltip();	
	$('.tip-left').tooltip({ placement: 'left' });	
	$('.tip-right').tooltip({ placement: 'right' });	
	$('.tip-top').tooltip({ placement: 'top' });	
	$('.tip-bottom').tooltip({ placement: 'bottom' });
} 
