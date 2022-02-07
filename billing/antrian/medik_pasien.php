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
<title>Daftar Antrian Medik Pasien</title>
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
		<td height="30">&nbsp;DAFTAR ANTRIAN MEDIK PASIEN</td>
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
    <td width="15%">&nbsp;<input size="30" /></td>
    <td width="5%">&nbsp;</td>
	<td width="5%">&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td align="right">Tempat Layanan&nbsp;</td>
    <td>&nbsp;<select><option>Endoscopy</option></select></td>
    <td>&nbsp;</td>
    <td align="right">No RM&nbsp;</td>
    <td>&nbsp;<input size="30" /></td>
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
    <td colspan="2" align="right">&nbsp;
      <input type="checkbox" />      &nbsp;Menampilkan semua data
    <input size="8" value="100" /></td>
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
    <td align="right"><b>Menampilkan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
    <td><b>Kunjungan</b></td>
	<td>&nbsp;</td>
  </tr>
  <tr><td colspan="8">&nbsp;</td></tr>
  <tr><td colspan="8">&nbsp;</td></tr>
  <tr><td colspan="8">&nbsp;</td></tr>
  </table>
  <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
  <tr height="30">
    <td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"><input type="button" value="&nbsp;&nbsp;&nbsp;Refresh&nbsp;&nbsp;&nbsp;" /></td>
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
	a.setColHeader("TANGGAL,NO ANTRIAN,NO RM,NAMA PASIEN,ALAMAT,DESA,STATUS PASIEN,TEMPAT LAYANAN,KELAS");
	//a.setIDColHeader(",,NoRM,Kode,Nama,Alamat,Penjamin,dokter,Poli");
	a.setColWidth("75,100,50,120,170,100,120,170,75");
	a.setCellAlign("center,center,center,center,left,left,center,center,center");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowDblClick","tes1");
	a.baseURL("tabel_utils.php?grd1=true");
	a.Init();
</script>
</html>
