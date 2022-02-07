/*	document.write("<div id=\"DivSort\" style=\"display:block;border:solid 1px;width:130px;top:30px;left:30px;position:absolute;\">tes</div>");
var icntt=0;
var pname;
var pinp='';
var cntmax=5;
var grd;
function CountFr(){
	icntt=icntt+1;
	if (icntt>cntmax){
		fHideFr();
	}else{
		setTimeout("CountFr()",1000);
	}
}

function ReloadFr(pc){
	if (document.getElementById('DivSort').style.visibility=="hidden"){
		CallFr(pc);
	}
}
function fGetXY(aTag){
  var p=[0,0];
  while(aTag!=null){
  	p[0]+=aTag.offsetLeft;
  	p[1]+=aTag.offsetTop;
  	aTag=aTag.offsetParent;
  }
  //alert(p);
  return p;
}

function CallFr(pc){
	if (document.getElementById('DivSort').style.visibility=="visible"){
		fHideFr();
		return;
	}else{
		fShowFr(pc);
	}
}
function fShowFr(pc){
  var p=fGetXY(pc);
  //alert(pc.parentNode.parentNode.parentNode.parentNode.parentNode.id);
  grd=pc.parentNode.parentNode.parentNode.parentNode.parentNode.id;
  with (document.getElementById('DivSort').style) {
  	//left=parseInt(p[0])-1-pc.parentNode.parentNode.parentNode.parentNode.scrollLeft + 'px';
	//top =parseInt(p[1])+pc.offsetHeight+1 + 'px';
	visibility="visible";
	//alert(p[0]+' - '+p[1]+' - '+pc.offsetHeight);
  }
  pname=pc.id;
  document.getElementById('tdsbj').innerHTML=pname;
  icntt=0;
  cntmax=5;
  CountFr();
  document.getElementById('srt').style.display='block';document.getElementById('flt').style.display='none';
}
function fHideFr() {
  with (document.getElementById('DivSort').style) {
	visibility="hidden";
	//top=parseInt(top)-10; // for nn6 bug
  }
}
function SetSort(q){
	fHideFr();
	//parent.document.getElementById(grd).sorting=q;
	//parent.document.getElementById(grd).page=1;
	//parent.document.getElementById(grd).selectedRow=1;
	//parent.goFilterAndSort(grd);
}
function SetFilter(p){
	fHideFr();
	//parent.document.getElementById(grd).filter=p;
	//parent.document.getElementById(grd).page=1;
	//parent.document.getElementById(grd).selectedRow=1;
	//parent.goFilterAndSort(grd);
}
function fFilter(e,par){
var keywords=par.value;
var key;
	if(window.event) {
	  key = window.event.keyCode; 
	}
	else if(e.which) {
	  key = e.which;
	}
	if (key==27){
		fHideFr();
	}else if (key==13){
		if (document.getElementById('tflt').value!=''){
			//SetFilter(pname+'|'+document.getElementById('tflt').value);
		}else{
			alert('Masukkan Filter Terlebih Dahulu');
		}
	}
}

var dvsrt=document.createElement("DIV");
	dvsrt.id="srt";
	dvsrt.style.display="block";
var tblsrt=document.createElement("TABLE");
	tblsrt.cellPadding="0";
	tblsrt.cellSpacing="0";
	tblsrt.border="0";
	tblsrt.style.width="100%";
var tblCrow=tblsrt.insertRow(0);
	tblCrow.className="divSort";
	tblCrow.onmouseover=function(){icntt=0;this.className='divSortMOver';}
	tblCrow.onmouseout=function(){this.className='divSort';}
	tblCrow.onclick=function(){SetSort(pname+' asc');}
	tblCrow.insertCell(0).innerHTML="&nbsp;<img src=\"theme/sort/sortascending.gif\" border=\"0\" width=\"16\" height=\"16\">";
	tblCrow.insertCell(1).innerHTML="&nbsp;";
	tblCrow.insertCell(2).innerHTML="<i>Sort Ascending</i>";
	
	tblCrow=tblsrt.insertRow(1);
	tblCrow.className="divSort";
	tblCrow.onmouseover=function(){icntt=0;this.className='divSortMOver';}
	tblCrow.onmouseout=function(){this.className='divSort';}
	tblCrow.onclick=function(){SetSort(pname+' desc');}
	tblCrow.insertCell(0).innerHTML="&nbsp;<img src=\"theme/sort/sortdescending.gif\" border=\"0\" width=\"16\" height=\"16\">";
	tblCrow.insertCell(1).innerHTML="&nbsp;";
	tblCrow.insertCell(2).innerHTML="<i>Sort Descending</i>";
	
	tblCrow=tblsrt.insertRow(2);
	tblCrow.className="divSort";
	tblCrow.onmouseover=function(){icntt=0;this.className='divSortMOver';}
	tblCrow.onmouseout=function(){this.className='divSort';}
	tblCrow.onclick=function(){
		icntt=0;cntmax=15;document.getElementById('srt').style.display='none';
		document.getElementById('tflt').value='';document.getElementById('flt').style.display='block';
		document.getElementById('tflt').focus();
	}
	tblCrow.insertCell(0).innerHTML="&nbsp;<img src=\"theme/sort/addfilter.gif\" border=\"0\" width=\"16\" height=\"16\">";
	tblCrow.insertCell(1).innerHTML="&nbsp;";
	tblCrow.insertCell(2).innerHTML="<i>Filter...</i>";
	
	tblCrow=tblsrt.insertRow(3);
	tblCrow.className="divSort";
	tblCrow.onmouseover=function(){icntt=0;this.className='divSortMOver';}
	tblCrow.onmouseout=function(){this.className='divSort';}
	tblCrow.onclick=function(){
		if (document.getElementById(grd).filter!=''){
			SetFilter('');
		}else{
			fHideFr();
		}
	}
	tblCrow.insertCell(0).innerHTML="&nbsp;<img src=\"theme/sort/removefilter.gif\" border=\"0\" width=\"16\" height=\"16\">";
	tblCrow.insertCell(1).innerHTML="&nbsp;";
	tblCrow.insertCell(2).innerHTML="<i>Remove Filter</i>";
	
	dvsrt.appendChild(tblsrt);
	document.getElementById("DivSort").innerHTML="";
	document.getElementById("DivSort").appendChild(dvsrt);

	dvsrt=document.createElement("DIV");
	dvsrt.id="flt";
	dvsrt.style.display="none";
	tblsrt=document.createElement("TABLE");
	tblsrt.cellPadding="0";
	tblsrt.cellSpacing="0";
	tblsrt.border="0";
	tblsrt.style.width="100%";
	tblsrt.style.height="100%";
	tblCrow=tblsrt.insertRow(0);
	tblCrow.className="divSort";
	tblCrow.insertCell(0).innerHTML="&nbsp;";
	
	tblCrow=tblsrt.insertRow(1);
	tblCrow.className="divSort";
	tblCrow.insertCell(0).innerHTML="<input name=\"tflt\" type=\"text\" id=\"tflt\" size=\"10\" style=\"text-align:center\" onKeyUp=\"fFilter(event,this)\">";
	tblCrow.childNodes[0].align="center";
	
	tblCrow=tblsrt.insertRow(2);
	tblCrow.className="divSort";
	tblCrow.insertCell(0).innerHTML="<img src=\"theme/sort/find.png\" border=\"0\" width=\"16\" height=\"16\" title=\"Filter Data\" style=\"cursor:pointer\" onClick=\"if (document.getElementById('tflt').value!=''){SetFilter(pname+'|'+document.getElementById('tflt').value)}else{alert('Masukkan Filter Terlebih Dahulu')}\">&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"theme/sort/back.gif\" border=\"0\" width=\"16\" height=\"16\" title=\"Batal\" style=\"cursor:pointer\" onClick=\"fHideFr()\">";
	tblCrow.childNodes[0].align="center";
	
	dvsrt.appendChild(tblsrt);
	document.getElementById("DivSort").appendChild(dvsrt);
*/
var reqXMLGrd = new Array();

ReqXML = function(){
  var pos = -1;
  for (var i=0; i<reqXMLGrd.length; i++) {
    if (reqXMLGrd[i].available == 1) { 
      pos = i; 
      break; 
	}
  }

  if (pos == -1) { 
    pos = reqXMLGrd.length; 
    reqXMLGrd[pos] = new newRequestXMLGrd(1); 
  }
  return pos;
}

function newRequestXMLGrd(available) {
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

function DSGridObject(id){
	this.grid=document.getElementById(id);
	this.grid.style.backgroundColor='white';
	this.grid.selectedRow=1;
	this.grid.sorting='';
	this.grid.filter='';
	this.grid.page=1;
	this.grid.maxpage=1;
	this.grid.ev="";
	this.onRowClick='';
	this.onRowDblClick='';
	this.cellHeight=20;
	this.grid.tmpData='init';
	this.grid.gridboxh=this.grid.style.height.substr(0,this.grid.style.height.length-2);
	this.obj = document.createElement("TABLE"); this.obj.cellSpacing = 0; this.obj.cellPadding = 0; this.obj.style.width = "100%"; this.obj.style.tableLayout = "fixed"; this.obj.border = 0;
    var r = this.obj.insertRow(0);r.className = "headtable";r.id="hdrcaption_"+id;r.style.height = "20px";
	r.insertCell(0).innerHTML = "";r.childNodes[0].style.width = '100%';
	this.grid.hdrcaptionh=r.style.height.substr(0,r.style.height.length-2);
	this.grid.appendChild(this.obj);
	this.obj = document.createElement("TABLE"); this.obj.cellSpacing = 0; this.obj.cellPadding = 0; this.obj.style.width = "100%"; this.obj.style.tableLayout = "fixed"; this.obj.style.borderCollapse = 'collapse'; this.obj.border = '1px';
    r = this.obj.insertRow(0);r.className = "headtable";r.id="hdrcol_"+id; r.style.height = "20px";
	this.grid.hdrcolh=r.style.height.substr(0,r.style.height.length-2);
	this.box = document.createElement("DIV");
	this.box.id='hdrbox_'+id;this.box.style.width='100%';this.box.style.overflow='hidden';
	this.box.appendChild(this.obj);
	this.grid.appendChild(this.box);
	this.obj = document.createElement("TABLE"); this.obj.cellSpacing = 0; this.obj.cellPadding = 0; this.obj.style.width = "100%"; this.obj.style.tableLayout = "fixed"; this.obj.style.borderCollapse = 'collapse'; this.obj.border = '1px';this.obj.id='tblgrid_'+id;
	this.box = document.createElement("DIV");
	this.box.id='griditem_'+id;this.box.style.width='100%';this.box.style.overflow='scroll';
	this.box.onscroll=function(){document.getElementById('hdrbox_'+id).scrollLeft=this.scrollLeft;}
	this.box.style.height=(parseInt(this.grid.gridboxh)-parseInt(this.grid.hdrcolh)-parseInt(this.grid.hdrcaptionh)-1) + 'px';
	this.box.appendChild(this.obj);
	this.grid.appendChild(this.box);
	this.objpaging = document.createElement("TABLE"); this.objpaging.cellSpacing = 0; this.objpaging.cellPadding = 0; this.objpaging.style.width = "100%"; this.objpaging.border = 0;
	r = this.objpaging.insertRow(0);
	r.insertCell(0).innerHTML = "Halaman";r.childNodes[0].style.width = '40%';r.childNodes[0].className = "textpaging";
	r.insertCell(1).innerHTML = "";r.childNodes[1].style.width = '30%';
	r.insertCell(2).innerHTML = "Img";r.childNodes[2].style.width = '30%';r.childNodes[2].align = 'right';
	
	this.setHeader=function(str){document.getElementById('hdrcaption_'+id).childNodes[0].innerHTML = str;}
	
	this.setCellHeight=function(str){
		this.cellHeight=str;
	}
	this.setCellAlign=function(str){
		this.cellAlignArr=str.split(",");
	}
	this.setCellType=function(str){
		this.cellTypeArr=str.split(",");
	}
	this.setColHeader=function(str){
		var a=str.split(",");
		if (this.cellAlignArr==undefined){
			this.cellAlignArr=new Array();
			this.cellAlignIsEmpty=true;
			//alert(this.cellAlignArr);
		}
		if (this.cellTypeArr==undefined){
			this.cellTypeArr=new Array();
			this.cellTypeIsEmpty=true;
			//alert(this.cellAlignArr);
		}
		//var cRow = tbl.rows.length;
		for (var i=0;i<a.length;i++){
			document.getElementById('hdrcol_'+id).insertCell(i).innerHTML = a[i];
			if (this.cellAlignIsEmpty==true) this.cellAlignArr[i]='center';
			if (this.cellTypeIsEmpty==true) this.cellTypeArr[i]='txt';
		}
	}
	this.setIDColHeader=function(str){
		var a=str.split(",");
		//var cRow = tbl.rows.length;
		for (var i=0;i<a.length;i++){
			if (a[i]!=""){
				document.getElementById('hdrcol_'+id).childNodes[i].id = a[i];
				//alert(document.getElementById('hdrcol_'+id).childNodes[i].id);
				document.getElementById('hdrcol_'+id).childNodes[i].onclick = function(){ifPop.CallFr(this);}
			}
		}
	}
	this.getIDColHeader=function(col){
		//alert(col);
		return document.getElementById('hdrcol_'+id).childNodes[parseInt(col)-1].id;
	}
	this.setColWidth=function(str){
		this.ColWidthArr=str.split(",");
		//var a=str.split(",");
		//var cRow = tbl.rows.length;
		for (var i=0;i<this.ColWidthArr.length-1;i++){
			document.getElementById('hdrcol_'+id).childNodes[i].style.width = this.ColWidthArr[i]+'px';
		}
		document.getElementById('hdrcol_'+id).childNodes[this.ColWidthArr.length-1].style.width = parseInt(this.ColWidthArr[this.ColWidthArr.length-1])+20+'px';
		this.grid.hdrcolh=document.getElementById('griditem_'+id).offsetTop-document.getElementById('hdrbox_'+id).offsetTop;
		document.getElementById('griditem_'+id).style.height=(parseInt(this.grid.gridboxh)-parseInt(this.grid.hdrcolh)-parseInt(this.grid.hdrcaptionh)) + 'px';
	}
	this.getSelRow=function(){
		return document.getElementById(id).selectedRow;
	}
	this.getMaxRow=function(){
		var tbl=document.getElementById('tblgrid_'+id);
		var crow=tbl.rows.length;
		return crow;
	}
	this.cellsGetValue=function(row,col){
		var tbl=document.getElementById('tblgrid_'+id);
		var crow=tbl.rows[row-1];
		var tmp1;
		
		if (this.cellTypeArr){
		  tmp1 = (this.cellTypeArr[col-1]=="txt")?crow.childNodes[col-1].innerHTML:crow.childNodes[col-1].childNodes[0].value;
		  while (tmp1.indexOf('&amp;')>0){
		      tmp1=tmp1.replace('&amp;','&');
		  }
		  while (tmp1.indexOf('&gt;')>0){
		      tmp1=tmp1.replace('&gt;','>');
		  }
		  while (tmp1.indexOf('&lt;')>0){
		      tmp1=tmp1.replace('&lt;','<');
		  }
		  return tmp1;
			//return (this.cellTypeArr[col-1]=="txt")?crow.childNodes[col-1].innerHTML:crow.childNodes[col-1].childNodes[0].value;
		}else{
		  tmp1 = crow.childNodes[col-1].innerHTML;
		  while (tmp1.indexOf('&amp;')>0){
		      tmp1=tmp1.replace('&amp;','&');
		  }
		  while (tmp1.indexOf('&gt;')>0){
		      tmp1=tmp1.replace('&gt;','>');
		  }
		  while (tmp1.indexOf('&lt;')>0){
		      tmp1=tmp1.replace('&lt;','<');
		  }
		  return tmp1;
			//return crow.childNodes[col-1].innerHTML;
		}
	}
	this.cellsSetValue=function(row,col,p){
		var tbl=document.getElementById('tblgrid_'+id);
		var crow=tbl.rows[row-1];
		crow.childNodes[col-1].innerHTML=p;
	}
	this.getRowId=function(row){
		var tbl=document.getElementById('tblgrid_'+id);
		var crow=tbl.rows[row-1];
		if(crow==undefined){
		  return '';
		}
		else{
		  return crow.id.substr(id.length+4,crow.id.length-4);
		}
	}
	this.setPage=function(p){
		if (p>0){
			this.grid.page=p;
		}
	}
	this.getMaxPage=function(){
		return document.getElementById(id).maxpage;
	}
	this.getPage=function(){
		return document.getElementById(id).page;
	}
	this.getSorting=function(){
		return document.getElementById(id).sorting;
	}
	this.getFilter=function(){
		return document.getElementById(id).filter;
	}
	this.getFilter=function(){
		return document.getElementById(id).filter;
	}
	this.baseURL=function(url){
		this.URL=url;
	}
	this.Init=function(){
		//alert(this.constructor);
		this.loadURL(this.URL,"","GET");
	}
	this.setIDPaging=function(str){
		var p="<img src='"+this.ImgPath+"/page_first.gif' border='0' width='30' height='30' style='cursor:pointer' title='Halaman Pertama' onClick='document.getElementById(\""+id+"\").page=1;goFilterAndSort(\""+id+"\");'><img src='"+this.ImgPath+"/page_prev.gif' border='0' width='30' height='30' style='cursor:pointer' title='Halaman Sebelumnya' onClick='if (document.getElementById(\""+id+"\").page>1){document.getElementById(\""+id+"\").page=document.getElementById(\""+id+"\").page-1;goFilterAndSort(\""+id+"\");}'><img src='"+this.ImgPath+"/page_next.gif' border='0' width='30' height='30' style='cursor:pointer' title='Halaman Berikutnya' onClick='if (document.getElementById(\""+id+"\").page<document.getElementById(\""+id+"\").maxpage){document.getElementById(\""+id+"\").page=document.getElementById(\""+id+"\").page+1;goFilterAndSort(\""+id+"\");}'><img src='"+this.ImgPath+"/page_last.gif' border='0' width='30' height='30' style='cursor:pointer' title='Halaman Terakhir' onClick='document.getElementById(\""+id+"\").page=document.getElementById(\""+id+"\").maxpage;goFilterAndSort(\""+id+"\");'>";
		//alert(p);
		this.IDPaging=str;
		document.getElementById(str).appendChild(this.objpaging);
		document.getElementById(str).childNodes[0].childNodes[0].childNodes[0].childNodes[2].innerHTML = p;
	}
	this.setImgPath=function(str){
		this.ImgPath=str;
	}
	this.attachEvent=function(ev, catcher){
		if (ev=="onRowClick")
			this.onRowClick=catcher;
		else if (ev=="onRowDblClick")
			this.onRowDblClick=catcher;
	}
	this.onLoaded=function(catcher){
		document.getElementById(id).ev=catcher;
	}

	var cell,dt,clsname;
	this.loadURL=function(vUrl,vForm,vMethod){
		var p=ReqXML();
		var q,r,alg,onclicke,ondoubleclicke,idpage,typecell;
		var lstData=this.grid.tmpData;
	//alert(this.cellHeight);
		q=this.cellHeight;
		r=this.ColWidthArr;
		alg=this.cellAlignArr;
		idpage=this.IDPaging;
		typecell=this.cellTypeArr;
		onclicke=(this.onRowClick=="")?"":this.onRowClick+"();";
		ondoubleclicke=(this.onRowDblClick=="")?"":this.onRowDblClick+"();";
		//alert("tes2");
		//_ondoubleclick=this.onRowDoubleClick;
	  if (reqXMLGrd[p].xmlhttp) {
		  //alert("tes3");
		reqXMLGrd[p].available = 0;
		reqXMLGrd[p].xmlhttp.open(vMethod , vUrl, true);
		if (vForm == ""){	
			reqXMLGrd[p].xmlhttp.onreadystatechange = function() {
			  if (typeof(reqXMLGrd[p]) != 'undefined' && 
				reqXMLGrd[p].available == 0 && 
				reqXMLGrd[p].xmlhttp.readyState == 4) {
				  if (reqXMLGrd[p].xmlhttp.status == 200 || reqXMLGrd[p].xmlhttp.status == 304) {
					  	//alert(reqXMLGrd[p].xmlhttp.responseText);
						this.pdata=reqXMLGrd[p].xmlhttp.responseText.split(String.fromCharCode(5));
						//alert(this.pdata[0]+'-'+this.pdata[1]);
						if(this.pdata[1]==String.fromCharCode(4)){
						    if (document.getElementById(id).ev!=""){
							    document.getElementById(id).ev("Error",this.pdata[2]);
						    }
						  
						}
						else{
						    if(lstData != this.pdata[1]){
								document.getElementById(id).tmpData=this.pdata[1];
								document.getElementById(id).maxpage=parseInt(this.pdata[0]);						    
								this.rows=this.pdata[1].split(String.fromCharCode(6));
								//alert(this.rows.length);
								if (this.rows.length>0){
									cell=this.rows[0].split(String.fromCharCode(3));
									document.getElementById(id).selectedRow=1;
									//alert(onclicke);
									dt="<tr id=\""+id+"item"+cell[0]+"\" height=\""+q+"\" lang=\"1\" class=\"GridItemSelected\" onclick=\"ItemTblMClick(this,'"+id+"');"+onclicke+"\" ondblclick=\""+ondoubleclicke+"\" onmouseover=\"ItemTblMOver(this);\" onmouseout=\"ItemTblMOut(this,'"+id+"');\">";
									for (var i=1;i<cell.length;i++){
										//dt+="<td width=\""+r[i-1]+"\" align=\""+alg[i-1]+"\" height=\""+q+"\">"+cell[i]+"</td>";
										dt+="<td width=\""+r[i-1]+"\" align=\""+alg[i-1]+"\">"+((typecell[i-1]=="txt")?cell[i]:"<input type=\"checkbox\" value=\""+cell[i]+"\""+((parseInt(cell[i])==1)?" checked='checked'":"")+" />")+"</td>";
										//alert(typecell[i-1]);
										//dt+="<td width=\""+r[i-1]+"\" align=\""+alg[i-1]+"\" height=\""+q+"\">"+"<input type=\"checkbox\" value=\"1\" />"+"</td>";
									}
									dt+="</tr>";
									for (var i=1;i<this.rows.length;i++){
										cell=this.rows[i].split(String.fromCharCode(3));
										if (i%2) clsname="GridItemEven"; else clsname="GridItemOdd";
										dt+="<tr id=\""+id+"item"+cell[0]+"\" height=\""+q+"\" lang=\""+(i+1)+"\" class=\""+clsname+"\" onclick=\"ItemTblMClick(this,'"+id+"');"+onclicke+"\" ondblclick=\""+ondoubleclicke+"\" onmouseover=\"ItemTblMOver(this);\" onmouseout=\"ItemTblMOut(this,'"+id+"');\">";
										for (var j=1;j<cell.length;j++){
											//dt+="<td width=\""+r[j-1]+"\" align=\""+alg[j-1]+"\" height=\""+q+"\">"+cell[j]+"</td>";
											dt+="<td align=\""+alg[j-1]+"\">"+((typecell[j-1]=="txt")?cell[j]:"<input type=\"checkbox\" value=\""+cell[j]+"\""+((parseInt(cell[j])==1)?" checked='checked'":"")+" />")+"</td>";
										}
										dt+="</tr>";
									}
								}else{
									dt="";
								}
								
								//alert('data:'+dt);
								document.getElementById('tblgrid_'+id).innerHTML = dt;
								if (idpage!=undefined){
								  if (document.getElementById(id).maxpage==0){
									  document.getElementById(id).page=0;	
								  }
								  else if(document.getElementById(id).page==0){
									document.getElementById(id).page=1;
								  }
								  //alert(document.getElementById(idpage).childNodes[0].childNodes[0].childNodes[0].childNodes[0].innerHTML);
								  document.getElementById(idpage).childNodes[0].childNodes[0].childNodes[0].childNodes[0].innerHTML = "Halaman "+document.getElementById(id).page+" dari "+document.getElementById(id).maxpage;
								}
						    }
							if (document.getElementById(id).ev!=""){
								document.getElementById(id).ev("Ok",this.pdata[2]);
							}
						}
				  } else {
						reqXMLGrd[p].xmlhttp.abort();
				  }
				  reqXMLGrd[p].available = 1;
			  }
			}
			
			if (window.XMLHttpRequest) {
			  reqXMLGrd[p].xmlhttp.send(null);
			} else if (window.ActiveXObject) {
			  reqXMLGrd[p].xmlhttp.send();
			}
		}else{
			var params = '';
			for(i = 0; i < vForm.length; i++){
				if (params.length) params += '&';
				params += vForm.elements[i].name + '=' + encodeURI(vForm.elements[i].value);
			}
			reqXMLGrd[p].xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			reqXMLGrd[p].xmlhttp.setRequestHeader('Content-Length', params.length);
			reqXMLGrd[p].xmlhttp.onreadystatechange = function() {
			  if (typeof(reqXMLGrd[p]) != 'undefined' && 
				reqXMLGrd[p].available == 0 && 
				reqXMLGrd[p].xmlhttp.readyState == 4) {
				  if (reqXMLGrd[p].xmlhttp.status == 200 || reqXMLGrd[p].xmlhttp.status == 304) {
						this.pdata=reqXMLGrd[p].xmlhttp.responseText.split(String.fromCharCode(5));
						document.getElementById(id).maxpage=parseInt(this.pdata[0]);
						this.rows=this.pdata[1].split(String.fromCharCode(6));
						//alert(this.rows.length);
						if (this.rows.length>0){
							cell=this.rows[0].split(String.fromCharCode(3));
							document.getElementById(id).selectedRow=1;
							//alert(onclicke);
							dt="<tr id=\""+id+"item"+cell[0]+"\" height=\""+q+"\" lang=\"1\" class=\"GridItemSelected\" onclick=\"ItemTblMClick(this,'"+id+"');"+onclicke+"\" ondblclick=\""+ondoubleclicke+"\" onmouseover=\"ItemTblMOver(this);\" onmouseout=\"ItemTblMOut(this,'"+id+"');\">";
							for (var i=1;i<cell.length;i++){
								//dt+="<td width=\""+r[i-1]+"\" align=\""+alg[i-1]+"\" height=\""+q+"\">"+cell[i]+"</td>";
								dt+="<td width=\""+r[i-1]+"\" align=\""+alg[i-1]+"\">"+((typecell[i-1]=="txt")?cell[i]:"<input type=\"checkbox\" value=\""+cell[i]+"\""+((parseInt(cell[i])==1)?" checked='checked'":"")+" />")+"</td>";
								//alert(typecell[i-1]);
								//dt+="<td width=\""+r[i-1]+"\" align=\""+alg[i-1]+"\" height=\""+q+"\">"+"<input type=\"checkbox\" value=\"1\" />"+"</td>";
							}
							dt+="</tr>";
							for (var i=1;i<this.rows.length;i++){
								cell=this.rows[i].split(String.fromCharCode(3));
								if (i%2) clsname="GridItemEven"; else clsname="GridItemOdd";
								dt+="<tr id=\""+id+"item"+cell[0]+"\" height=\""+q+"\" lang=\""+(i+1)+"\" class=\""+clsname+"\" onclick=\"ItemTblMClick(this,'"+id+"');"+onclicke+"\" ondblclick=\""+ondoubleclicke+"\" onmouseover=\"ItemTblMOver(this);\" onmouseout=\"ItemTblMOut(this,'"+id+"');\">";
								for (var j=1;j<cell.length;j++){
									//dt+="<td width=\""+r[j-1]+"\" align=\""+alg[j-1]+"\" height=\""+q+"\">"+cell[j]+"</td>";
									dt+="<td align=\""+alg[j-1]+"\">"+((typecell[j-1]=="txt")?cell[j]:"<input type=\"checkbox\" value=\""+cell[j]+"\""+((parseInt(cell[j])==1)?" checked='checked'":"")+" />")+"</td>";
								}
								dt+="</tr>";
							}
						}else{
							dt="";
						}
						document.getElementById('tblgrid_'+id).innerHTML = dt;
						if (idpage!=undefined){
							if (document.getElementById(id).maxpage==0){
								document.getElementById(id).page=0;	
							}
							else if(document.getElementById(id).page==0){
							  document.getElementById(id).page=1;
							}
//alert(document.getElementById(idpage).childNodes[0].childNodes[0].childNodes[0].childNodes[0].innerHTML);
							document.getElementById(idpage).childNodes[0].childNodes[0].childNodes[0].childNodes[0].innerHTML = "Halaman "+document.getElementById(id).page+" dari "+document.getElementById(id).maxpage;
						}
				  } else {
						reqXMLGrd[p].xmlhttp.abort();
				  }
				  reqXMLGrd[p].available = 1;
			  }
			}
			reqXMLGrd[p].xmlhttp.send(params);
		}
	  }
	}
	
	this.loadData=function(cdata){
		var q,r,alg,onclicke,ondoubleclicke,idpage,typecell;
	//alert(this.cellHeight);
		q=this.cellHeight;
		r=this.ColWidthArr;
		alg=this.cellAlignArr;
		idpage=this.IDPaging;
		typecell=this.cellTypeArr;
		onclicke=(this.onRowClick=="")?"":this.onRowClick+"();";
		ondoubleclicke=(this.onRowDblClick=="")?"":this.onRowDblClick+"();";
		this.pdata=cdata.split(String.fromCharCode(5));
		document.getElementById(id).maxpage=parseInt(this.pdata[0]);
		this.rows=this.pdata[1].split(String.fromCharCode(6));
		//alert(this.cellHeight);
		if (this.rows.length>0){
			cell=this.rows[0].split(String.fromCharCode(3));
			document.getElementById(id).selectedRow=1;
			//alert(onclicke);
			dt="<tr id=\""+id+"item"+cell[0]+"\" height=\""+q+"\" lang=\"1\" class=\"GridItemSelected\" onclick=\"ItemTblMClick(this,'"+id+"');"+onclicke+"\" ondblclick=\""+ondoubleclicke+"\" onmouseover=\"ItemTblMOver(this);\" onmouseout=\"ItemTblMOut(this,'"+id+"');\">";
			for (var i=1;i<cell.length;i++){
				//dt+="<td width=\""+r[i-1]+"\" align=\""+alg[i-1]+"\" height=\""+q+"\">"+cell[i]+"</td>";
				dt+="<td width=\""+r[i-1]+"\" align=\""+alg[i-1]+"\">"+((typecell[i-1]=="txt")?cell[i]:"<input type=\"checkbox\" value=\""+cell[i]+"\""+((parseInt(cell[i])==1)?" checked='checked'":"")+" />")+"</td>";
				//alert(typecell[i-1]);
				//dt+="<td width=\""+r[i-1]+"\" align=\""+alg[i-1]+"\" height=\""+q+"\">"+"<input type=\"checkbox\" value=\"1\" />"+"</td>";
			}
			dt+="</tr>";
			for (var i=1;i<this.rows.length;i++){
				cell=this.rows[i].split(String.fromCharCode(3));
				if (i%2) clsname="GridItemEven"; else clsname="GridItemOdd";
				dt+="<tr id=\""+id+"item"+cell[0]+"\" height=\""+q+"\" lang=\""+(i+1)+"\" class=\""+clsname+"\" onclick=\"ItemTblMClick(this,'"+id+"');"+onclicke+"\" ondblclick=\""+ondoubleclicke+"\" onmouseover=\"ItemTblMOver(this);\" onmouseout=\"ItemTblMOut(this,'"+id+"');\">";
				for (var j=1;j<cell.length;j++){
					//dt+="<td width=\""+r[j-1]+"\" align=\""+alg[j-1]+"\" height=\""+q+"\">"+cell[j]+"</td>";
					dt+="<td align=\""+alg[j-1]+"\">"+((typecell[j-1]=="txt")?cell[j]:"<input type=\"checkbox\" value=\""+cell[j]+"\""+((parseInt(cell[j])==1)?" checked='checked'":"")+" />")+"</td>";
				}
				dt+="</tr>";
			}
		}else{
			dt="";
		}
		document.getElementById('tblgrid_'+id).innerHTML = dt;
		if (idpage!=undefined){
			//alert(document.getElementById(idpage).childNodes[0].childNodes[0].childNodes[0].childNodes[0].innerHTML);
			if (document.getElementById(id).maxpage==0){
				document.getElementById(id).page=0;	
			}
			document.getElementById(idpage).childNodes[0].childNodes[0].childNodes[0].childNodes[0].innerHTML = "Halaman "+document.getElementById(id).page+" dari "+document.getElementById(id).maxpage;
		}
		//alert(this.ColWidthArr[3]);
	}
}
function CellObject(obj,col){
	this.getValue=function(){
		return obj.childNodes[col-1].innerHTML;
	}
}
function ItemTblMOver(par){
	par.className='GridItemMOver';
}
function ItemTblMOut(par,obj){
	if (par.lang==document.getElementById(obj).selectedRow)
		par.className='GridItemSelected';
	else
		if (par.lang%2) 
			par.className='GridItemOdd';
		else
			par.className='GridItemEven';
}
function ItemTblMClick(par,id){
var tbl=document.getElementById('tblgrid_'+id);
var crow=tbl.rows[document.getElementById(id).selectedRow-1];
	par.className='GridItemSelected';
	if (document.getElementById(id).selectedRow%2)
		crow.className='GridItemOdd';
	else
		crow.className='GridItemEven';
	document.getElementById(id).selectedRow=par.lang;
}