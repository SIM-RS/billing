<?php
session_start();
include "../sesi.php";
?>
<?php
	include ("../koneksi/konek.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Pola Kematian Rawat Inap :.</title>
</head>

<body>
<table align="center" width="900" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3" align="center" style="font-weight:bold">POLA KEMATIAN RAWAT INAP </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" style="font-weight:bold; border:#000000 1px solid">Pola Kematian Menurut Diagnosis</td>
  </tr>
  <tr>
    <td width="300" style="border-left:#000000 1px solid; border-right:#000000 1px solid;">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" style="font-weight:bold; border-bottom:#000000 1px solid; border-right:#000000 1px solid" width="11%">No</td>
				<td align="center" style="font-weight:bold; border-bottom:#000000 1px solid;" width="89%">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid" width="11%">&nbsp;</td>
				<td align="left" style=" border-bottom:#000000 1px solid;" width="89%">&nbsp;</td>
			</tr>
		</table>
	</td>
    <td style="border-right:#000000 1px solid">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" style="font-weight:bold; border-bottom:#000000 1px solid; border-right:#000000 1px solid" width="11%">No</td>
				<td align="center" style="font-weight:bold; border-bottom:#000000 1px solid;" width="89%">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid" width="11%">&nbsp;</td>
				<td align="left" style="border-bottom:#000000 1px solid;" width="89%">&nbsp;</td>
			</tr>
		</table>
	</td>
    <td style="border-right:#000000 1px solid">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" style="font-weight:bold; border-bottom:#000000 1px solid; border-right:#000000 1px solid" width="11%">No</td>
				<td align="center" style="font-weight:bold; border-bottom:#000000 1px solid;" width="89%">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid" width="11%">&nbsp;</td>
				<td align="left" style="border-bottom:#000000 1px solid;" width="89%">&nbsp;</td>
			</tr>
		</table>
	</td>
  </tr>
</table>
</body>
</html>
<?php 
mysql_close($konek);
?>