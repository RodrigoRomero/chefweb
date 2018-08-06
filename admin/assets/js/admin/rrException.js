var RrException = function() {

	this.show = function(code, msg){
		var txt = "";
		switch(code){
			case 101:
				txt = "Error de conexion";
				break;
			case 102:
				txt = "Elemento no existe";
				break;
			case 103:
				txt = "Error de success";
				break;
			case 104:
				txt = "Error de responseType";
				break;
			case 105:
				txt = "Procesando envio...";
				break;
			case 106:
				txt = "ResponseType sin value";
				break;
			case 107:
				txt = "Json error";
				break;
			case 108:
				txt = "Function not exists";
				break;
		}
		txt += "("+code+": "+msg+")"
		console.log(txt)
	}
};