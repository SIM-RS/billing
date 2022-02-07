<?php
session_start();
include "../sesi.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<title>Informasi Pelaksana Layanan</title>
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
		<td height="30">&nbsp;INFORMASI PELAKSANA LAYANAN</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tabel" align="center">
  <tr>
    <td colspan="7">&nbsp;</td>
  </tr>
  <tr>
  	<td width="5%">&nbsp;</td>
    <td width="15%" align="right">Jenis Layanan</td>
    <td width="25%">&nbsp;<select name="JnsLayanan" id="JnsLayanan" tabindex="26" class="txtinput" onchange="isiCombo('TmpLayanan',this.value);loadGrid();"></select></td>
    <td width="10%">&nbsp;</td>
    <td width="20%" align="right">Tempat Layanan</td>
    <td width="20%">&nbsp;<select name="TmpLayanan" id="TmpLayanan" tabindex="27" class="txtinput" onchange="pilih()"></select></td>
  	<td width="5%">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td colspan="5">
		<div id="gridboxPel" style="width:925px; height:350px; background-color:white; overflow:hidden;"></div>
		<div id="pagingPel" style="width:925px;"></div>
		</td>
  	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  	<td>&nbsp;</td>
  </tr>
  </table>
  <!--table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
  <tr height="30">
    <td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a>&nbsp;</td>
  </tr>
</table-->
</div>
</body>
<script>
	isiCombo('JnsLayanan','','','',showTmpLay);
	function showTmpLay(){
		isiCombo('TmpLayanan',document.getElementById('JnsLayanan').value,'','',showTabel);
	}
	
	function loadGrid(){
		setTimeout('showTabel()',100);
	}
	
	function showTabel(){
		a.loadURL("tabel_utils.php?grdPel=true&unitId="+document.getElementById('TmpLayanan').value,"","GET");
	}
	
	function isiCombo(id,val,defaultId,targetId,evloaded)
	{
		if(targetId=='' || targetId==undefined)
		{
			targetId=id;
		}
			Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,id,'','GET',evloaded);
	}
	
	function goFilterAndSort(grd){
		//alert(grd);
		if (grd=="gridboxPel"){
			//alert("tabel_utils.php?grd1=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
			a.loadURL("tabel_utils.php?grdPel=true&unitId="+document.getElementById('TmpLayanan').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
		}
	}
	
	var a=new DSGridObject("gridboxPel");
	a.setHeader("DATA PASIEN");
	a.setColHeader("NAMA,SPESIALISASI,ALAMAT,TELEPON");
	a.setIDColHeader("nama,spesialisasi,,");
	a.setColWidth("150,175,150,100");
	a.setCellAlign("left,left,left,left");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("pagingPel");
	a.attachEvent("onRowClick","tes1");
	//alert("tabel_utils.php?grdPel=true&unitId="+document.getElementById('TmpLayanan').value);
	a.baseURL("tabel_utils.php?grdPel=true&unitId="+document.getElementById('TmpLayanan').value);
	a.Init();
	
	function pilih()
	{
		a.loadURL("tabel_utils.php?grdPel=true&unitId="+document.getElementById('TmpLayanan').value,"","GET");
	}
</script>
</html>
