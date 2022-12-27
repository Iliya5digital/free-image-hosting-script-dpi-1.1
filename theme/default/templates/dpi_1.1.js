	function showhide(id){ 
		if (document.getElementById){ 
			obj = document.getElementById(id); 
			if (obj.style.display == "none"){ 
				obj.style.display = ""; 
			} else { 
				obj.style.display = "none"; 
			} 
		} 
	} 
	function show(id){ 
		if (document.getElementById){ 
			obj = document.getElementById(id); 
			obj.style.display = ""; 
		} 
	} 
	function hide(id){ 
		if (document.getElementById){ 
			obj = document.getElementById(id); 
			obj.style.display = "none"; 
		} 
	} 
	function obi(objn) {
		return document.getElementById(objn);
	}
	function sel_txt(obj) {
		obj.focus();
		obj.select();
	}		
	function str_replace(needle, replacement,haystack) {
	    var temp = haystack.split(needle);
	    return temp.join(replacement);
	}	
	function ifeature_image(theimage) {
		obi('fifr').src=theimage;
	}