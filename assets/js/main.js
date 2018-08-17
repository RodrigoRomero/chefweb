$(document).ready(function() {

if(config.page_handle == 'cart/thanks'){
	countdown(5)
}

$('.tleft.past-enabled').datepicker({
	autoclose: true,

 	format: 'dd-mm-yyyy'
});

if(config.page_handle != 'ingresar' && config.page_handle != 'crear-cuenta'){
	RR.keeper.save('comesfrom', config.page_handle);
}

console.log(RR.keeper.get('comesfrom'));


});

function validateCupon(){
	if(jQuery('input[name=cupon]').length>0){
        val = jQuery('input[name=cupon]').val();
        if(val.length>0){
            ajaxUrl = _base_url+'cupons/validate_cupon/'+val;
            frm_send('none', ajaxUrl,'xxx')
        }
    }
}

function enableInvite(data){
	$('td#tir-'+data.extras.row+' a').attr('data-acreditacion',data.extras.data).removeClass('hide');
}

function sendInvite(e){
	$id = e.data('acreditacion');
	ajaxUrl = config.shop_url+'/account/invite/'+$id
 	frm_send('none', ajaxUrl,'xxx')
}

function countdown(secs){
    var int = setInterval(function(){
      secs--;

      if(secs>0){
      //  $('#countdown').html(secs);
      }
      else {
        clearInterval(int);
         window.location.href = "/";
      }
    },5000);
}

function paymentLink(datos){

console.log(datos);

    $MPC.openCheckout ({
                url: datos.messages,
                mode: "modal",
                onreturn: checkoutReturn
    });
}

function checkoutReturn (data) {
	console.log(data);
   ajaxUrl = config.shop_url+'checkout/close/id/'+data.external_reference+'/collection_id/'+data.collection_id+'/collection_status/'+data.collection_status+'/payment_type/'+data.payment_type+'/preference_id/'+data.preference_id;
   frm_send('none', ajaxUrl,'checkout')


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
		errorClass: "text-danger",
		errorElement: "span",
		onblur: false,
		onkeyup: false,
		onsubmit: true,
		ignore: "",
		rules: {
			password: {
				required: true,
				minlength: 7
			},

			plan: {
				required: true,
			},

			valid_password:{
				required: true,
				equalTo: "#password",
				minlength: 7
			},
		},

		 messages: {
			plan : "Debes seleccionar un bono contribución"
		},

		highlight:function(element, errorClass, validClass) {
			$(element).parents('.fieldItemV').addClass('error');
		},

		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.fieldItemV').removeClass('error');
			$(element).parents('.fieldItemV').addClass('success');

		},
		invalidHandler: function(form, validator) {

		if (!validator.numberOfInvalids())
			return;
		$('html, body').animate({
			scrollTop: $(validator.errorList[0].element).offset().top-window.navHeight

		},  1000);
	}
	});

}


function clear_form_elements() {
	grecaptcha.reset();
	alert(grecaptcha);
    $(window).find(':input').each(function() {

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

var _frm_progress = false;

function frm_send(form, ajaxUrl, ajaxId, extraData) {

	if(form=="none"){
		if(ajaxUrl==undefined || ajaxId==undefined)  { console.log(102, "frm_send"); return false;}
		var form = $("<form/>", {"id" : "frm"+ajaxId, "action":ajaxUrl});
	}

	if(extraData==undefined)
		extraData = new Array();

	if (!exists(form) && form != "none") {
		console.log(102, "frm_send");
		return false;
	}

	if (_frm_progress) {
		console.log(105, "frm_send");
		return false;
	}

	if (extraData.length > 0)

		extraData = "&" + extraData.join("&")

	_frm_progress = true

	if(_frm_progress){
		page_block(true);
	}

	$.ajax({
		type : 'POST',
		url  : form.attr('action'),
		data : form.serialize() + extraData,
		success : function(data) {
			_frm_progress = false;
			page_block(false);
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
					console.log(103, form.attr("id"));
					return false;
				break;
			}

			switch(data.responseType) {
				case "function":
					if (data.value == "") {
						console.log(106, form.attr("id"));
					}
					var fn = data.value
					if (window[fn] != undefined) {
						eval(fn)(data)
					} else {
						console.log(108, fn);
					}
				break;

				case "redirect":
					if (data.value == "") {
						console.log(106, form.attr("id"));
					}

					if(data.value == 'comesfrom') {
						from = RR.keeper.get('comesfrom')
						window.location.href = config.shop_url+from
					} else {
						window.location.href = data.value
					}
				break;

				default:
					console.log(104, form.attr("id"));
				break;
			}
		},
		error : function(data) {
			_frm_progress = false;
			console.log(101, form.attr("id"));
		}
	})
}


function page_block(a, el) {
	var b = $("<div/>", {
		id: "j-pg_block",
		style: "width:100%; height:100%; background:rgba(0,0,0,0.6); position:fixed; z-index:500; top:0px;"
	});

	var c = $("<div/>", {
		id: "",
		class: "progress progress-striped active",
		style: "height: 30px;  margin-top: -15px; position: absolute; top: 50%; width: 90%; margin-left:5%"
	});

	var d = $("<div/>", {
		id: "",
		class: "progress-bar",
		style: "width: 100%;  color: #FFFFFF; font-family: 'Asap',sans-serif; font-size: 15px; font-weight: bold; line-height: 30px; text-transform: uppercase;",
		text: 'Procesando Información'
	});

	if (a) {
		if (!exists($("#j-pg_block"))) {
			d.appendTo(c)
			c.appendTo(b)
			b.appendTo("body")
		}
	} else {
		if (exists($("#j-pg_block"))) {
			$("#j-pg_block").remove()
		}
	}
}

function frm_jsonDecode(data) {
	try {
		data = jQuery.parseJSON(data);
	} catch(err) {
		console.log(107, err);
		data = '{"success":"error"}';
		data = jQuery.parseJSON(data);
	}
	return data
}

function exists(el) {
	return ($(el).length > 0) ? true : false;
}


$.fn.reset = function () {
  $(this).each (function() { this.reset(); });
}


function showNotify(data){

	if( typeof toastr === 'undefined' ) {
				console.log('notifications: Toastr not Defined.');
				return true;
			}

			toastr.remove();
			notifyPosition = data.response.position,
			notifyType = data.response.type,
			notifyMsg = data.response.message,
			notifyTimeout = data.response.time,
			notifyCloseButton = data.response.close;

			if( !notifyPosition ) { notifyPosition = 'toast-top-right'; } else { notifyPosition = 'toast-' + notifyPosition; }
			if( !notifyMsg ) { notifyMsg = 'Please set a message!'; }
			if( !notifyTimeout ) { notifyTimeout = 5000; }
			if( notifyCloseButton == 'true' ) { notifyCloseButton = true; } else { notifyCloseButton = false; }

			toastr.options.positionClass = notifyPosition;
			toastr.options.timeOut = Number( notifyTimeout );
			toastr.options.closeButton = notifyCloseButton;
			toastr.options.closeHtml = '<button><i class="icon-remove"></i></button>';

			if( notifyType == 'warning' ) {
				toastr.warning(notifyMsg);
			} else if( notifyType == 'error' ) {
				toastr.error(notifyMsg);
			} else if( notifyType == 'success' ) {
				toastr.success(notifyMsg);
			} else {
				toastr.info(notifyMsg);
			}

			return false;

}

function appendFormMessagesModal(data){
    console.log(data);
    if(data.success==true){
        clear_form_elements();
    }

    if(exists('.g-recaptcha')){
    	grecaptcha.reset();
    }

   /* if(data.items){
    	updateNumberItemsInCart(data.items);
    }*/
    open_modal(data);
}


/*function updateNumberItemsInCart(items){

	$('#top-cart span').html(items)
}*/

function open_modal(data){
    var dialog = $("#modal");
    if(!exists(('#modal'))) {
        dialog = $('<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal"></div>').appendTo('body');
    }

    dialog.html(data.html).modal();

    if(data.modal_redirect &&  ( (RR.keeper.get('comesfrom') == 'carrito/detalle') || (RR.keeper.get('comesfrom') == 'recordar-password') ||  (RR.keeper.get('comesfrom') == 'recuperar-password/'+data.extra) ) ){

        $('#modal').on('hide.bs.modal', function () {
            window.location.href = data.modal_redirect
        })

    }

}


function removeFromCart(e){
	ajaxUrl = _base_url+'cart/remove/'+e;
	frm_send('none', ajaxUrl,'xxx')
}


function reloadCart(data){
    $(".jFullCart").empty().html(data.html.fullcart);
    $(".jResumeCart").empty().html(data.html.resume);
    $(".jResumePayments").empty().html(data.html.payments);
}
