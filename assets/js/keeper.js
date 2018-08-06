var RR = window.RR || {};

RR.keeper = (function() {
	var module = {};
	var cookies = document.cookie.split(";");
	var browser_storage_supported = Modernizr.localstorage;

	/* Cookies */

	module.setCookie = function(key, value, days) {
		var limit_days = days || 365;
		var d = new Date();
		d.setTime(d.getTime() + (limit_days*24*60*60*1000));
		var expires = "expires="+ d.toUTCString();
		document.cookie = key + "=" + value + ";" + expires + ";path=/";
	}

	module.getCookie = function(key) {
		var name = key + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(';');
		for(var i = 0; i <ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0) == ' ') c = c.substring(1);

				if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
		}
		return "";
	}

	module.removeCookie = function(key) {
		var expired = new Date(new Date().getTime() - 24 * 3600 * 1000); // less 24 hours
		document.cookie= key + "=null; path=/; expires=" + expired.toGMTString();
		cookies = document.cookie.split(";");
	}

	/* Local Storage */

	module.save = function(key, value) {
		if (browser_storage_supported) window.localStorage.setItem(key, value);
		else module.setCookie('local_'+key, value);
	}

	module.get = function(key) {
		if (browser_storage_supported) return window.localStorage.getItem(key);
		else return module.getCookie('local_'+key);
	}

	module.remove = function(key) {
		if (browser_storage_supported) window.localStorage.removeItem(key);
		else module.removeCookie('local_'+key);
	}

	/* Session Storage */

	module.saveForSession = function(key, value) {
		if (browser_storage_supported) window.sessionStorage.setItem(key, value);
		else module.setCookie('session_'+key, value);
	}

	module.getFromSession = function(key, value) {
		if (browser_storage_supported) return window.sessionStorage.getItem(key);
		else return module.getCookie('session_'+key);
	}

	module.removeFromSession = function(key, value) {
		if (browser_storage_supported) window.sessionStorage.removeItem(key);
		else module.removeCookie('session_'+key);
	}


	return module;

}(RR))
