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
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<title>Tarif</title>
</head>

<body>
<div align="center">
<?php
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
		<td height="30">&nbsp;FORM TARIF</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="txtinput">
 	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
  <tr>
	<td width="5%"></td>
    <td width="60%">&nbsp;</td>
    <td width="30%">Klasifikasi Tarif&nbsp;<select>
	<option></option>
	<option>Endoscopy</option>
	<option>Hemodialisis</option>
	<option>Konsultasi</option>
	<option>Laboratorium</option>
	<option>Obat</option>
	<option>OK</option>
	<option>Radiologi</option>
	<option>Retribusi</option>
	<option>Tempat Tidur</option>
	<option>Tindakan</option>
	<option>Visite</option>
	</select></td>
    <td width="5%"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td colspan="2">				
		<div id="gridbox" style="width:925px; height:350px; background-color:white; overflow:hidden;"></div>
		<div id="paging" style="width:925px;"></div>
	</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td>Nama Kelompok Layanan&nbsp;&nbsp;&nbsp;<input size="50" /></td>
    <td><input type="button" disabled value="&nbsp;&nbsp;&nbsp;< 1&nbsp;&nbsp;&nbsp;">&nbsp;<a href="tarif2.php"><input type="button" value="&nbsp;&nbsp;&nbsp;> 2&nbsp;&nbsp;&nbsp;"></a></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
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
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
  <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
  <tr height="30">
	<td>&nbsp;</td>
   	<td><input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Tambah&nbsp;&nbsp;&nbsp;" />&nbsp;&nbsp;&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Koreksi&nbsp;&nbsp;&nbsp;" />&nbsp;&nbsp;&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Hapus&nbsp;&nbsp;&nbsp;" /></td>
		<td align="right"><input type="button" value="&nbsp;&nbsp;&nbsp;Cetak&nbsp;&nbsp;&nbsp;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Selesai&nbsp;&nbsp;&nbsp;" /></a></td>
	<td>&nbsp;</td>
  </tr>
</table>
</div>
</body>
<script>
function goFilterAndSort(grd){
	//alert(grd);
	if (grd=="gridbox"){
		//alert("tabel_utils.php?grd1=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
		a.loadURL("tabel_utils.php?grd1=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
	}/*else if (grd=="gridbox1"){
		//alert("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
		b.loadURL("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
	}*/
}
var a=new DSGridObject("gridbox");
a.setHeader("KELOMPOK LAYANAN");	
a.setColHeader("NAMA KELOMPOK LAYANAN");
//a.setIDColHeader(",,NoRM,Kode,Nama,Alamat,Penjamin,dokter,Poli");
a.setColWidth("500");
a.setCellAlign("center");
a.setCellHeight(20);
a.setImgPath("../icon");
a.setIDPaging("paging");
a.attachEvent("onRowDblClick","tes1");
a.baseURL("tabel_utils.php?grd1=true");
a.Init();
</script>
</html>
