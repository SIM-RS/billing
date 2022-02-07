<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
<script type="text/javascript" src="../theme/js/tab-view.js"></script>

<!-- untuk ajax-->
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<!-- end untuk ajax-->
<title>Setting Diagnosis Tempat Layanan</title>
</head>

<body>
<div align="center">
<?php
	include("../koneksi/konek.php");
	include("../header1.php");
?>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/dsgrid_sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;FORM SETTING DIAGNOSIS PADA TEMPAT LAYANAN</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="txtinput" align="center" height="475">
  <tr>
  	<td>&nbsp;</td>
    <td colspan="3" height="20">&nbsp;</td>
  	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td height="28">&nbsp;</td>
    <td align="right">Jenis Layanan&nbsp;</td>
    <td colspan="2">&nbsp;<select name="JnsLayanan" id="JnsLayanan" class="txtinput" onchange="isiCombo('TmpLayanan',this.value,'','',pilih)"></select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td align="right" height="28">Tempat Layanan&nbsp;</td>
    <td colspan="2">&nbsp;<select name="TmpLayanan" id="TmpLayanan" class="txtinput" onchange="pilih()"></select></td>
    <td>&nbsp;</td>
  </tr>
  <tr><td colspan="5">&nbsp;</td></tr>
  <tr>
  	<td width="5%">&nbsp;</td>
    <td width="40%">
		<div id="gridbox" style="width:425px; height:300px; background-color:white; overflow:hidden;"></div>
		<div id="paging" style="width:425px;"></div>	</td>
    <td width="10%" align="center">
		<input type="button" id="btnRight" value="" onclick="pindahKanan()" class="tblRight"/>
        <br>
		<input type="button" id="btnLeft" value="" onclick="pindahKiri()" class="tblLeft"/>
	</td>
    <td width="40%">
		<div id="gridbox1" style="width:425px; height:300px; background-color:white; overflow:hidden;"></div>
		<div id="paging1" style="width:425px;"></div>	</td>
  	<td width="5%">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  	<td>&nbsp;</td>
  </tr>
  <tr><td colspan="5">&nbsp;</td></tr>
  <tr><td colspan="5">&nbsp;</td></tr>
</table>
  <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
  <tr height="30">
  	<td>&nbsp;<!--<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" />--></td>
	<td align="right"><!--<input type="button" value="&nbsp;&nbsp;&nbsp;Cetak&nbsp;&nbsp;&nbsp;" />--></td>
	<td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a>&nbsp;</td>
  </tr>
</table>
</div>
</body>
<script>
//	setTimeout("isiCombo('JnsLayanan','','','',showTmpLay)",3000);
	isiCombo('JnsLayanan','','','',showTmpLay);
	function showTmpLay()
	{
		isiCombo('TmpLayanan',document.getElementById('JnsLayanan').value,'','',pilih);
	}
	
	function isiCombo(id,val,defaultId,targetId,evloaded)
	{
		if(targetId == '' || targetId == undefined)
		{
			targetId = id;
		}
			Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,id,'','GET',evloaded);
	}
	
	function pilih(p)
	{
		//alert("setDiagnosis_utils.php?grd=1&unitId="+document.getElementById('TmpLayanan').value);
		//a.loadURL("setDiagnosis_utils.php?grd=1&unitId="+document.getElementById('TmpLayanan').value,"","GET");
		if (p!=1){
			//alert("setDiagnosis_utils.php?grd=2&unitId="+document.getElementById('TmpLayanan').value);
			b.loadURL("setDiagnosis_utils.php?grd=2&unitId="+document.getElementById('TmpLayanan').value,"","GET");
		}
	}
	
	var idDiag;
	function ambilData()
	{	
		idDiag = a.getRowId(a.getSelRow());	
		//alert(idDiag);
	}
	
	var idDiagUnit = '';
	function pindahKanan()
	{
		if(document.getElementById('TmpLayanan').value == '' )
		{
			alert('silakan pilih tempat layanan dahulu!');
		}
		else
		{
			for(var i=0;i<a.obj.childNodes[0].rows.length;i++)
			{
				if(a.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked)
				{
					idDiagUnit+=a.getRowId((parseInt(i)+1))+',';	
				}
			}
			//alert(idTin);
			var idUnit=document.getElementById('TmpLayanan').value;
			if(idDiagUnit==''){
				alert("Silakan Pilih Diagnosa !");
			}
			else
			{
				idDiagUnit=idDiagUnit.substr(0,idDiagUnit.length-1);
				//alert("setDiagnosis_utils.php?grd=2&act=tambah&id="+idDiagUnit+"&unitId="+idUnit+"&diagId="+idDiag);
				b.loadURL("setDiagnosis_utils.php?grd=2&act=tambah&id="+idDiagUnit+"&unitId="+idUnit+"&diagId="+idDiag,"","GET");
				//pilih(1);
				idDiagUnit = '';
			}
		}
		
	}
	
	function ambilData2()
	{
		var sisip = b.getRowId(b.getSelRow()).split('|');
		msId = sisip[0];
	}
	
	function pindahKiri(){
		for(var i=0;i<b.obj.childNodes[0].rows.length;i++)
		{
			if(b.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked)
			{
				idDiagUnit+=b.getRowId((parseInt(i)+1))+',';	
			}
		}
		if(idDiagUnit==''){
			alert("Silakan Pilih Diagnosa !");
		}
		else
		{
			idDiagUnit=idDiagUnit.substr(0,idDiagUnit.length-1);
			//alert("setDiagnosis_utils.php?grd=2&act=hapus&id="+idDiagUnit+"&unitId="+document.getElementById('TmpLayanan').value);
			b.loadURL("setDiagnosis_utils.php?grd=2&act=hapus&id="+idDiagUnit+"&unitId="+document.getElementById('TmpLayanan').value,"","GET");
			//pilih(1);
			idDiagUnit = '';
		}
	}
	
	/*function simpan(action,id,cek)
	{
		var idUnit = document.getElementById('TmpLayanan').value
		b.loadURL("setDiagnosis_utils.php?grd=1&act="+action+"&id="+id+"&kode=<?php echo $rw['kode']; ?>&nama="+nama+"&alamat="+almt+"&telp="+telp+"&fax="+fax+"&kontak="+kontak,"","GET");
	}*/
			
	function goFilterAndSort(grd)
	{
		//alert(grd);
		if (grd=="gridbox")
		{			
			a.loadURL("setDiagnosis_utils.php?grd=1&unitId="+document.getElementById('TmpLayanan').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
		}
		else if (grd=="gridbox1")
		{			
			b.loadURL("setDiagnosis_utils.php?grd=2&unitId="+document.getElementById('TmpLayanan').value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
		}
	}
	
	function loadGridA(){
		//alert("a");
		a.loadURL("setDiagnosis_utils.php?grd=1&unitId="+document.getElementById('TmpLayanan').value,"","GET");
	}
	
	var a=new DSGridObject("gridbox");
	var b=new DSGridObject("gridbox1");
	
	//function ShowGrid()
	//{
		a.setHeader("DIAGNOSIS");
		a.setColHeader("<input type='checkbox' id='chk_a' onchange='cek_all(this.id)' />,KODE,NAMA DIAGNOSIS");
		a.setIDColHeader(",kode,nama");
		a.setColWidth("30,75,250");
		a.setCellAlign("center,center,left");
		a.setCellType("chk,txt,txt");
		a.setCellHeight(20);
		a.setImgPath("../icon");
		a.setIDPaging("paging");
		a.attachEvent("onRowClick","ambilData");
		a.baseURL("setDiagnosis_utils.php?grd=1&unitId=0");
		a.Init();
		
		b.setHeader("DIAGNOSIS");
		b.setColHeader("<input type='checkbox' id='chk_b' onchange='cek_all(this.id)' />,KODE,DIAGNOSIS PER TEMPAT LAYANAN");
		b.setIDColHeader(",kode,nama");
		b.setColWidth("30,75,250");
		b.setCellAlign("center,center,left");
		b.setCellType("chk,txt,txt");
		b.setCellHeight(20);
		b.setImgPath("../icon");
		b.setIDPaging("paging1");
		b.attachEvent("onRowClick","ambilData2");
		b.onLoaded(loadGridA);
		b.baseURL("setDiagnosis_utils.php?grd=2&unitId=0");
		b.Init();
	//}
	function cek_all(x){
		if(x=='chk_a'){
			if(document.getElementById(x).checked){
				for(var i=0;i<a.obj.childNodes[0].rows.length;i++){	
					a.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = true;		
				}
			}
			else{
				for(var i=0;i<a.obj.childNodes[0].rows.length;i++){	
					a.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = false;		
				}
			}
		}
		else if(x=='chk_b'){
			if(document.getElementById(x).checked){
				for(var i=0;i<b.obj.childNodes[0].rows.length;i++){	
					b.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = true;		
				}
			}
			else{
				for(var i=0;i<b.obj.childNodes[0].rows.length;i++){	
					b.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = false;		
				}
			}
		}
	}
	//var b;
	//setTimeout('unit()',100);
</script>
</html>
