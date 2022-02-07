<?php
session_start();
include "../sesi.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<title>Daftar Pasien Rekam Madik</title>
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
		<td height="30">&nbsp;DAFTAR PASIEN REKAM MEDIK</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="txtinput">
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
  <td width="5%">&nbsp;</td>
    <td width="15%" align="right">Jenis Layanan&nbsp;</td>
    <td width="20%">&nbsp;<select><option>Endoscopy</option>
	<option>Hemodialisis</option>
	<option>Laboratorium</option>
	<option>OK</option>
	<option>Pavilyun</option>
	<option>Peristi</option>
	<option>Radiologi</option>
	<option>Rawat Darurat</option>
	<option>Rawat Inap</option>
	<option>Rawat Jalan</option></select></td>
    <td width="10%">&nbsp;</td>
    <td width="15%" align="right">Nama Pasien&nbsp;</td>
    <td width="15%" align="right">&nbsp;<input size="32" /></td>
    <td width="5%">&nbsp;</td>
	<td width="5%">&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td align="right">Tempat Layanan&nbsp;</td>
    <td>&nbsp;<select><option>Endoscopy</option></select></td>
    <td>&nbsp;</td>
    <td align="right">No RM&nbsp;</td>
    <td align="right">&nbsp;<input size="32" /></td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td align="right">Status Pasien&nbsp;</td>
    <td>&nbsp;<select><option>ANGKASA PURA I, PT</option>
	<option>ARSA DWI NIRMALA, PT</option>
	<option>ASKES KOMERSIAL</option>
	<option>ASKES SOSIAL</option>
	<option>BAYAR SENDIRI</option>
	<option>BHAKSENA, PT</option>
	<option>BHAKTI NADINA, PT</option></select></td>
    <td>&nbsp;</td>
    <td colspan="2" align="right"><input type="checkbox" />      &nbsp;Menampilkan semua data</td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td align="right">Periode&nbsp;</td>
    <td colspan="2">&nbsp;<input size="8" value="14/07/2010" />&nbsp;S/d&nbsp;<input size="8" value="17/07/2010" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td align="right">Jam Awal&nbsp;</td>
    <td colspan="2">&nbsp;<input size="4" value="00:00" />&nbsp;&nbsp;&nbsp;Jam Akhir&nbsp;<input size="4" value="13:46"/></td>
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
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td colspan="6">
		<div id="gridbox" style="width:925px; height:350px; background-color:white; overflow:hidden;"></div>
		<div id="paging" style="width:925px;"></div>
		</td>
	<td>&nbsp;</td>
  </tr>
  <tr><td colspan="8">&nbsp;</td></tr>
  <tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><b>Terdapat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
    <td><b>Kunjungan</b></td>
	<td>&nbsp;</td>
  </tr>
  <tr><td colspan="8">&nbsp;</td></tr>
  <tr><td colspan="8">&nbsp;</td></tr>
  <tr><td colspan="8">&nbsp;</td></tr>
  </table>
  <table width="1000" cellpadding="0" cellspacing="0" border="0" class="hd2">
  <tr height="30">
    <td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"><input type="button" value="&nbsp;&nbsp;&nbsp;Preview&nbsp;&nbsp;&nbsp;" /></td>
    <td align="center"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a></td>
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
	a.setHeader("DATA PASIEN");
	a.setColHeader("NO RM,NAMA PASIEN,ALAMAT,DESA,JENIS LAYANAN,TEMPAT LAYANAN,STATUS PASIEN,KELAS,PETUGAS INPUT,STATUS");
	//a.setIDColHeader(",,NoRM,Kode,Nama,Alamat,Penjamin,dokter,Poli");
	a.setColWidth("50,120,170,120,170,170,120,75,100,100");
	a.setCellAlign("center,center,center,center,left,left,center,center,center,center");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowDblClick","tes1");
	a.baseURL("tabel_utils.php?grd1=true");
	a.Init();
</script>
</html>
