<?php
session_start();
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<!--dibawah ini diperlukan untuk menampilkan menu dropdown-->
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<title>Setoran Kasir</title>
</head>

<body>
<?php
	include("../koneksi/konek.php");
	include("../header1.php");
?>
<script type="text/JavaScript">
	var arrRange = depRange = [];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
	style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
</iframe>
<iframe height="72" width="130" name="sort"
id="sort"
src="../theme/dsgrid_sort.php" scrolling="no"
frameborder="0"
style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">Setoran Kasir</td>
		
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="tabel" width="900">
	<tr>
		<td><? include 'dt_setoran_kasir.php'; ?></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
                <tr height="30">
                    <td>&nbsp;<!--input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /--></td>
                    <td colspan="6" align="right"><!--a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a-->&nbsp;</td></tr>
            </table>
</div>
</body>
</html>
