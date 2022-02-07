<?php
include '../sesi.php';
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
 include '../header.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Laporan Stok Barang Terkini :.</title>
<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
<link href="../default.css" rel="stylesheet" type="text/css">
</head>

<body>
<div align="center">
<table width="1000" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td align="center" height="300">
		<table width="500" align="center" cellpadding="9" cellspacing="0">
		<tr>
			<td class="header" colspan="2">.: Laporan Stok Barang Pakai Habis :. </td>
		</tr>
		<tr height="30">
			<td width="177" class="label">Format Laporan</td>
			<td width="321" class="content">
				&nbsp;
				<select id="typefile" name="typefile">
				  <option value="HTML">HTML</option>
				  <option value="WORD">WORD</option>
				  <option value="XLS">EXCEL</option>
				</select> 
		  </td>
		</tr>
		<tr>
			<td colspan="2" align="center" class="footer"><button type="button" id="ctk" name="ctk" onclick="window.open('daftar_stkBrg_terkini.php?format='+(typefile.value))"><img src="../icon/printer.png" style="vertical-align:middle" />&nbsp;&nbsp;Cetak Laporan</button></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
		<?php
		include '../footer.php';
		?>
	</td>
</tr>
</table>
</div>
</body>
</html>

