var reqXMLView = new Array(); 

ReqXMLV = function(){
  var pos = -1;
  for (var i=0; i<reqXMLView.length; i++) {
    if (reqXMLView[i].available == 1) { 
      pos = i; 
      break; 
	}
  }

  if (pos == -1) { 
    pos = reqXMLView.length; 
    reqXMLView[pos] = new newRequestXMLView(1); 
  }
  return pos;
}

GetIdView = function(id){
   if (document.getElementById)
      return document.getElementById(id);
   else if (document.all)
      return document.all[id];
}

function newRequestXMLView(available) {
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

function TabView(id){
	this.tab=document.getElementById(id);
	this.tab.ev="";
	this.TabHeight=30;
	this.obj = document.createElement("TABLE");this.obj.id = "TabTable_"+id;
	this.obj.cellSpacing = 0; this.obj.cellPadding = 0; this.obj.border = "0"; //this.obj.border = "1px";
	this.obj.style.borderCollapse="collapse"; this.obj.style.borderBottom="none";
    //var r = this.obj.insertRow(0);r.className = "tabCaption";
	//r.insertCell(0).innerHTML = "";r.childNodes[0].style.width = '100%';
	this.tab.appendChild(this.obj);
	this.box = document.createElement("DIV");
	this.box.id='page_'+id;
	//this.box.className = "TabOut"
	this.box.style.overflow = 'hidden';
	this.box.style.width='100%';//this.box.style.height='100%';
	this.box.style.height=(parseInt(this.tab.style.height.substr(0,this.tab.style.height.length-2))-parseInt(this.TabHeight)) + 'px';
	this.box.style.border="solid 1px";//this.box.style.overflow='scroll';
	this.tab.appendChild(this.box);
	this.box = document.createElement("DIV");
	this.box.id='divBlank_'+id;this.box.style.height='2px';this.box.style.position="absolute";this.box.style.border="solid 1px";this.box.style.borderTop="none";this.box.style.borderBottom="none";this.box.style.borderLeft="none";this.box.style.borderRight="none"; this.box.className = "TabOut";
	this.tab.appendChild(this.box);
	this.setTabCaption=function(str){
		var cpage=document.getElementById('page_'+id);
		var ctable=document.getElementById("TabTable_"+id);
		var cRow=ctable.insertRow(0);//cRow.className = "TabOut";
		var d="";
		cRow.className = "TabCaptionBorder";cRow.align = "center";
		this.TabCaptionArr=str.split(",");
		for (var i=0;i<this.TabCaptionArr.length;i++){
			d+="true,";
			cRow.insertCell(i).innerHTML = this.TabCaptionArr[i];
			cRow.childNodes[i].id=id+"_"+i;
			cRow.childNodes[i].style.height = '30px';
			cRow.childNodes[i].className = 'TabOut';
			//cRow.childNodes[i].onclick = function() {alert("1");};;
			if (i==0){
				cRow.childNodes[i].onmouseover=function(){this.className='TabOut';}
			}else{
				cRow.childNodes[i].onmouseover=function(){this.className='TabOver';}
			}
			cRow.childNodes[i].onmouseout=function(){this.className='TabOut';}
			cRow.childNodes[i].onclick=function(){TabViewSwitch(this,id);}
			this.box = document.createElement("DIV");
			this.box.id='page_'+id+"_"+i;
			this.box.style.height=cpage.style.height;//alert(this.box.style.height);
			this.box.innerHTML="<br>This is Page "+(i+1);
			this.box.style.display=(i==0)?"block":"none";
			this.box.className = 'DivPage';
			cpage.appendChild(this.box);
		}
		d=d.substr(0,d.length-1);
		this.tab.TabDisplayArr=d.split(",");
	}
	this.setTabCaption2=function(str){
		this.TabCaptionArr=str.split(",");
		for (var i=0;i<this.TabCaptionArr.length;i++){
			document.getElementById(id+"_"+i).innerHTML=this.TabCaptionArr[i];
		}
	}
	this.setTabCaptionWidth=function(str){
		var ctable=document.getElementById("TabTable_"+id);
		var cRow=ctable.rows[0];
		this.TabCaptionWidthArr=str.split(",");
		for (var i=0;i<this.TabCaptionWidthArr.length;i++){
			cRow.childNodes[i].style.width = this.TabCaptionWidthArr[i]+"px";
		}
		document.getElementById("divBlank_"+id).style.width = cRow.childNodes[0].style.width;
		var p=GetXY(cRow.childNodes[0]);
		document.getElementById("divBlank_"+id).style.top = parseInt(p[1])+cRow.childNodes[0].offsetHeight+"px";
		//document.getElementById("divBlank_"+id).style.top = this.tab.offsetTop+cRow.childNodes[0].offsetTop+this.TabHeight+100+"px";
		document.getElementById("divBlank_"+id).style.left = parseInt(p[0])-1+"px";
		//document.getElementById("divBlank_"+id).style.left = this.tab.offsetLeft+cRow.childNodes[0].offsetLeft+"px";
	}
	this.setTabPage=function(str){
		this.TabPageArr=str.split(",");
		document.getElementById(id).TabLoadedCount=0;
		document.getElementById(id).TabCount=this.TabPageArr.length;
		for (var i=0;i<this.TabPageArr.length;i++){
			this.loadURL(this.TabPageArr[i],'page_'+id+"_"+i,"","GET");
		}
	}
	this.setTabDisplay=function(str){
	var px;
		this.tab.TabDisplayArr=str.split(",");
		//alert(parseInt(this.tab.TabDisplayArr[this.tab.TabDisplayArr.length-1]));
		for (var i=0;i<this.tab.TabDisplayArr.length-1;i++){
			//alert(this.tab.TabDisplayArr[i]);
			px=document.getElementById(id+"_"+i);
			if (this.tab.TabDisplayArr[i]=="false"){
				px.innerHTML = "";
				px.className='TabInvisible';
				px.onmouseover="";
				px.onmouseout="";
				px.onclick="";
			}else{
				px.innerHTML = this.TabCaptionArr[i];
				if (i==parseInt(this.tab.TabDisplayArr[this.tab.TabDisplayArr.length-1])){
					px.onmouseover==function(){this.className='TabOut';}
				}else{
					px.onmouseover==function(){this.className='TabOver';}
				}
				px.onmouseout=function(){this.className='TabOut';}
				px.onclick=function(){TabViewSwitch(this,id);}
				px.className='TabOut';
			}
		}
		
		//alert(id+"_"+this.tab.TabDisplayArr[this.tab.TabDisplayArr.length-1]);
		TabViewSwitch(document.getElementById(id+"_"+this.tab.TabDisplayArr[this.tab.TabDisplayArr.length-1]),id);
	}
	this.refreshTab=function(){
	  	//alert('refresh');
	    TabViewSwitch(document.getElementById(id+"_0"),id);
	}
	this.onLoaded=function(catcher){
		document.getElementById(id).ev=catcher;
	}

	this.loadURL=function(vUrl,vTarget,vForm,vMethod){
		var p=ReqXMLV();
		//alert("ok");
		if (reqXMLView[p].xmlhttp) {
			reqXMLView[p].available = 0;
			reqXMLView[p].xmlhttp.open(vMethod , vUrl, true);
			if (vForm == ""){	
				reqXMLView[p].xmlhttp.onreadystatechange = function() {
				//alert(this.TabPageArr.length);
				  if (typeof(reqXMLView[p]) != 'undefined' && 
					reqXMLView[p].available == 0 && 
					reqXMLView[p].xmlhttp.readyState == 4) {
						if (reqXMLView[p].xmlhttp.status == 200 || reqXMLView[p].xmlhttp.status == 304) {
							GetIdView(vTarget).innerHTML = reqXMLView[p].xmlhttp.responseText;
						}else{
							reqXMLView[p].xmlhttp.abort();
						}
						reqXMLView[p].available = 1;
						//alert("ok1");
						document.getElementById(id).TabLoadedCount++;
						if (document.getElementById(id).TabLoadedCount==document.getElementById(id).TabCount){
							if (document.getElementById(id).ev!=""){
								document.getElementById(id).ev();
							}
						}
				  }
				}
				if (window.XMLHttpRequest) {
				  reqXMLView[p].xmlhttp.send(null);
				} else if (window.ActiveXObject) {
				  reqXMLView[p].xmlhttp.send();
				}
			}else{
				var params = '';
				for(i = 0; i < vForm.length; i++){
					if (params.length) params += '&';
					params += vForm.elements[i].name + '=' + encodeURI(vForm.elements[i].value);
				}
				reqXMLView[p].xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				reqXMLView[p].xmlhttp.setRequestHeader('Content-Length', params.length);
				reqXMLView[p].xmlhttp.onreadystatechange = function() {
				  if (typeof(reqXMLView[p]) != 'undefined' && 
					reqXMLView[p].available == 0 && 
					reqXMLView[p].xmlhttp.readyState == 4) {
					  if (req[p].xmlhttp.status == 200 || req[p].xmlhttp.status == 304) {
							GetIdView(vTarget).innerHTML = req[p].xmlhttp.responseText;
					  } else {
							reqXMLView[p].xmlhttp.abort();
					  }
					  reqXMLView[p].available = 1;
				  }
				}
				reqXMLView[p].xmlhttp.send(params);
			}
		}
		return false;
	}
}
GetXY=function(aTag){
  var p=[0,0];
  while(aTag!=null){
	p[0]+=aTag.offsetLeft;
	p[1]+=aTag.offsetTop;
	//alert(p[0]+' - '+p[1]);
	aTag=aTag.offsetParent;
  }
  //alert('tes');
  return p;
}
function TabViewSwitch(Tabs,id){
var tr=Tabs.parentNode;
var cdiv=document.getElementById("divBlank_"+Tabs.id.substr(0,Tabs.id.length-2));
var pg=document.getElementById(id).TabDisplayArr;
	//alert(id);
	//alert(Tabs.parentNode);
	
	for (var i=0;i<tr.cells.length;i++){
		if (pg[i]=="false"){
			var px=document.getElementById(id+"_"+i);
			px.innerHTML = "";
			px.className='TabInvisible';
			px.onmouseover="";
			px.onmouseout="";
			px.onclick="";
		}//else{
			if (tr.cells[i]==Tabs){
				Tabs.onmouseover="";
				Tabs.className="TabOut";
				Tabs.onclick="";
				cdiv.style.width=(parseInt(Tabs.style.width.substr(0,Tabs.style.width.length-2))-2)+"px";
				var p=GetXY(Tabs);
				cdiv.style.left=(parseInt(p[0]))+"px";
				cdiv.style.top=(parseInt(p[1])+Tabs.offsetHeight-1)+"px";
				//alert(Tabs);
				//alert(cdiv.style.left+" - "+cdiv.style.top);
				//cdiv.style.left=document.getElementById(Tabs.id.substr(0,Tabs.id.length-2)).offsetLeft+Tabs.offsetLeft+"px";
				document.getElementById("page_"+Tabs.id).style.display='block';
				document.getElementById(Tabs.id).style.backgroundColor="#061247";
			}else{
				tr.cells[i].onmouseover=function(){this.className='TabOver'};
				tr.cells[i].onclick=function(){TabViewSwitch(this,id)};
				document.getElementById("page_"+tr.cells[i].id).style.display='none';
				document.getElementById(tr.cells[i].id).style.backgroundColor="#658ECD";
			}
		//}
	}
}