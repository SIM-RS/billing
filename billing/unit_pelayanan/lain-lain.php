<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<title>Form Transaksi Lain</title>
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
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
		 <tr>
	  	<td height="30" style="background-color:#008484; color:#A8FFFF"><b>&nbsp;FORM TRANSAKSI LAIN</b></td>
	  </tr>
	</table>
    <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="txtinput">
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
  <tr>
  <td width="5%">&nbsp;</td>
    <td colspan="6" height="30"><input type="checkbox" id="chck" name="chck" checked="true" />&nbsp;Filter Tanggal&nbsp;:&nbsp;<input id="tglawl" name="tglawl" value="13/07/2010" size="12"/>&nbsp;s/d&nbsp;<input id="tglakhr" name="tglakhr" value="13/07/2010" size="12"/></td>
	<td width="5%">&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="8">&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td colspan="6">
		<div id="gridbox" style="width:925px; height:350px; background-color:white; overflow:hidden;"></div>
				<div id="paging" style="width:925px;"></div>
				</td>
					<td>&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="8">&nbsp;</td>
  </tr>
  <tr>
  	<td width="5%">&nbsp;</td>
    <td width="15%">&nbsp;No Billing</td>
    <td width="27">&nbsp;</td>
    <td width="5%">&nbsp;</td>
    <td width="15%">Total Biaya</td>
    <td width="15%" align="right">0</td>
    <td width="13%" align="right"></td>
	<td width="5%">&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td>&nbsp;Nama</td>
    <td><input id="nama" name="nama" size="30" /></td>
    <td>&nbsp;</td>
    <td>Jumlah Uang Diterima</td>
    <td align="right"><input id="dterima" name="dterima" size="24"/></td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td>&nbsp;Alamat</td>
    <td><input id="almt" name="almt" size="30" /></td>
    <td>&nbsp;</td>
    <td>Jumlah Uang Kembali</td>
    <td style="border-top:1px solid" align="right">0</td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td>&nbsp;Tanggal</td>
    <td><input id="tgl" value="&nbsp;/&nbsp;/" size="10" />&nbsp;Jam&nbsp;<input id="jam" name="jam" size="7" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td>&nbsp;Layanan</td>
    <td><select id="layanan" name="layanan"><option></option></select></td>
    <td>&nbsp;</td>
    <td colspan="2" rowspan="2"><fieldset>
	<legend>Tempat Layanan<input type="checkbox" /></legend>
	<br />
	Keterangan&nbsp;&nbsp;&nbsp;<input id="ket" name="ket" size="32" />
	<br />
	</fieldset></td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td>&nbsp;Tarif</td>
    <td><input id="tarif" name="tarif" size="18" /></td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td>&nbsp;Jumlah Layanan</td>
    <td><input id="jmllay" name="jmllay" size="10" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr><td colspan="8">&nbsp;</td></tr>
  <tr><td colspan="8">&nbsp;</td></tr>
  <tr><td colspan="8">&nbsp;</td></tr>
  </table>
    <table width="1000" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#008484">
  <tr>
  		<td><input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
		<td colspan="3"><input type="button" value="&nbsp;&nbsp;&nbsp;Tambah&nbsp;&nbsp;&nbsp;" />&nbsp;&nbsp;&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Koreksi&nbsp;&nbsp;&nbsp;" />&nbsp;&nbsp;&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Hapus&nbsp;&nbsp;&nbsp;" /></td>
		<td colspan="2" align="right"><input type="button" value="&nbsp;&nbsp;&nbsp;Cetak&nbsp;&nbsp;&nbsp;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a></td>
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
	a.setColHeader("NAMA,ALAMAT,TANGGAL,LAYANAN,TARIF,JUMLAH,BIAYA,DIBAYAR,JENIS LAYANAN,TEMPAT LAYANAN,KETERANGAN");
	//a.setIDColHeader(",,NoRM,Kode,Nama,Alamat,Penjamin,dokter,Poli");
	a.setColWidth("120,150,75,120,75,75,75,75,150,150,150");
	a.setCellAlign("center,center,center,center,center,center,center,center,center,center,center");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowDblClick","tes1");
	a.baseURL("tabel_utils.php?grd1=true");
	a.Init();
</script>
</html>
