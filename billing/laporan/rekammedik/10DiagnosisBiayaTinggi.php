<?php
session_start();
include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>10 Penyakit Terbanyak Dengan Biaya Tertinggi PP Rawat Jalan - P. ANAK</title>
</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	//echo $arrBln[$tglAwal[1]];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['jnsLay']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['tmptLay']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	
	$sql = "SELECT nama FROM b_ms_unit WHERE id = '".$_REQUEST['tmptLay']."'";
	$rs = mysql_query($sql);
	$rw = mysql_fetch_array($rs);
?>
<table width="925" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
  	<td colspan="4" height="30">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" style="font-size:13px;"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center" height="50" style="font-size:15px;"><b>Laporan 10 Diagnosis Dengan Biaya Tertinggi Rawat Jalan - P. ANAK - Pasien ASKES KOMERSIAL<br />
    Periode <?php echo $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2]?></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right">Yang Mencetak :&nbsp;Administrator SIMRS</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right">Halaman 1 dari 1</td>
  </tr>
  <tr>
    <td width="5%" height="28" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;No</td>
    <td width="10%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;ICD X</td>
    <td width="65%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Diagnosis</td>
    <td width="20%" align="right" style="border-top:1px solid; border-bottom:1px solid;">Jumlah&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;1</td>
	<td>&nbsp;A01.0</td>
	<td>&nbsp;TYPHOID FEVER</td>
    <td align="right">66.900&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;2</td>
	<td>&nbsp;J06.8</td>
	<td>&nbsp;TFA</td>
    <td align="right">20.000&nbsp;</td>
  </tr>
  <tr>
  	<td style="border-bottom:1px solid;">&nbsp;</td>
	<td style="border-bottom:1px solid;">&nbsp;</td>
	<td style="border-bottom:1px solid;">&nbsp;</td>
	<td style="border-bottom:1px solid;">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="2" align="right">Tgl Cetak: <?=$date_now;?></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="2" align="right">Yang Mencetak</td>
  </tr>
  <tr>
  	<td colspan="4" height="50">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="2" align="right"><b>Administrator SIMRS</b></td>
  </tr>
</table>
</body>
</html>
