$(document).ready(function(){
       init();
});

$(window).bind("resize", widthFunctions);

$(window).resize(function() {
    setHeight();
});


function widthFunctions(c) {
    var b = $(window).height();
    var a = $(window).width();
    if (a < 980 && a > 767) {
        if ($(".main-menu-span").hasClass("span2")) {
            $(".main-menu-span").removeClass("span2");
            $(".main-menu-span").addClass("span1")
        }
        if ($(".brand").hasClass("span2")) {
            $(".brand").removeClass("span2");
            $(".brand").addClass("span1")
        }
        if ($("#content").hasClass("span10")) {
            $("#content").removeClass("span10");
            $("#content").addClass("span11")
        }
        $("a").each(function () {
            if ($(this).hasClass("quick-button-small span1")) {
                $(this).removeClass("quick-button-small span1");
                $(this).addClass("quick-button span2 changed")
            }
        });
        $(".circleStatsItem, .circleStatsItemBox").each(function () {
            var d = $(this).parent().attr("onTablet");
            var e = $(this).parent().attr("onDesktop");
            if (d) {
                $(this).parent().removeClass(e);
                $(this).parent().addClass(d)
            }
        });
        $(".tempStatBox").each(function () {
            var d = $(this).attr("onTablet");
            var e = $(this).attr("onDesktop");
            if (d) {
                $(this).removeClass(e);
                $(this).addClass(d)
            }
        });
        $("div").each(function () {
            var d = $(this).attr("onTablet");
            var e = $(this).attr("onDesktop");
            if (d) {
                $(this).removeClass(e);
                $(this).addClass(d)
            }
        })
    } else {
        if ($(".main-menu-span").hasClass("span1")) {
            $(".main-menu-span").removeClass("span1");
            $(".main-menu-span").addClass("span2")
        }
        if ($(".brand").hasClass("span1")) {
            $(".brand").removeClass("span1");
            $(".brand").addClass("span2")
        }
        if ($("#content").hasClass("span11")) {
            $("#content").removeClass("span11");
            $("#content").addClass("span10")
        }
        $("a").each(function () {
            if ($(this).hasClass("quick-button span2 changed")) {
                $(this).removeClass("quick-button span2 changed");
                $(this).addClass("quick-button-small span1")
            }
        });
        $(".circleStatsItem, .circleStatsItemBox").each(function () {
            var d = $(this).parent().attr("onTablet");
            var e = $(this).parent().attr("onDesktop");
            if (d) {
                $(this).parent().removeClass(d);
                $(this).parent().addClass(e)
            }
        });
        $(".tempStatBox").each(function () {
            var d = $(this).attr("onTablet");
            var e = $(this).attr("onDesktop");
            if (d) {
                $(this).removeClass(d);
                $(this).addClass(e)
            }
        });
        $("div").each(function () {
            var d = $(this).attr("onTablet");
            var e = $(this).attr("onDesktop");
            if (d) {
                $(this).removeClass(d);
                $(this).addClass(e)
            }
        });
        $(".widget").each(function () {
            var d = $(this).attr("onTablet");
            var e = $(this).attr("onDesktop");
            if (d) {
                $(this).removeClass(d);
                $(this).addClass(e)
            }
        })
    } if ($(".timeline")) {
        $(".timeslot").each(function () {
            var d = $(this).find(".task").outerHeight();
            $(this).css("height", d)
        })
    }
};
function exists(el) {
    return ($(el).length > 0) ? true : false;
}
function init(){
    init_tooltips();
    setHeight();
    /*
    initMenu();    
    $("a.ax-modal" ).live('click',function(event) {
        event.preventDefault();
        var url = $(this).attr('href');        
        frm_send('none',url,'abc');
        });
    */
}

function setHeight(){    
    var minusH = $('#footer').height()+$('#footer-site').height()+$('#controls-wrapper').height()+$('.navbar').height();    
    var newH  = Math.ceil($(window).height()-(minusH)); 
    
    $('#listados').css('min-height',newH)
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
