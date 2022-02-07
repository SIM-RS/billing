<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="STYLESHEET" type="text/css" href="mod.css">
</head>
<body>
</body>
<script>
	document.write("<div id=\"DivSort\" style=\"display:block;border:solid 1px;width:130px;height:72px;top:30px;left:30px;position:absolute;\"></div>");
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
	//gfSelf.src='dsgrid_sort.php';
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
/*	parent.document.getElementById(grd).sorting=q;
	parent.document.getElementById(grd).page=1;
	parent.document.getElementById(grd).selectedRow=1;
	parent.goFilterAndSort(grd);*/
}
function SetFilter(p){
	fHideFr();
/*	parent.document.getElementById(grd).filter=p;
	parent.document.getElementById(grd).page=1;
	parent.document.getElementById(grd).selectedRow=1;
	parent.goFilterAndSort(grd);*/
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
	tblCrow.insertCell(0).innerHTML="&nbsp;<img src=\"sort/sortascending.gif\" border=\"0\" width=\"16\" height=\"16\">";
	tblCrow.insertCell(1).innerHTML="&nbsp;";
	tblCrow.insertCell(2).innerHTML="<i>Sort Ascending</i>";
	
	tblCrow=tblsrt.insertRow(1);
	tblCrow.className="divSort";
	tblCrow.onmouseover=function(){icntt=0;this.className='divSortMOver';}
	tblCrow.onmouseout=function(){this.className='divSort';}
	tblCrow.onclick=function(){SetSort(pname+' desc');}
	tblCrow.insertCell(0).innerHTML="&nbsp;<img src=\"sort/sortdescending.gif\" border=\"0\" width=\"16\" height=\"16\">";
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
	tblCrow.insertCell(0).innerHTML="&nbsp;<img src=\"sort/addfilter.gif\" border=\"0\" width=\"16\" height=\"16\">";
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
	tblCrow.insertCell(0).innerHTML="&nbsp;<img src=\"sort/removefilter.gif\" border=\"0\" width=\"16\" height=\"16\">";
	tblCrow.insertCell(1).innerHTML="&nbsp;";
	tblCrow.insertCell(2).innerHTML="<i>Remove Filter</i>";
	
	dvsrt.appendChild(tblsrt);
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
	tblCrow.insertCell(0).innerHTML="<img src=\"sort/find.png\" border=\"0\" width=\"16\" height=\"16\" title=\"Filter Data\" style=\"cursor:pointer\" onClick=\"if (document.getElementById('tflt').value!=''){SetFilter(pname+'|'+document.getElementById('tflt').value)}else{alert('Masukkan Filter Terlebih Dahulu')}\">&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"sort/back.gif\" border=\"0\" width=\"16\" height=\"16\" title=\"Batal\" style=\"cursor:pointer\" onClick=\"fHideFr()\">";
	tblCrow.childNodes[0].align="center";
	
	dvsrt.appendChild(tblsrt);
	document.getElementById("DivSort").appendChild(dvsrt);
</script>
</html>
