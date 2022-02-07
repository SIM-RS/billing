<?php 
include '../sesi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>
        alert('Session anda habis atau anda belum login, silakan login ulang.');
        window.location = '/simrs-tangerang/aset/';
        </script>";
}
include '../koneksi/konek.php'; 
include '../header.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
<script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
<link type="text/css" rel="stylesheet" href="../default.css"/>
<title>.: Barang Inventaris Tak Terkapitalisasi :.</title>
</head>

<body>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<div align="center">
<table width="1000" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td height="40" align="center"> <strong>LAPORAN PENGADAAN BARANG INVENTARIS<br /> 
	  YANG TIDAK TERKAPITALISASI</strong></td>
</tr>
<tr>
	<td align="center">
		<table width="500" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td align="center" height="30">&nbsp;</td>
		</tr>
		<tr>
			<td align="center" height="30">Tanggal Periode&nbsp;:&nbsp;<input type="text" readonly id="tglAwl" name="tglAwl" size="10" value="<?php echo date('d-m-Y') ?>" />&nbsp;<img alt="calender" style="cursor:pointer; vertical-align:middle" border=0 src="../images/cal.gif" onClick="gfPop.fPopCalendar(document.getElementById('tglAwl'),depRange);" />
			&nbsp;&nbsp;s/d&nbsp;&nbsp;<input type="text" id="tglAkhr" readonly name="tglAkhr" size="10" value="<?php echo date('d-m-Y') ?>" />&nbsp;<img alt="calender" style="cursor:pointer; vertical-align:middle" border=0 src="../images/cal.gif" onClick="gfPop.fPopCalendar(document.getElementById('tglAkhr'),depRange);" />&nbsp;&nbsp;<button type="button" id="ctk" name="ctk" onclick="window.location='inventaris_brg_tk_terkapitalisasi.php?tglAwl='+(tglAwl.value)+'&tglAkhr='+(tglAkhr.value)" style="cursor:pointer"><img src="../icon/printButton.jpg" width="20" height="20" style="vertical-align:middle" />&nbsp;&nbsp;Cetak</button></td>
		</tr>
		<tr>
			<td align="center" height="200">&nbsp;</td>
		</tr>
		<tr>
			<td><div><img src="../images/foot.gif" width="1000" height="45"></div></td>
		</tr>

		</table>
	</td>
</tr>
</table>
</div>
</body>
<script language="javascript">
var arrRange=depRange=[];
</script>
</html>
