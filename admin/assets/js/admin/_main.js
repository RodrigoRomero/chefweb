var _obj             = new Object();
    _obj.actual_page = 1
    _obj.actual_filt = ""

$(document).ready(function(){    
    initTables();    
    init();
    $("#myTab a:first").tab("show");
    $("#myTab a").click(function (b) {
        b.preventDefault();
        $(this).tab("show")
    });
    $(".btn-close").click(function (b) {
        b.preventDefault();
        $(this).parent().parent().parent().fadeOut()
    });
    
});

function initMinimize(){
    $(".btn-minimize").click(function (c) {
        c.preventDefault();
        var b = $(this).parent().parent().next(".box-content");
        if (b.is(":visible")) {
            $("i", $(this)).removeClass("icon-chevron-up").addClass("icon-chevron-down")
        } else {
            $("i", $(this)).removeClass("icon-chevron-down").addClass("icon-chevron-up")
        }
        b.slideToggle()
    });
}


function appendExportSuccess(data){ 
    if(exists(('#jMessages'))) {
        $("#jMessages").html(data.messages);
        if(typeof data.extraUrl != 'undefined'){
            window.location.href = data.extraUrl
        }
    } else {
        console.log('TODO - SI EL ELEMENTO NO EXISTE');
        console.log(data)    
    }
}

$(window).bind("resize", widthFunctions);

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

jQuery(document).ready(function (a) {
    a("ul.main-menu li a").each(function () {
        if (a(a(this))[0].href == String(window.location)) {
            a(this).parent().addClass("active")
        }
    });
    a("ul.main-menu li ul li a").each(function () {
        if (a(a(this))[0].href == String(window.location)) {
            a(this).parent().addClass("active");
            a(this).parent().parent().show()
        }
    });    
    a(".dropmenu").click(function (b) {
        b.preventDefault();
        a(this).parent().find("ul").slideToggle()
    })
});

jQuery(document).ready(function (b) {
    var a = true;
    b("#main-menu-toggle").click(function () {
        if (b(this).hasClass("open")) {
            b(this).removeClass("open").addClass("close");
            var f = b("#content").attr("class");
            var e = parseInt(f.replace(/^\D+/g, ""));
            var c = e + 2;
            var d = "span" + c;
            b("#content").addClass("full");
            b(".brand").addClass("noBg");
            b("#sidebar-left").hide()
        } else {
            b(this).removeClass("close").addClass("open");
            var f = b("#content").attr("class");
            var e = parseInt(f.replace(/^\D+/g, ""));
            var c = e - 2;
            var d = "span" + c;
            b("#content").removeClass("full");
            b(".brand").removeClass("noBg");
            b("#sidebar-left").show()
        }
    })
});


function init(){
    if(typeof Shadowbox != 'undefined'){
        Shadowbox.init({players:  ['img', 'html', 'iframe', 'qt', 'wmp', 'swf', 'flv']});
    }
    init_tabs();
    
    if(exists(('.datepicker'))) {
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            language: 'es'
            });
    }
    if(exists(('.timepicker'))){
        $('.timepicker').timepicker({
            minuteStep: 5,
            showMeridian: false,
            showSeconds: true,        
            });
    }
    $("a.ax-modal" ).live('click',function(event) {
        event.preventDefault();
        var url = $(this).attr('href');        
        frm_send('none',url,'abc');
        });
    if(exists(('#fullcalendar'))) {
        fullCalendar();
    }
    init_tooltips();
    init_upload_manager();
    /*
    $('.j-enter').each(function(index) {
		$(this).keypress(function(event) {
			if (event.which == 13) {
				var onEnter = $(this).attr("data-onenter")
				$("#" + onEnter).click();
			}
		});
	});
    */
}
function shadowbox_open(file, ext){
    var options = {continuous: true, counterType: "skip"};
    switch(ext){
        case "jpg":
        case "gif":
        case "png":
            player = "img"
            break;
        case "flv":
            player = "flv"
            break;
        case "doc":
        case "docx":
        case "xls":
        case "txt":
            window.open(file)
            break;
        default:
            player = "iframe"
        break;
    }
    var img1 = {
        player:     player,
        content:    file,
        options:    options
    };
    Shadowbox.open([img1]);
}
function init_tabs(){   
    
    $("#jLangs a").each(function(index){
        var dataLang = $(this).attr('data-lang');
        if(dataLang ==_base_lang){
            $(this).removeClass('btn-inverse').addClass('active btn-primary');
        } else if(dataLang != _base_lang){           
            $("[name*=_"+dataLang+"]").each(function(){
                $(this).css('display','none');
            })
        }
    });
    init_tabs_panel();
}
function init_tabs_panel(){
    $("#jLangs a").live('click',function(){
       var setLang = $(this).attr('data-lang');      
        $("#jLangs a").each(function(index){
            var dataLang = $(this).attr('data-lang');
            if(dataLang != setLang){                
                $(this).removeClass('active btn-primary').addClass('btn-inverse');
                $("[name*=_"+dataLang+"]").each(function(){
                    $(this).css('display','none');
                })
            } 
            if(dataLang == setLang){               
                $(this).removeClass('btn-inverse').addClass('active btn-primary');
                $("[name*=_"+setLang+"]").each(function(){                    
                    $(this).css('display','block');
                })
            }
        }) 
    });
}


function initTables(){
   
    $("a.j-paging-page" ).live('click',function(event) {
        event.preventDefault();
        $('a.j-paging-page').each(function(){
            $(this).removeClass('btn-inverse')    
        })
        
        $(this).addClass('btn-inverse')
        var url = $(this).attr('href');        
         paging(url)
    });
        
    /*
    if(exists(('.jData-table'))){
       listTables = $('.jData-table').dataTable({    		
            "oLanguage": {
    			"sUrl": _base_url+"assets/widgets/tables/language/sp_ES.txt"
    		},
            "bSort" : false,
    		"sPaginationType": "bootstrap",
            "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
                		
            "fnInitComplete": function (){     
                $(listTables.fnGetNodes()).mouseover(function(){
                    id = $(this).attr('id');
                    _id = $(this).attr('id').split("-").pop();
                })
            }
    	});
    }
    
    if(exists(('.jData-table-dashboard'))){
        $('.jData-table-dashboard').dataTable({
    		"bJQueryUI": true,
            "oLanguage": {
    			"sUrl": _base_url+"assets/widgets/tables/language/sp_ES.txt"
    		},
    		"sDom": 't',
    	});
    }
    */
    
}

//****** PAGING ******//
function paging(url){
    url  = url.toString()
    var page = url.split("/")
        page = page.pop()        
        $.ajax({
        type : 'POST',
        url  : url,
        data : '',
        success : function(data) {           
            data = frm_jsonDecode(data)
            console.log(data);
            $('.j-a').empty().html(data)         
            _obj.actual_page = page  
            initMinimize() 
        },
        error : function(data) {alert('error paginado')}
    })
}




/* FORM FUNCTIONS */
function validateLoginForm(form) {
    
    if(typeof form == "string") e = $('#'+form);
    var validate = e.validate({       
        debug: true,
        submitHandler: function () {
            frm_send($('#' + form));
        },
        errorPlacement: function(error, element) {
            error.prependTo('#jAppendFormErrors');
        },
        errorLabelContainer: $("#jAppendFormErrors ul"),
        onblur: false,
        onkeyup: false,
        onsubmit: true,
        wrapper: "li",
        showErrors: function() {
            this.defaultShowErrors();
        },
        rules: {
            user:{            
                required: true,
                email: true
            },
        },
        messages: {
            user: {
                required: "Ingrese su usuario"
            },
            password: {
                required: "Ingrese su password"
            }
        }
    });
    $("#jAppendFormErrors ul").addClass('alert alert-error')
}
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
    $()
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


$.fn.reset = function () {
  $(this).each (function() { this.reset(); });
}

function getOpcionesMedicasExtras(val){
        var id  = $('input[name=caballo_id]').val();        
        var url = _base_url+'fichas/setOpcionesMedicas/op/'+val+'/id/'+id
        frm_send('none',url,'fichaMedica');
}
function appendAccionesMedicasExtras(data){
    if(exists(('.jAccionesMedicasExtras'))) {
        $('.jAccionesMedicasExtras').remove();
    }
    $('#jAccionesMedicas').after(data.html);
}
function enableExtraFecha(val){
    if(val=='+n'){
        $('.setFechaMedica').removeAttr('disabled');
    } else {
        $('.setFechaMedica').val('').attr('disabled','disabled');
    };
}
function open_modal(data){    
    var dialog = $("#modal");
    if(!exists(('#modal'))) {    
        dialog = $('<div id="modal" class="modal fade" style="display:hidden"></div>').appendTo('body');
    } 
    dialog.html(data.html).modal();
}
function setActiveMenu(){
}
function setLocalStorage(key,val){
    localStorage.setItem(key,val);
}
function removeLocalStorage(key){
    localStorage.removeItem(key);
}
function change_select_multi_transfer(left,right){
    $("#"+left+" option:selected").remove().appendTo('#'+right);
}
function init_upload_manager(){
    $("[id^='upload_manager']").each(function(n,el){        
        var id   = $(el).attr('id')        
        var json = $(el).html()
        var flashvars = frm_jsonDecode(json);
        var params = {
        		menu: "false",
        		scale: "noScale",
        		allowFullscreen: "true",
        		allowScriptAccess: "always",
        		bgcolor: "#F9F9F9"
        	};
         var attributes = {
        		id:"uploadManager"
        	};
         swfobject.embedSWF(_base_url+"/assets/widgets/uploadManager/uploadManager.swf", id, "400", "25", "9.0.0", "expressInstall.swf", flashvars, params, attributes);
        })
}
function resize_images(id){
    console.log(id)
    var ajax = new Request({
         method: 'post',
		 url:    _base_url+"/assets/widgets/uploadManager/UploadManager.php?a=resize&id="+id,
		 onRequest: function(){},
         onSuccess: function(data){},
         onFailure: function(){alert('Conection error (error: axri-101).');} 
      }).send();
}

function cloneUpload(folder,env, pie){
    var pos = $('#uploadGroup #uploadManager').length
    var pie = (pie=='pie') ? 1 : 0;
    var url = _base_url+'institucional/getUploads/folder/'+folder+'/pos/'+pos+'/env/'+env+'/pie/'+pie
    frm_send('none',url,'cloneUpload');
}

function appendUploadElement(data){
    $('#uploadGroup .controls').append(data.html);
    var active_lang = $("#jLangs a.active").attr('data-lang');
    
   $("#jLangs a").each(function(index){
            var dataLang = $(this).attr('data-lang');
            if(dataLang != active_lang){
                $("[name*=_"+dataLang+"]").each(function(){
                    $(this).css('display','none');
                })
            } 
            if(dataLang == active_lang){               
                
                $("[name*=_"+active_lang+"]").each(function(){                    
                    $(this).css('display','block');
                })
            }
        })
    
    
    init_upload_manager();
}
function fullCalendar(){
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    $('#fullcalendar').fullCalendar({
        monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        monthNamesShort:['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
        dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
        dayNamesShort: ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'],
        header: {
            left: 'prev,next',
            center: 'title',
            right: ''
        },
        editable: false,
        droppable: false, // this allows things to be dropped onto the calendar !!!
        eventSources: [{
            url: _base_url+'dashboard/getCalendar',
            type: 'POST',
            error: function() {
                alert('there was an error while fetching events!');
            },                        
            textColor: 'withe' // a non-ajax option
            }],            
    });
}

function init_tooltips(){
    $('.tip').tooltip();	
	$('.tip-left').tooltip({ placement: 'left' });	
	$('.tip-right').tooltip({ placement: 'right' });	
	$('.tip-top').tooltip({ placement: 'top' });	
	$('.tip-bottom').tooltip({ placement: 'bottom' });
}