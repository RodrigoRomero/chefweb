$(document).ready(function () {


	google.charts.load('current', {packages: ['corechart', 'line']});

	init();

	/*
	if(exists(('#chart_lines'))) {
		google.charts.setOnLoadCallback(setBarTickets);
	}*/
	/*google.charts.setOnLoadCallback(setPiePlanes);
	google.charts.setOnLoadCallback(setPiePagos);*/
});

function addLine(){
	var pos = $('.jPos').length
	var url = _base_url+'module/add_line/pos/'+pos
	var data = frm_send('none',url,'abc');
}

function appenLines(datos){
	$(datos.html).appendTo('#jClone');
}

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

initialize_google_maps = function () {
		var t = new google.maps.places.Autocomplete(document.getElementById("lugar"));
		google.maps.event.addListener(t, "place_changed", setMap)
	}, setMap = function (t) {
		var t = t || {}, e = e || document.getElementById("map_canvas"),
			i = i || document.getElementById("lugar"),
			n = t.noAutocomplete ? null : this,
			r = t.lat,
			s = t.lng,
			o = t.noAutocomplete ? !1 : n.getPlace();
		o && (r = o.geometry.location.lat(), s = o.geometry.location.lng(), attachPlaceToForm(o, r, s));
		var a = new google.maps.LatLng(r, s),
			l = {
				zoom: 18,
				center: a,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}, h = new google.maps.Map(e, l);
		optionsMarker = {
			map: h,
			position: a
		}, marker = new google.maps.Marker(optionsMarker), $(e).show()
	}, attachPlaceToForm = function (t, e, i) {
		var t = t || !1;
		if (t) {
			for (var n, r = t.name, s = t.address_components, o = o || document.getElementById("event_address_components"), a = {
					place: r,
					lat: e,
					lng: i
				}, l = 0; n = s[l]; l++) {
				var h = defKeyName(n.types[0]);
				a[h] = n.short_name
			}
			o.value = JSON.stringify(a)
		}
	}, defKeyName = function (t) {
		switch (t) {
		case "route":
			return "street_name";
		case "administrative_area_level_1":
			return "region";
		default:
			return t
		}
	}
$(window).bind("resize", widthFunctions);
function widthFunctions(c){
	var b = $(window).height();
	var a = $(window).width();
	if (a < 980 && a > 767) {
		if ($(".brand").hasClass("span2")) {
			$(".brand").removeClass("span2");
			$(".brand").addClass("span1")
		}
		if ($("#content").hasClass("span10")) {
			$("#content").removeClass("span10");
			$("#content").addClass("span11")
		}
		$("div").each(function () {
			var d = $(this).attr("onTablet");
			var e = $(this).attr("onDesktop");
			if (d) {
				$(this).removeClass(e);
				$(this).addClass(d)
			}
		})
	} else {
		if ($(".brand").hasClass("span1")) {
			$(".brand").removeClass("span1");
			$(".brand").addClass("span2")
		}
		if ($("#content").hasClass("span11")) {
			$("#content").removeClass("span11");
			$("#content").addClass("span10")
		}
		$("div").each(function () {
			var d = $(this).attr("onTablet");
			var e = $(this).attr("onDesktop");
			if (d) {
				$(this).removeClass(d);
				$(this).addClass(e)
			}
		});
	}
}

function appendExportSuccess(data){
	window.location.href = data.extraUrl
}

function init(){
	init_links();
	init_upload_manager();
	textareas_options();
	init_datePicker();
	init_timePicker();
	if(typeof Shadowbox != 'undefined'){
		Shadowbox.init({players:  ['img', 'html', 'iframe', 'qt', 'wmp', 'swf', 'flv']});
	}

	/*
	if(exists(('#chart_pie_pagos'))) {
		setPiePagos();
	}

	if(exists(('#chart_pie_planes'))) {
		setPiePlanes();
	}
	*/
	if($("#jMessages").exists()){
		setTimeout(function() {
			$("#jMessages").empty();
		}, 4500);
	}
	if (exists($(".btn-minimize"))){
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
	if(exists($('#map_canvas'))){
		initialize_google_maps();
		var e = $("#map_canvas");
		latm = e.attr('data-lat');
		lngm = e.attr('data-lng');
		setMap({noAutocomplete: true, lat: latm, lng: lngm});
	}


	if(exists(('#chart_lines'))) {
		setTimeout(setChart(), 8000);
	}


	/*
	 if(exists(('.fecha_nacimiento'))) {
		$('.fecha_nacimiento').datepicker({
			format: 'dd/mm/yyyy',
			language: 'es',
			viewMode: 'year'
			});
	}
	*/
}

function setChart(){
	url = _base_url+'dashboard/getInscriptos';
	var data = frm_send('none',url,'abc');
}

function init_datePicker(){
	if(exists(('.j-datepicker'))) {
		$('.j-datepicker').datepicker({
			format: 'dd/mm/yyyy',
			language: 'es'
			});
	}
}

function initChart(datos){
	var LineData = [["Days", "Total x Día" ]];
	$.each(datos.messages,function(){
		LineData.push(this);
	})

	console.log(LineData);



        var data = google.visualization.arrayToDataTable(LineData);


        var options = {
          curveType: 'function',
          legend: { position: 'bottom' },
          vAxis: {
          	viewWindowMode: "explicit",
          	format: 0,
    viewWindow: {
        min: 0
    },

}

        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_lines'));

        chart.draw(data, options);
	/*
	var LineData = [["Days", "Total" ]];
	$.each(datos.messages,function(){
		LineData.push(this);
	})

	var data = google.visualization.arrayToDataTable(LineData);

	console.log(data);
	var options = {
		  title: 'aaaa',
		  curveType: 'function',
		  legend: { position: 'bottom' }
		};
	var chart = new google.visualization.LineChart(document.getElementById('chart_lines'));
	chart.draw(data, options);
	*/
	//console.log();


	/*
	var options = {
        hAxis: {
          title: 'Time'
        },
        vAxis: {
          title: 'Popularity'
        },
        colors: ['#a52714', '#097138'],
        series: {
          0: {
            lineWidth: 10,
            lineDashStyle: [5, 1, 5]
          },
          1: {
            lineWidth: 5,
            lineDashStyle: [7, 2, 4, 3]
          }
        }
      };
		var lineChartData = {
			labels : datos.messages.labels,
			datasets : [
				{
					fillColor : "rgba(151,187,205,0.5)",
					strokeColor : "rgba(151,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					data :  datos.messages.values
				}
			]
		}
		var options = {
			scaleShowGridLines : true,
			scaleShowLabels : true,
			animationSteps : 150,
			scaleOverride: true,
			scaleSteps : Math.max.apply(Math, datos.messages.values),
			scaleStepWidth : 1,
			scaleStartValue : 0
		};
	ctx = document.getElementById("chart_lines").getContext("2d");
	ctx.canvas.width = $('.j-module').width();
	var myLine = new Chart(ctx).Line(lineChartData, options);
	*/
}

function setPiePlanes(){
	setTimeout(function(){
		url = _base_url+'dashboard/getInscriptosPlanesPie';
		var data = frm_send('none',url,'abc');
	}, 1000);
}

function setPiePagos(){
	setTimeout(function(){
		url = _base_url+'dashboard/getInscriptosPagosPie';
		var data = frm_send('none',url,'abc');
	}, 1000);
}

function setBarTickets(){
	setTimeout(function(){
		url = _base_url+'dashboard/getBarsByTicket';
		var data = frm_send('none',url,'abc');
	}, 500);

	setTimeout(function(){
		url = _base_url+'dashboard/getInscriptosPlanesPie';
		var data = frm_send('none',url,'abc');
	}, 1000);

	/*
	setTimeout(function(){
		url = _base_url+'dashboard/getInscriptosPagosPie';
		var data = frm_send('none',url,'abc');
	}, 1800);
	*/
}

function initBarTickets(datos){
	var BarData = [["Ticket", "Total", { role: "style" } ]];
	$.each(datos.messages,function(){
		BarData.push(this);
	})
	var data = google.visualization.arrayToDataTable(BarData);
	  var view = new google.visualization.DataView(data);
	  view.setColumns([0, 1,
					   { calc: "stringify",
						 sourceColumn: 1,
						 type: "string",
						 role: "annotation" },
					   2]);
	  var options = {
		width: 550,
		height: 400,
		bar: {groupWidth: "80%"},
		legend: { position: "none" },
	  };
	  var chart = new google.visualization.ColumnChart(document.getElementById("chart_bar_tickets"));
	  chart.draw(view, options);
}

function intiPiePlanes(datos){
	 var data = new google.visualization.arrayToDataTable(datos.messages,false);
	  var options = {'height':300,
					 'legend':'bottom',
					 'is3D': true,
					  pieHole: 0.4
					 };
	  // Instantiate and draw the chart.
	  var chart = new google.visualization.PieChart(document.getElementById('chart_pie_planes'));
	  chart.draw(data, options);
	/*
	var pieData = [];
	$.each(datos.messages,function(){
		pieData.push(this);
	})
	var options = {
			tooltips: {
				fontSize: '75.4%'
			}
		};
	var myChart = new Chart(document.getElementById("chart_pie_planes").getContext("2d"), options);
	var myPie = myChart.Doughnut(pieData, {
		animationSteps: 100,
		animationEasing: 'easeOutBounce'
	});
	myChart.generateLegend();*/
}

function intiPiePagos(datos){
	// Define the chart to be drawn.
	  var data = new google.visualization.arrayToDataTable(datos.messages,false);
	  var options = {
					 'height':300,
					  'legend':'bottom',
					  'is3D': true
					  };
	  // Instantiate and draw the chart.
	  var chart = new google.visualization.PieChart(document.getElementById('chart_pie_pagos'));
	  chart.draw(data, options);
}

function init_timePicker(){
	if(exists(('.j-timepicker'))){
		$('.j-timepicker').timepicker({
			minuteStep: 5,
			showMeridian: false,
			showSeconds: false
			});
	}
}

function init_links(){
	if ($("#frmFilter").exists()) {
		$("#frmFilter input:text").each(function (b) {
			$(this).unbind("keypress");
			$(this).keypress(function (c) {
				if (c.which == 13) {
					c.preventDefault();
					$("#j-filter-send").click()
				}
			})
		})
	}
	if (exists($("#j-filter-send"))) {
		var a = $("#j-filter-send");
		a.unbind("click");
		a.click(function () {
			pg_setPage(1);
			pg_setExporta(0)
			frm_send($("#frmFilter"))
		})
	}
	if (exists($("#j-filter-export"))) {
		var a = $("#j-filter-export");
		a.unbind("click");
		a.click(function () {
			pg_setPage(1);
			pg_setExporta(1);
			frm_send($("#frmFilter"))
		})
	}
	if (exists($("#j-filter-reset"))) {
		var a = $("#j-filter-reset");
		a.unbind("click");
		a.click(function () {
			clear_form_elements('#frmFilter');
			pg_setPage(1);
			pg_setExporta(0)
			frm_send($("#frmFilter"))
		})
	}
	if (exists($("#j-paging"))) {
		$("#j-paging .j-paging-page").each(function (b) {
			$(this).unbind("click");
			$(this).click(function () {
				value = $(this).attr("data-page");
				pg_setPage(value);
				pg_setExporta(0)
				frm_send($("#frmFilter"))
			})
		})
	}
	if (exists($("#j-limit"))) {
		$( "#j-limit" ).change(function() {
			value = $(this).attr('value');
			pg_setPage(1);
			pg_setLimit(value);
			frm_send($("#frmFilter"))
		});
	}
	if (exists($(".j-sortUp"))) {
		$(".j-sortUp").each(function (b) {
			$(this).unbind("click");
			$(this).click(function () {
				value = $(this).attr("data-sort");
				pg_setExporta(0)
				pg_setOrder("asc-" + value);
				frm_send($("#frmFilter"))
			})
		})
	}
	if (exists($(".j-sortDown"))) {
		$(".j-sortDown").each(function (b) {
			$(this).unbind("click");
			$(this).click(function () {
				value = $(this).attr("data-sort");
				pg_setOrder("desc-" + value);
				pg_setExporta(0)
				frm_send($("#frmFilter"))
			})
		})
	}
	$("a.ax-modal" ).live('click',function(event) {
		event.preventDefault();
		var url = $(this).attr('href');
		frm_send('none',url,'abc');
	});
	init_tooltips();
	if (exists($(".j-exporta"))) {
		$(".j-exporta").each(function (b) {
			$(this).unbind("click");
			$(this).click(function () {
				pg_setOrder("asc-" + value);
				frm_send($("#frmFilter"))
			})
		})
	}

	if (exists($("#j-enable-order"))) {
	   var ord = $("#j-enable-order");
	   var url = ord.attr('data-module');

		ord.unbind("click");

		ord.click(function () {

			stateOrder = ord.attr('data-state')

			if(stateOrder == 0){
				$('.table  td.hide, .table  th.hide').each(function(e,i){
					$(i).addClass('show').removeClass('hide');
				})
				ord.attr('data-state',1)
				ord.text('Guardar Orden');

				$( ".table tbody" ).sortable({
					axis: "y"
				});
				/*
				$( ".table tbody" ).on( "sortstop", function( event, ui ) {

									});
									*/
				//ACA Ejecutar el save del orden
			}



			if(stateOrder == 1){
				$('.table  td.show, .table  th.show').each(function(e,i){
					$(i).addClass('hide').removeClass('show');
				})
				ord.attr('data-state',0)
				ord.text('Ordenar');

				$( ".table tbody" ).sortable( "destroy" );


				var arr = [];
			//	en = [];
				$('.table > tbody  > tr').each(function(e,i){
					var a =  $(i).attr('id')
					arr.push(a+'='+e)
				})


				frm_send('none',url,'abc',arr);

				console.log('se ordeno');
				//ACA ejecutar el disabled del orden y el save
			}


			//$( ".table tbody" ).disableSelection();

		})
	}

}

function pg_setExporta(b) {
	if (!exists($("#j-frmExporta-page"))) {
		var a = $("<input/>", {
			type: "hidden",
			id: "j-frmExporta-page",
			name: "exporta"
		});
		a.appendTo("#frmFilter")
	}
	$("#j-frmExporta-page").val(b)
}

function pg_setPage(b) {
	if (!exists($("#j-frmFilter-page"))) {
		var a = $("<input/>", {
			type: "hidden",
			id: "j-frmFilter-page",
			name: "page"
		});
		a.appendTo("#frmFilter")
	}
	$("#j-frmFilter-page").val(b)
}

/* MODAL */
function open_modal(data){
	var dialog = $("#modal");
	if(!exists(('#modal'))) {
		dialog = $('<div id="modal" class="modal fade" style="display:hidden"></div>').appendTo('body');
	}
	dialog.html(data.html).modal({
	});
}

/* GRID */
function pg_setLimit(b) {
	if (!exists($("#j-frmFilter-limit"))) {
		var a = $("<input/>", {
			type: "hidden",
			id: "j-frmFilter-limit",
			name: "limit"
		});
		a.appendTo("#frmFilter")
	}
	$("#j-frmFilter-limit").val(b)
}

function pg_setOrder(b) {
	if (!exists($("#j-frmFilter-order"))) {
		var a = $("<input/>", {
			type: "hidden",
			id: "j-frmFilter-order",
			name: "order"
		});
		a.appendTo("#frmFilter")
	}
	$("#j-frmFilter-order").val(b)
}

function reloadTable(data){
	$('#jMessages').empty().html(data.status);
	frm_send("none", data.html, 'reload');
	setTimeout(function() {
		$("#jMessages").empty();
	}, 4500);
}

/* FORM FUNCTIONS */
function page_block(a) {
	var b = $("<div/>", {
		id: "j-pg_block",
		style: "width:100%; height:100%; background:rgba(0,0,0,0.6); position:fixed; z-index:500; top:0px;"
	});
	var c = $("<div/>", {
		id: "",
		class: "progress progress-striped active",
		style: ""
	});
	var d = $("<div/>", {
		id: "",
		class: "bar",
		style: "width: 100%",
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
			code: {
			  required: true,
			  minlength: 10,
			  maxlength: 10,
			}
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
var _frm_progress = false;
function frm_send(form, ajaxUrl, ajaxId, extraData) {


/*
console.log(extraData)
$.each(extraData, function(e,a){
	//console.log(e,a)
}) */


	if(form=="none"){
		if(ajaxUrl==undefined || ajaxId==undefined)  { alert('102 frm_send'); return false;}
		var form = $("<form/>", {"id" : "frm"+ajaxId, "action":ajaxUrl});
	}
	if(extraData==undefined)
		extraData = new Array();
	if (!exists(form) && form != "none") {
		alert('102 frm_send');
		return false;
	}
	if (_frm_progress) {
	  //  alert('105 frm_send');
		return false;
	}
	if (extraData.length > 0)
		extraData = "&" + extraData.join("&")
 //   extraData = "&" + extraData.join("&")
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
					console.log('103 '+form.attr("id"));
					return false;
				break;
			}
			switch(data.responseType) {
				case "function":
					if (data.value == "") {
						alert('106 '+form.attr("id"));
					}
					var fn = data.value
					if (window[fn] != undefined) {
						eval(fn)(data)
					} else {
						alert('108 '+fn);
					}
				break;
				 case 'inject':
					if(exists('#modal')) {
						$('#modal').modal('hide')
					}
					var target = (data.inject != undefined) ? $("." + data.inject) : form.find(".x-msg");
					target.html(data.value);
					_frm_progress = false;
					inject();
					break;
				case "redirect":
					if (data.value == "") {
						alert('106 '+form.attr("id"));
					}
					   window.location.href = data.value
				break;
				default:
					console.log('104 '+form.attr("id"));
				break;
			}
		},
		error : function(data) {
			_frm_progress = false;
			console.log('Error Procesando Formulario '+form.attr("id"));
		}
	})
}

function inject(){
   init_links();
   init_tooltips();
}

function change_select_multi_transfer(left,right){
	$("#"+left+" option:selected").remove().appendTo('#'+right);
}

function defaultPass(el){
	var nombre = $(el).val().toLowerCase();
	nombre = nombre.split(' ').join('');
	nombre = accentsTidy(nombre);
	$('#password, #valid_password').val(nombre);
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
				bgcolor: "#ffffff"
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
		//case "pdf":
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
/* COMMONS */
function exists(el) {
	return ($(el).length > 0) ? true : false;
}

jQuery.fn.exists = function () {
	return this.length > 0
};

function frm_jsonDecode(data) {
	try {
		data = jQuery.parseJSON(data);
	} catch(err) {
		alert(107, err);
		data = '{"success":"error"}';
		data = jQuery.parseJSON(data);
	}
	return data
}

function init_tooltips(){
	$('.tip').tooltip();
	$('.tip-left').tooltip({ placement: 'left' });
	$('.tip-right').tooltip({ placement: 'right' });
	$('.tip-top').tooltip({ placement: 'top' });
	$('.tip-bottom').tooltip({ placement: 'bottom' });
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

function clear_form_elements(e) {
	$(e).find(':input').each(function() {
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

function textareas_options(){
	if(exists($('.animated'))){
		$('textarea[class*=animated]').autosize({append: "\n"});
	}
	if(exists($('.limited'))){
		$('textarea[class*=limited]').each(function() {
			var limit = parseInt($(this).attr('data-maxlength')) || 100;
			$(this).inputlimiter({
				"limit": limit,
				remText: '%n character%s remaining...',
				limitText: 'max allowed : %n.'
			});
		});
	}
	 $('textarea[class*=jCleditorSimple]').each(function() {
		$(this).cleditor({
						 controls: "bold italic underline"
						 })
	});
}

$.fn.reset = function () {
  $(this).each (function() {
	this.reset(); });
}

accentsTidy = function(s){
	var r=s.toLowerCase();
	r = r.replace(new RegExp("\\s", 'g'),"");
	r = r.replace(new RegExp("[àáâãäå]", 'g'),"a");
	r = r.replace(new RegExp("æ", 'g'),"ae");
	r = r.replace(new RegExp("ç", 'g'),"c");
	r = r.replace(new RegExp("[èéêë]", 'g'),"e");
	r = r.replace(new RegExp("[ìíîï]", 'g'),"i");
	r = r.replace(new RegExp("ñ", 'g'),"n");
	r = r.replace(new RegExp("[òóôõö]", 'g'),"o");
	r = r.replace(new RegExp("œ", 'g'),"oe");
	r = r.replace(new RegExp("[ùúûü]", 'g'),"u");
	r = r.replace(new RegExp("[ýÿ]", 'g'),"y");
	r = r.replace(new RegExp("\\W", 'g'),"");
	return r;
};
