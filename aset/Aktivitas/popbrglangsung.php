<?
include '../sesi.php';
?>
<script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
<script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
<body>
 <div id="popList" style="display:none; border:5px solid #009933; background-color:white;width:900; height:300" align="center"><br />
<div id="close" align="right" style="padding-right:20px"><img src="../icon/cancel.gif" width="25" onClick="Popup.hide('popList');" style="cursor:pointer" /></div>
<table width="800" align="center" cellpadding="4" cellspacing="0">
<tr>
	<td align="center" colspan="2">
	<select id="CmbStt" name="CmbStt">
	 <option value="1">Iventaris</option>
	 <option value="2">Pakai Habis</option>
	</select>
	</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td><strong>Nama Barang</strong></td>
	<td>
    <input type="hidden" id="txtIdBrg" name="txtIdBrg" />
    <input type="hidden" id="kdBarang" name="kdBarang" />
    <input type="hidden" id="satuanBarang" name="satuanBarang"/>
    <input type="text" id="nmBarang" name="nmBarang" size="80" onKeyUp="list1(event,this);" autocomplete="off" onClick="this.value=''"  /> </td>
	
</tr>
<tr>
	<td>&nbsp;</td>
	<td><center><div id="divobat" align="center" style="z-index:1; width: 751px; left: 419px; top: 588px; height: 300px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div></center><!--button type="button" id="pilih" name="pilih" style="cursor:pointer" onclick="bla()">Pilih</button--></td>
</tr>
</table>
</div>
</body>
<script language="javascript">
function nol(){
document.getElementById("nmBarang").value=''
}
/*var RowIdx;
var fKeyEnt;
var cmb=document.getElementById("CmbStt").value;
function list(e,par){
var keywords=par.value;//alert(keywords);
var tbl = document.getElementById('tblJual');
var jmlRow = tbl.rows.length;
var i;
if (jmlRow > 4){
	i=par.parentNode.parentNode.rowIndex-2;
}else{
	i=0;
}
	if(keywords==""){
		document.getElementById('divobat').style.display='none';
	}else{
		var key;
		if(window.event) {
		  key = window.event.keyCode; 
		}
		else if(e.which) {
		  key = e.which;
		}
		//alert(key);
		if (key==38 || key==40){
			var tblRow=document.getElementById('tblObat').rows.length;
			if (tblRow>0){
				//alert(RowIdx);
				if (key==38 && RowIdx>0){
					RowIdx=RowIdx-1;
					document.getElementById(RowIdx+1).className='itemtableReq';
					if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
				}else if (key==40 && RowIdx<tblRow){
					RowIdx=RowIdx+1;
					if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
					document.getElementById(RowIdx).className='itemtableMOverReq';
				}
			}
		}else if (key==13){
			if (RowIdx>0){
				if (fKeyEnt==false){
					ValNama(document.getElementById(RowIdx).lang);
				}else{
					fKeyEnt=false;
				}
			}
		}else if (key!=27 && key!=37 && key!=39){
			RowIdx=0;
			fKeyEnt=false;
			Request('list_barang.php?aKeyword='+keywords+'&cmb='+document.getElementById("CmbStt").value+"&no="+i, 'divobat', '', 'GET' );
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';
		}
	}
}
function ValNama(par){
//var sisipan=par.split("|");
/*document.getElementById("txtIdBrg").value=sisipan[1];
document.getElementById("kdBarang").value=sisipan[2];
document.getElementById("nmBarang").value=sisipan[3];
document.getElementById("satuanBarang").value=sisipan[4];
if(par!=""){
	alert(par)
    var cdata=par.split("|");
    var tbl = document.getElementById('tblJual');
    var tds;
    var baris = tbl.rows.length;
    if ((cdata[0]*1)==0){
    	if(baris==4){
    		document.forms[0].obatid.value=cdata[1];
			document.forms[0].txtObat.value=cdata[3];
    		document.forms[0].satuan.value=cdata[4];
    		tds = tbl.rows[3].getElementsByTagName('td');
    		}else{
    		document.forms[0].obatid[(cdata[0]*1)-1].value=cdata[1];
    		document.forms[0].txtObat[(cdata[0]*1)-1].value=cdata[3];
    		document.forms[0].satuan[(cdata[0]*1)-1].value=cdata[4];
    		tds = tbl.rows[(cdata[0]*1)+3].getElementsByTagName('td');
    		}
    }else{
    	var w;
    	document.forms[0].obatid[(cdata[0]*1)].value=cdata[1];
    	document.forms[0].txtObat[(cdata[0]*1)].value=cdata[3];
    	document.forms[0].satuan[(cdata[0]*1)].value=cdata[4];
    	tds = tbl.rows[(cdata[0]*1)+3].getElementsByTagName('td');
    	document.forms[0].satuan[(cdata[0]*1)-1].focus();
    
    }
    document.getElementById('divobat').style.display='none';
    }
	Popup.hide('popList');
}
function bla(){
	 /*var tbl = document.getElementById('tblJual');
	 var baris = tbl.rows.length;
     var tds;
	 tds = tbl.rows[3].getElementsByTagName('td');
	if(baris==4){ 
		document.getElementById("obatid").value=document.getElementById("txtIdBrg").value;
		tds[1].innerHTML=document.getElementById("kdBarang").value;
		document.getElementById("txtObat").value=document.getElementById("nmBarang").value;
		document.getElementById("satuan").value=document.getElementById("satuanBarang").value;
		Popup.hide('popList');
	}else{
		document.forms[0].obatid[(sisipa[0]*1)-1].value=document.getElementById("txtIdBrg").value;
		document.forms[0].txtObat[(cdata[0]*1)-1].value=document.getElementById("nmBarang").value;
		document.forms[0].satuan[(cdata[0]*1)-1].value=document.getElementById("satuanBarang").value;
		tds = tbl.rows[(cdata[0]*1)+3].getElementsByTagName('td');
	}
}*/
</script>
