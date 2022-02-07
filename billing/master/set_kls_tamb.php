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
<title>Setting Kelas Tambahan</title>
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
		<td height="30">&nbsp;FORM SETTING KELAS TAMBAHAN</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="txtinput"> 
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td width="5%" >&nbsp;</td>
    <td width="20%" align="right">Jenis Layanan :&nbsp;</td>
    <td width="70%">&nbsp;<select>
	<option></option>
	<option value="1">Rawat Jalan</option>
	<option value="2">Rawat Inap</option>
	<option value="3">Rawat Darurat</option>
	<option value="4">Pavilyun</option>
	<option value="5">Laboratorium</option>
	<option value="6">Radiologi</option>
	<option value="7">OK</option>
	<option value="8">Hemodialisis</option>
	<option value="9">Endoscopy</option>
	<option value="10">Peristi</option> 
	</select></td>
    <td width="5%" >&nbsp;</td>
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
		<table width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td width="40%">
				<div id="gridbox" style="width:450px; height:350px; background-color:white; overflow:hidden;"></div>
		<div id="paging" style="width:450px;"></div>
				</td>
				<td width="20%" align="center"><input type="submit" value="&nbsp;&nbsp;&nbsp;> 1&nbsp;&nbsp;&nbsp;" />
		<br />
		<input type="submit" value="&nbsp;&nbsp;&nbsp;< 2&nbsp;&nbsp;&nbsp;" /></td>
				<td width="40%">
					<div id="gridbox1" style="width:450px; height:350px; background-color:white; overflow:hidden;"></div>
		<div id="paging1" style="width:450px;"></div>
				</td>
			</tr>
		</table>
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
  	<td><input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
	<td><input type="button" value="&nbsp;&nbsp;&nbsp;Tambah&nbsp;&nbsp;&nbsp;" />&nbsp;&nbsp;&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Koreksi&nbsp;&nbsp;&nbsp;" />&nbsp;&nbsp;&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Hapus&nbsp;&nbsp;&nbsp;" /></td>
	<td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a></td>
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
	//a.setHeader("TEMPAT LAYANAN");	
	a.setColHeader("NAMA KELAS");
	//a.setIDColHeader(",,NoRM,Kode,Nama,Alamat,Penjamin,dokter,Poli");
	a.setColWidth("300");
	a.setCellAlign("left");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowDblClick","tes1");
	a.baseURL("tabel_utils.php?grd1=true");
	a.Init();
	var b=new DSGridObject("gridbox1");
	//b.setHeader("TEMPAT LAYANAN");	
	b.setColHeader("KELAS TAMBAHAN PER JENIS LAYANAN");	
	//a.setIDColHeader(",,NoRM,Kode,Nama,Alamat,Penjamin,dokter,Poli");
	b.setColWidth("300");
	b.setCellAlign("left");
	b.setCellHeight(20);
	b.setImgPath("../icon");
	b.setIDPaging("paging1");
	b.attachEvent("onRowDblClick","tes1");
	b.baseURL("tabel_utils.php?grd1=true");
	b.Init();
</script>
</html>
