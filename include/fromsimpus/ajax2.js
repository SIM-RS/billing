var req = new Array(); 
var statusRequest = "<img src='../images/ajax.gif' alt='loading...' style='position:absolute' />"

GetId = function(id){
   if (document.getElementById)
      return document.getElementById(id);
   else if (document.all)
      return document.all[id];
}

Request = function( vUrl , vTarget, vForm, vMethod) {
  GetId(vTarget).innerHTML = statusRequest+GetId(vTarget).innerHTML 
  var pos = -1;
  for (var i=0; i<req.length; i++) {
    if (req[i].available == 1) { 
      pos = i; 
      break; 
	}
  }

  if (pos == -1) { 
    pos = req.length; 
    req[pos] = new newRequest(1); 
  }

  if (req[pos].xmlhttp) {
    req[pos].available = 0;
    req[pos].xmlhttp.open(vMethod , vUrl, true);
	if (vForm == ""){	
		req[pos].xmlhttp.onreadystatechange = function() {
		  if (typeof(req[pos]) != 'undefined' && 
			req[pos].available == 0 && 
			req[pos].xmlhttp.readyState == 4) {
			  if (req[pos].xmlhttp.status == 200 || req[pos].xmlhttp.status == 304) {
					GetId(vTarget).innerHTML = req[pos].xmlhttp.responseText;
			  } else {
					req[pos].xmlhttp.abort();
			  }
			  req[pos].available = 1;
		  }
		}
		
		if (window.XMLHttpRequest) {
		  req[pos].xmlhttp.send(null);
		} else if (window.ActiveXObject) {
		  req[pos].xmlhttp.send();
		}
	}else{
		var params = '';
		for(i = 0; i < vForm.length; i++){
			if (params.length) params += '&';
			params += vForm.elements[i].name + '=' + encodeURI(vForm.elements[i].value);
		}
		req[pos].xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		req[pos].xmlhttp.setRequestHeader('Content-Length', params.length);
		req[pos].xmlhttp.onreadystatechange = function() {
		  if (typeof(req[pos]) != 'undefined' && 
			req[pos].available == 0 && 
			req[pos].xmlhttp.readyState == 4) {
			  if (req[pos].xmlhttp.status == 200 || req[pos].xmlhttp.status == 304) {
					GetId(vTarget).innerHTML = req[pos].xmlhttp.responseText;
			  } else {
					req[pos].xmlhttp.abort();
			  }
			  req[pos].available = 1;
		  }
		}
		req[pos].xmlhttp.send(params);
	}
  }
  return false;
}

function newRequest(available) {
	this.available = available;
	this.xmlhttp = false;
	
	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		this.xmlhttp = new XMLHttpRequest();
		if (this.xmlhttp.overrideMimeType) {
			this.xmlhttp.overrideMimeType('text/html');
		}
	} 
	else if (window.ActiveXObject) { // IE
		var MsXML = new Array('Msxml2.XMLHTTP.5.0','Msxml2.XMLHTTP.4.0','Msxml2.XMLHTTP.3.0','Msxml2.XMLHTTP','Microsoft.XMLHTTP');	
		for (var i = 0; i < MsXML.length; i++) {
			try {
				this.xmlhttp = new ActiveXObject(MsXML[i]);
			} catch (e) {}
		}
	}	
}