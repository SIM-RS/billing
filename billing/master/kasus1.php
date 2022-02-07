<?php
session_start();
include("../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<title>Kasus</title>
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
<table width="1000" border="0" cellpadding="0" cellspacing="" class="hd2">
	<tr>
		<td height="30">&nbsp;FORM DIAGNOSIS ICD</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="1" cellpadding="0" class="txtinput" align="center">
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>  	
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right">Filter&nbsp;&nbsp;&nbsp;<input size="32" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="left">
		<input type="radio" id="rdJns" name="radio" checked="checked" value="0" onclick="layanan(this.value)" />&nbsp;Jenis Layanan<input type="radio" id="rdTmpt" name="radio" value="1" onclick="layanan(this.value)" />&nbsp;Tempat Layanan
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right"><label id="lbl">Jenis Layanan</label>
	</td>
    <td>&nbsp;<select id="cmbLay">
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
		</select>
	</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Kasus&nbsp;</td>
    <td>&nbsp;<input size="24" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td height="30">
		<input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value);" class="tblTambah"/>
		<input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus"/>
		<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>
	</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">
		<div id="gridbox" style="width:925px; height:350px; background-color:white; overflow:hidden;"></div>
		<div id="paging" style="width:925px;"></div>
		</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="5%">&nbsp;</td>
    <td width="35%%">&nbsp;</td>
    <td width="35%">&nbsp;</td>
    <td align="right" width="20%"><input type="button" disabled="disabled"value="&nbsp;&nbsp;&nbsp;< 1&nbsp;&nbsp;&nbsp;">&nbsp;<a href="kasus2.php"><input type="button"  value="&nbsp;&nbsp;&nbsp;> 2&nbsp;&nbsp;&nbsp;"></a></td>
    <td width="5%">&nbsp;</td>
  </tr>
  <tr>
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
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>
   <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
  <tr height="30">
    <td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
		<td>&nbsp;</td>
		<td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a>&nbsp;</td>
  </tr>
</table>
</div>
</body>
<script>
	function layanan(val)
	{	
		if(val=='0')
		{
			document.getElementById('lbl').innerHTML = 'Jenis Layanan';
			document.getElementById('cmbLay').innerHTML = 
				'<option>Rawat Jalan</option>'+
				'<option>Rawat Inap</option>'+
				'<option>Rawat Darurat</option>'+
				'<option>Pavilyun</option>'+
				'<option>Laboratorium</option>'+
				'<option>OK</option>'+
				'<option>Hemodialisis</option>'+
				'<option>Endoscopy</option>'+
				'<option>Peristi</option>';
		}
		else
		{
			document.getElementById('lbl').innerHTML = 'Tempat Layanan';
			document.getElementById('cmbLay').innerHTML = 
				'<option>Bedah Central</option>'+
				'<option>Endoscopy</option>'+
				'<option>Hemodialisis (HD)</option>'+
				'<option>Lab PA</option>'+
				'<option>Lab PK</option>'+
				'<option>Radiologi</option>';
		}
	}
	
	function goFilterAndSort(grd){
		//alert(grd);
		if (grd=="gridbox"){
			//alert("tabel_utils.php?grd1=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
			a.loadURL("tabel_utils.php?grd1=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
		}else if (grd=="gridbox1"){
			//alert("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
			b.loadURL("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
		}
	}
	var a=new DSGridObject("gridbox");
	a.setHeader("DATA KASUS");
	a.setColHeader("LAYANAN,KASUS,KETERANGAN");
	//a.setIDColHeader(",,NoRM,Kode,Nama,Alamat,Penjamin,dokter,Poli");
	a.setColWidth("150,150,150");
	a.setCellAlign("center");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowDblClick","tes1");
	a.baseURL("tabel_utils.php?grd1=true");
	a.Init();

</script>
</html>
