<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<title>Form Medik Pasien</title>
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
	  	<td colspan="9" height="30" style="background-color:#008484; color:#A8FFFF"><b>&nbsp;FORM MEDIK PASIEN</b></td>
	  </tr>
	</table>
	<table width="1000" border="0" cellspacing="0" cellpadding="0" class="txtinput" align="center" style="background-color:#A8FFFF">
	  <tr>
	  	<td width="5%">&nbsp;</td>
		<td width="15%">&nbsp;</td>
		<td width="15%">&nbsp;</td>
		<td width="10%">&nbsp;</td>
		<td width="10%">&nbsp;</td>
		<td width="10%">&nbsp;</td>
		<td width="10%">&nbsp;</td>
		<td width="20%">&nbsp;</td>
		<td width="5%">&nbsp;</td>
	  </tr>
	  <tr>
	  	<td>&nbsp;</td>
		<td align="right">Nomer RM &nbsp;</td>
		<td><input name="NoRm" id="NoRm" size="20" /></td>
		<td>&nbsp;</td>
		<td>No Billing &nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="2" align="right">Nama Ortu &nbsp;&nbsp;&nbsp;<input name="NmOrtu" id="NmOrtu" size="25" /></td>
		<td>&nbsp;</td>
		</tr>
	  <tr>
	  	<td>&nbsp;</td>
		<td align="right">Nama &nbsp;</td>
		<td colspan="3"><input name="Nama" id="Nama" size="30" />&nbsp;&nbsp;<input name="carinm" id="carinm" value="Cari" type="button" /></td>
		<td colspan="3" align="right">Alamat &nbsp;&nbsp;<input id="Alamat" name="Alamat" size="45" /></td>
		<td>&nbsp;</td>
		</tr>
	  <tr>
	  	<td>&nbsp;</td>
		<td align="right">Jenis Kelamin &nbsp;</td>
		<td colspan="2"><select name="Gender" id="Gender">
								<option value="L">Laki-Laki</option>
								<option value="P">Perempuan</option></select>&nbsp;Umur</td>
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
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
	  	<td>&nbsp;</td>
		<td colspan="7">
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
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
	  	<td>&nbsp;</td>
		<td>Ruangan</td>
		<td><select></select></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
	  	<td>&nbsp;</td>
		<td>Kelas</td>
		<td><select></select></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="2">Jumlah Hari Rawat &nbsp;&nbsp;&nbsp;<input id="jmlrawat" name="jmlrawat" size="12"/></td>
		<td>&nbsp;</td>
		</tr>
	  <tr>
	  <td>&nbsp;</td>
		<td>Kamar</td>
		<td><select></select></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>Biaya per Hari</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
	  <td>&nbsp;</td>
		<td>Tanggal</td>
		<td colspan="3"><input id="tgl" name="tgl" size="12"/>&nbsp;&nbsp;&nbsp;Jam&nbsp;<input id="jam" name="jam" size="6"/></td>
		<td>&nbsp;</td>
		<td>Total Biaya</td>
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
		<td>&nbsp;</td>
	  </tr>
	  </table>
	  <table width="1000" border="0" cellpadding="0" cellspacing="0" style="background-color:#008484">
	  <tr>
	  	<td>&nbsp;</td>
		<td><input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
		<td>&nbsp;</td>
		<td colspan="4"><input type="button" value="&nbsp;&nbsp;&nbsp;Tambah&nbsp;&nbsp;&nbsp;" />&nbsp;&nbsp;&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Koreksi&nbsp;&nbsp;&nbsp;" />&nbsp;&nbsp;&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Hapus&nbsp;&nbsp;&nbsp;" /></td>
		<td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a></td>
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
	a.setHeader("DATA PASIEN");
	a.setColHeader("TANGGAL,TEMPAT LAYANAN,KAMAR,KELAS,DOKTER,TARIF,HP,BIAYA,JAMINAN,SUBSIDI");
	//a.setIDColHeader(",,NoRM,Kode,Nama,Alamat,Penjamin,dokter,Poli");
	a.setColWidth("75,150,100,120,75,75,75,75,75");
	a.setCellAlign("center,center,center,center,center,center,center,center,center");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowDblClick","tes1");
	a.baseURL("tabel_utils.php?grd1=true");
	a.Init();
</script>
</html>
