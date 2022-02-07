<?php 
$file=$_REQUEST["file"];
$idname="";
?>
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
	gfSelf.src='sort.php';
}
function fGetXY(aTag){
  var p=[0,0];
  while(aTag!=null){
  	p[0]+=aTag.offsetLeft;
  	p[1]+=aTag.offsetTop;
  	aTag=aTag.offsetParent;
  }
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
  with (gfSelf.style) {
  	left=p[0]-1;
	top =p[1]+pc.offsetHeight+1;
	//top =p[1];
	visibility="visible";
  }
  //alert(pc.id);
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
	//alert(q);
	//alert(parent.document.getElementById("sorting").value);
	parent.document.getElementById("sorting").value=q;
	parent.document.getElementById("act").value="paging";
	parent.document.form1.submit();
}
function SetFilter(p){
	//alert(p);
	parent.document.getElementById("filter").value=p;
	parent.document.getElementById("act").value="paging";
	parent.document.getElementById("page").value="";
	parent.document.form1.submit();
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
			var x=parent.document.getElementById("filter").value;
			//alert(x+'-------:'+x.indexOf(pname));
			if (x.indexOf(pname)>=0){
				if (x.indexOf("*-*")>0){
					var h=x.split("*-*");
					var s="";
					for (var a=0;a<h.length;a++){
						if (h[a].indexOf(pname)<0){
							s=s+h[a]+'*-*';
						}
					}
					//alert('1');
					SetFilter(s+pname+'|'+document.getElementById('tflt').value);
				}else{
					//alert('2');
					SetFilter(pname+'|'+document.getElementById('tflt').value);
				}
			}else{
				//alert('3');
				if (x!=""){
					//alert('31');
					SetFilter(x+'*-*'+pname+'|'+document.getElementById('tflt').value);
				}else{
					//alert('32');
					SetFilter(pname+'|'+document.getElementById('tflt').value);
				}
//				SetFilter(x+'*-*'+pname+'|'+document.getElementById('tflt').value);
			}
		}else{
			alert('Masukkan Filter Terlebih Dahulu');
		}
	}
}

function fFilterP(){
	if (document.getElementById('tflt').value!=''){
		var x=parent.document.getElementById("filter").value;
		//alert(x+'-------:'+x.indexOf(pname));
		if (x.indexOf(pname)>=0){
			if (x.indexOf("*-*")>0){
				var h=x.split("*-*");
				var s="";
				for (var a=0;a<h.length;a++){
					if (h[a].indexOf(pname)<0){
						s=s+h[a];
					}
				}
				//alert('1');
				SetFilter(s+'*-*'+pname+'|'+document.getElementById('tflt').value);
			}else{
				//alert('2');
				SetFilter(pname+'|'+document.getElementById('tflt').value);
			}
		}else{
			//alert('3');
			if (x!=""){
				//alert('31');
				SetFilter(x+'*-*'+pname+'|'+document.getElementById('tflt').value);
			}else{
				//alert('32');
				SetFilter(pname+'|'+document.getElementById('tflt').value);
			}
//				SetFilter(x+'*-*'+pname+'|'+document.getElementById('tflt').value);
		}
	}else{
		alert('Masukkan Filter Terlebih Dahulu');
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
	<tr class="itemtable" onMouseOver="icntt=0;this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" onClick="icntt=0;cntmax=15;document.getElementById('srt').style.display='none';document.getElementById('flt').style.display='block';document.getElementById('tflt').focus();">
		<td>&nbsp;<img src="sort/addfilter.gif" border="0" width="16" height="16"></td>
		<td>&nbsp;</td>
		<td><i>Filter...</i></td>
	</tr>
	<tr class="itemtable" onMouseOver="icntt=0;this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" onClick="if (parent.document.getElementById('filter').value!=''){SetFilter('')}else{fHideFr()}">
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
		<td align="center"><input name="tflt" type="text" id="tflt" size="10" maxlength="10" style="text-align:center" onKeyUp="fFilter(event,this)"></td>
	</tr>
	<tr class="itemtable">
		
      <td align="center"><img src="sort/find.png" border="0" width="16" height="16" title="Filter Data" style="cursor:pointer" onClick="if (document.getElementById('tflt').value!=''){fFilterP()}else{alert('Masukkan Filter Terlebih Dahulu')}">&nbsp;&nbsp;&nbsp;&nbsp;<img src="sort/back.gif" border="0" width="16" height="16" title="Batal" style="cursor:pointer" onClick="fHideFr()"></td>
	</tr>
</table>
</div>
</body>
</html>
