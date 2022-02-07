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
<title>Info Aktifitas Petugas</title>
</head>

<body>
<div align="center">
<?php
	include("../koneksi/konek.php");
	include("../header1.php");
?>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;INFO AKTIFITAS PETUGAS</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="txtinput" align="center">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
		<table width="750" align="center">
		<tr><td>
		<fieldset>
			<legend>Kriteria Informasi</legend>
			<table width="500" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="45%" align="right"><select>
						<option></option>
						<option>Harian</option>
						<option>Bulanan</option>
						<option>Tahunan</option>
						<option>Triwulan</option>
						<option>Rentang Waktu</option>
					</select></td>
					<td width="10%">&nbsp;</td>
					<td width="45%"><select>
						<option></option>
					</select></td>
				</tr>
				<tr>
					<td align="right">Periode : <input size="8" value="07/07/2010" /></td>
					<td align="center">s/d</td>
					<td><input size="8" value="14/07/2010" /></td>
				</tr>
				<tr>
					<td colspan="3" height="10">&nbsp;</td>
				</tr>
			</table>
		</fieldset>	
		</td></tr>
		</table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="button" value="&nbsp;&nbsp;&nbsp;Laporan&nbsp;&nbsp;&nbsp;"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
  <tr height="30">
    <td width="50%">&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
    <td width="50%" align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a>&nbsp;</td>
  </tr>
</table>
</div>
</body>
</html>
