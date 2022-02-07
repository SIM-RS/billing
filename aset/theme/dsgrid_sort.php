<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body{
	margin:0;
}
.itemtable {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-align: left;
	background-color: #E5E5E5;
	cursor:pointer;
}
.itemtableMOver {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	text-align: left;
	background-color: #ADA68D;
	cursor:pointer;
}
-->
</style>
</head>
<script>
var gfSelf=parent.document.getElementById(self.name);
var icntt=0;
var pname;
var pinp='';
var cntmax=5;
var grd;
parent.ifPop=parent.frames[self.name];

function CountFr(){
	icntt=icntt+1;
	if (icntt>cntmax){
		fHideFr();
	}else{
		setTimeout("CountFr()",1000);
	}
}

function ReloadFr(pc){
	if (gfSelf.style.visibility=="hidden"){
		CallFr(pc);
	}
	gfSelf.src='dsgrid_sort.php';
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
	if (gfSelf.style.visibility=="visible"){
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
  with (gfSelf.style) {
  	left=parseInt(p[0])-1-pc.parentNode.parentNode.parentNode.parentNode.scrollLeft + 'px';
	top =parseInt(p[1])+pc.offsetHeight+1 + 'px';
	//top =p[1];
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
  with (gfSelf.style) {
	visibility="hidden";
	top=parseInt(top)-10; // for nn6 bug
  }
}
function SetSort(q){
	fHideFr();
	parent.document.getElementById(grd).sorting=q;
	parent.document.getElementById(grd).page=1;
	parent.document.getElementById(grd).selectedRow=1;
	parent.goFilterAndSort(grd);
}
function SetFilter(p){
	fHideFr();
	parent.document.getElementById(grd).filter=p;
	parent.document.getElementById(grd).page=1;
	parent.document.getElementById(grd).selectedRow=1;
	parent.goFilterAndSort(grd);
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
			SetFilter(pname+'|'+document.getElementById('tflt').value);
		}else{
			alert('Masukkan Filter Terlebih Dahulu');
		}
	}
}
</script>
<body>
<div id="srt" style="display:block">
<table width="130" height="72" cellpadding="0" cellspacing="0" border="0">
	<tr class="itemtable" onMouseOver="icntt=0;this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" onClick="SetSort(pname+' asc')">
		<td>&nbsp;<img src="sort/sortascending.gif" border="0" width="16" height="16"></td>
		<td>&nbsp;</td>
		<td><i>Sort Ascending</i></td>
	</tr>
	<tr class="itemtable" onMouseOver="icntt=0;this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" onClick="SetSort(pname+' desc')">
		<td>&nbsp;<img src="sort/sortdescending.gif" border="0" width="16" height="16"></td>
		<td>&nbsp;</td>
		<td><i>Sort Descending</i></td>
	</tr>
	<tr class="itemtable" onMouseOver="icntt=0;this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" onClick="icntt=0;cntmax=15;document.getElementById('srt').style.display='none';document.getElementById('tflt').value='';document.getElementById('flt').style.display='block';document.getElementById('tflt').focus();">
		<td>&nbsp;<img src="sort/addfilter.gif" border="0" width="16" height="16"></td>
		<td>&nbsp;</td>
		<td><i>Filter...</i></td>
	</tr>
	<tr class="itemtable" onMouseOver="icntt=0;this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" onClick="if (parent.document.getElementById(grd).filter!=''){SetFilter('')}else{fHideFr()}">
		<td>&nbsp;<img src="sort/removefilter.gif" border="0" width="16" height="16"></td>
		<td>&nbsp;</td>
		<td><i>Remove Filter</i></td>
	</tr>
</table>
</div>
<div id="flt" style="display:none">
<table width="130" height="72" cellpadding="0" cellspacing="0" border="0">
	<tr class="itemtable">
		<td id="tdsbj" align="center">&nbsp;</td>
	</tr>
	<tr class="itemtable">
		<td align="center"><input name="tflt" type="text" id="tflt" size="10" style="text-align:center" onKeyUp="fFilter(event,this)"></td>
	</tr>
	<tr class="itemtable">
		
      <td align="center"><img src="sort/find.png" border="0" width="16" height="16" title="Filter Data" style="cursor:pointer" onClick="if (document.getElementById('tflt').value!=''){SetFilter(pname+'|'+document.getElementById('tflt').value)}else{alert('Masukkan Filter Terlebih Dahulu')}">&nbsp;&nbsp;&nbsp;&nbsp;<img src="sort/back.gif" border="0" width="16" height="16" title="Batal" style="cursor:pointer" onClick="fHideFr()"></td>
	</tr>
</table>
</div>
</body>
</html>
