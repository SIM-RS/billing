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
<title>Setting Tarif Tindakan Harian</title>
<script>
function setTempat(val){	
	if(val=='1')
	{		
		document.getElementById('cmbTempat').innerHTML=
		'<option>-option-</option>';
	}
	else if(val=='2')
	{
		document.getElementById('cmbTempat').innerHTML=
		'<option>ENDOSCOPY</option>';
	}
	else if(val=='3')
	{
		document.getElementById('cmbTempat').innerHTML=
		'<option>-option-</option>';
	}
	else if(val=='4')
	{
		document.getElementById('cmbTempat').innerHTML=
		'<option>HEMODIALISA</option>';
	}
	else if(val=='5')
	{
		document.getElementById('cmbTempat').innerHTML=
		'<option>KONSULTASI</option>';
	}
	else if(val=='6')
	{
		document.getElementById('cmbTempat').innerHTML=
		'<option>FAECES</option>'+
		'<option>HEMATOLOGI</option>'+
		'<option>IMMUNOLOGI/SEROLOGI</option>'+
		'<option>KIMIA KLINIK</option>'+
		'<option>LABORATORIUM PA</option>'+
		'<option>MIKROBIOLOGI</option>'+
		'<option>URINE</option>';
	}
	else if(val=='7')
	{
		document.getElementById('cmbTempat').innerHTML=
		'<option>-option-</option>';
	}
	else if(val=='8')
	{
		document.getElementById('cmbTempat').innerHTML=
		'<option>OBAT</option>';
	}
	else if(val=='9')
	{
		document.getElementById('cmbTempat').innerHTML=
		'<option>BEDAH SYARAF</option>'+
		'<option>KEL. KHUSUS</option>'+
		'<option>KELOMPOK 1</option>'+
		'<option>KELOMPOK 2</option>'+
		'<option>KELOMPOK 3</option>'+
		'<option>OPERASI MINOR</option>';
	}
	else if(val=='10')
	{
		document.getElementById('cmbTempat').innerHTML=
		'<option>KEPALA</option>'+
		'<option>USG</option>'+
		'<option>THORAX</option>'+
		'<option>BOF/VERTEBRAE/PELVIS</option>'+
		'<option>PEMERIKSAAN DENGAN KONTRAS</option>';
	}
	else if(val=='11')
	{
		document.getElementById('cmbTempat').innerHTML=
		'<option>BEDAH SYARAF</option>'+
		'<option>INTENSIVE CARE</option>'+
		'<option>KEDOKTERAN KEHAKIMAN</option>'+
		'<option>KEL. KHUSUS</option>'+
		'<option>KELOMPOK 1</option>'+
		'<option>KELOMPOK 2</option>'+
		'<option>KELOMPOK 3</option>'+
		'<option>KELOMPOK KHUSUS</option>';
	}
	else if(val=='12')
	{
		document.getElementById('cmbTempat').innerHTML=
		'<option>VISITE</option>';
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
		<td height="30">&nbsp;FORM SETTING TARIF TINDAKAN HARIAN</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="txtinput">
   
  <tr>
    <td colspan="6" height="20">&nbsp;</td>
  </tr>
  <tr>
	<td width="5%"></td>
    <td align="right" width="20%">Klasifikasi&nbsp;</td>
    <td width="25%">&nbsp;<select onchange="setTempat(this.value)">
	<option></option>
	<option value="1">AHP</option>
	<option value="2">Endoscopy</option>
	<option value="3">Fooding</option>
	<option value="4">Hemodialisa</option>
	<option value="5">Konsultasi</option>
	<option value="6">Laboratorium</option>
	<option value="7">Lain-Lain</option>
	<option value="8">Obat</option>
	<option value="9">OK</option>
	<option value="10">Radiologi</option>
	<option value="11">Tindakan</option>
	<option value="12">Visite</option>
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
	<td></td>
    <td align="right">Kelompok&nbsp;</td>
    <td>&nbsp;<select id='cmbTempat'><option></option></select></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
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
				<td width="45%">
					<div id="gridbox" style="width:425px; height:250px; background-color:white; overflow:hidden;"></div>
		<div id="paging" style="width:425px;"></div>
				</td>
				<td width="10%" align="center">
				<input type="submit" value="&nbsp;&nbsp;&nbsp;&nbsp;> 1&nbsp;&nbsp;&nbsp;&nbsp;" />
				<br />
				<input type="submit" value="&nbsp;&nbsp;&nbsp;>> 2&nbsp;&nbsp;&nbsp;" />
				<br />
				<input type="submit" value="&nbsp;&nbsp;&nbsp;&nbsp;< 3&nbsp;&nbsp;&nbsp;&nbsp;" />
				<br />
				<input type="submit" value="&nbsp;&nbsp;&nbsp;<< 4&nbsp;&nbsp;&nbsp;" />	</td>
				<td width="45%">
					<div id="gridbox1" style="width:425px; height:250px; background-color:white; overflow:hidden;"></div>
		<div id="paging1" style="width:425px;"></div>
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
