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
<title>Setting Aplikasi</title>
</head>

<body>
<div align="center">
<?php
	include("../koneksi/konek.php");
	include("../header1.php");
?>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;FORM SETTING APLIKASI</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="txtinput" align="center">
  <tr>
    <td colspan="7">&nbsp;</td>
  </tr>
  <tr>
    <td width="5%">&nbsp;</td>
    <td width="27%">Penanggung Jawab Lab PK</td>
    <td width="18%"><select><option>ENDANG PURWATY, dr. SpPK</option></select></td>
    <td width="5%">&nbsp;</td>
    <td width="22%">Pemeriksa Lab PK</td>
    <td width="18%"><select><option>ENDANG PURWATY, dr. SpPK</option></select></td>
    <td width="5%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Penanggung Jawab Lab PA</td>
    <td><select><option>RATNA INDRASARI, dr. SpPA</option></select></td>
    <td>&nbsp;</td>
    <td>Pemeriksa Lab PA</td>
    <td><select><option>RATNA INDRASARI, dr. SpPA</option></select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Penanggung Jawab RAD</td>
    <td><select><option>HENDRO SISWANGGONO, dr. SpRad</option></select></td>
    <td>&nbsp;</td>
    <td>Pemeriksa RAD</td>
    <td><select><option>HENDRO SISWANGGONO, dr. SpRad</option></select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Pengganggung Jawab OK</td>
    <td><select><option>AHMAD FAUZI, de. SpBS</option></select></td>
    <td>&nbsp;</td>
    <td>Pemeriksa OK</td>
    <td><select><option>BAMBANG SUDARMANTO, dr. Sp.B</option></select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Penanggung Jawab HD</td>
    <td><select><option></option></select></td>
    <td>&nbsp;</td>
    <td>Pemeriksa HD</td>
    <td><select><option></option></select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Penanggung Jawab Endoscopy</td>
    <td><select><option></option></select></td>
    <td>&nbsp;</td>
    <td>Pemeriksa Endoscopy</td>
    <td><select><option></option></select></td>
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
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td colspan="5">
		<fieldset>
			<input type="checkbox" checked="true" />&nbsp;Melanjutkan No. Rekam Medik terakhir : <input size="32" value="0" /><br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Panjang digit No. Rekam Medik : <input value="7" size="5" />		
		</fieldset>	</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td colspan="5">
		<fieldset>
			<input type="checkbox" checked="checked" />&nbsp;Melanjutkan No. Kuitansi terakhir : <input value="000000" size="32" /><br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Panjang digit No. Kuitansi : <input value="6" size="5" /><br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" />&nbsp;Menggunakan Awalan : <input size="16" /><br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" checked="checked" />&nbsp;Menggunakan Bulan/Tahun : <select><option>BULAN & TAHUN</option></select>
			<fieldset>
				<legend>Preview No Kuitansi Pembayaran</legend>
					<label style="text-align:center; font-size:36px"><b>1007000000</b></label>
			</fieldset>
		</fieldset>	</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td style="color:#FF0000">Keterangan</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Telah ada pasien. Setting Nomor RM tidak dapat diubah.<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Telah ada transaksi pembayaran. Setting Nomor Kuitansi tidak dapat dirubah.</b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr><td colspan="7">&nbsp;</td></tr> <tr><td colspan="7">&nbsp;</td></tr>
   <tr><td colspan="7">&nbsp;</td></tr>
  </table>
  <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
  <tr height="30">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><A href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Batal&nbsp;&nbsp;&nbsp;" /></A>&nbsp;<input  type="button" value="&nbsp;&nbsp;&nbsp;Simpan&nbsp;&nbsp;&nbsp;"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
</body>
</html>
