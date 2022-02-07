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
<title>Setting Tarif Tempat Layanan</title>
<script>
function setTempat(val){	
	if(val=='1')
	{		
		document.getElementById('cmbTempat').innerHTML=
		'<option>P. GIGI & MULUT</option>'+
		'<option>P. JANTUNG</option>'+
		'<option>P. MATA</option>'+
		'<option>P. PARU</option>'+
		'<option>P. BEDAH UMUM</option>';
	}
	else if(val=='2')
	{
		document.getElementById('cmbTempat').innerHTML=
		'<option>MAWAR KUNING</option>'+
		'<option>MAWAR UNGU</option>'+
		'<option>ICCU</option>'+
		'<option>ICU</option>'+
		'<option>ECU KUNING</option>';
	}
	else if(val=='3')
	{
		document.getElementById('cmbTempat').innerHTML=
		'<option>IGD</option>'+
		'<option>MAWAR PINK</option>'+
		'<option>OK IGD</option>'+
		'<option>TRIAGE I</option>'+
		'<option>ICU IGD</option>';
	}
	else if(val=='4')
	{
		document.getElementById('cmbTempat').innerHTML=
		'<option>PAVILYUN</option>'+
		'<option>ALAMANDA BAYI</option>'+
		'<option>ANGGREK BAYI</option>'+
		'<option>CEMPAKA BAYI</option>'+
		'<option>POLI PAVILYUN</option>';
	}
	else if(val=='5')
	{
		document.getElementById('cmbTempat').innerHTML=
		'<option>LAB PA</option>'+
		'<option>LAB PK</option>';
	}
	else if(val=='6')
	{
		document.getElementById('cmbTempat').innerHTML=
		'<option>RADIOLOGI</option>';
	}
	else if(val=='7')
	{
		document.getElementById('cmbTempat').innerHTML=
		'<option>BEDAH CENTRAL</option>';
	}
	else if(val=='8')
	{
		document.getElementById('cmbTempat').innerHTML=
		'<option>HEMODIALISIS (HD)</option>';
	}
	else if(val=='9')
	{
		document.getElementById('cmbTempat').innerHTML=
		'<option>ENDOSCOPY</option>';
	}
	else if(val=='10')
	{
		document.getElementById('cmbTempat').innerHTML=
		'<option>KAMAR BERSALIN</option>'+
		'<option>MAWAR HIJAU</option>'+
		'<option>NICU</option>'+
		'<option>PERISTI</option>'+
		'<option>RUANG ISOLASI BAYI</option>';
	}
	else{
		document.getElementById('cmbTempat').innerHTML='<option>-option-</option>';
	}
}
</script>

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
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="txtinput">
 
  <tr>
    <td colspan="4" height="20">&nbsp;</td>
  </tr>
  <tr>
	<td width="5%"></td>
    <td align="right" width="20%">Jenis Layanan&nbsp;</td>
    <td width="25%">&nbsp;<select onchange="setTempat(this.value)">
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
    <td width="25%" align="right">Kelas&nbsp;</td>
    <td width="20%">&nbsp;<select>
		<option></option>
		<option>ANGGREK</option>
		<option>IGD</option>
		<option>ANGGREK BAYI</option>
		<option>BOUGENVIL BAYI</option>
		<option>BOUGENVILLE</option>
		<option>ALAMANDA</option>
		<option>ALAMANDA BAYI</option>
		<option>CEMPAKA BAYI</option>
	</select></td>
    <td width="5%"></td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td align="right">Tempat Layanan&nbsp;</td>
    <td>&nbsp;<select id='cmbTempat'><option></option></select></td>
    <td align="right">Kelompok Tarif&nbsp;</td>
    <td>&nbsp;<select>
		<option></option>
		<option>BEDAH SYARAF</option>
		<option>INTENSIVE CARE</option>
		<option>KEL KHUSUS</option>
		<option>KELOMPOK 1</option>
		<option>KELOMPOK 2</option>
		<option>KELOMPOK 3</option>
		<option>KELOMPOK KHUSUS</option>
		<option>KONSULTASI</option>
		<option>OBAT</option>
	</select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" height="20">&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td colspan="4">
		<table width="100%" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td width="40%">
					<div id="gridbox" style="width:450px; height:250px; background-color:white; overflow:hidden;"></div>
		<div id="paging" style="width:450px;"></div>
				</td>
				<td width="20%" align="center">
				<input type="submit" value="&nbsp;&nbsp;&nbsp;&nbsp;> 1&nbsp;&nbsp;&nbsp;&nbsp;" />
				<br />
				<input type="submit" value="&nbsp;&nbsp;&nbsp;>> 2&nbsp;&nbsp;&nbsp;" />
				<br />
				<input type="submit" value="&nbsp;&nbsp;&nbsp;&nbsp;< 3&nbsp;&nbsp;&nbsp;&nbsp;" />
				<br />
				<input type="submit" value="&nbsp;&nbsp;&nbsp;<< 4&nbsp;&nbsp;&nbsp;" />	</td>
				<td width="40%">
					<div id="gridbox1" style="width:450px; height:250px; background-color:white; overflow:hidden;"></div>
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
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
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
	a.setColHeader("NAMA KELOMPOK,LAYANAN,KELAS");
	//a.setIDColHeader(",,NoRM,Kode,Nama,Alamat,Penjamin,dokter,Poli");
	a.setColWidth("100,100,100");
	a.setCellAlign("left,center,center");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowDblClick","tes1");
	a.baseURL("tabel_utils.php?grd1=true");
	a.Init();
	
	var b=new DSGridObject("gridbox1");
	//b.setHeader("TEMPAT LAYANAN");	
	b.setColHeader("NAMA KELOMPOK,LAYANAN,KELAS");
	//a.setIDColHeader(",,NoRM,Kode,Nama,Alamat,Penjamin,dokter,Poli");
	b.setColWidth("100,100,100");
	b.setCellAlign("left,center,center");
	b.setCellHeight(20);
	b.setImgPath("../icon");
	b.setIDPaging("paging1");
	b.attachEvent("onRowDblClick","tes1");
	b.baseURL("tabel_utils.php?grd1=true");
	b.Init();
</script>
</html>
