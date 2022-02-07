<?php
	session_start();
	include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Kinerja Operator Pendaftaran Pasien Baru</title>
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
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
if($_REQUEST['TmpLayanan']!='0'){
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	$fUnit = " AND mu.id=".$_REQUEST['TmpLayanan'];
}else
	$fUnit = " AND mu.parent_id=".$_REQUEST['JnsLayanan'];

if($_REQUEST['StatusPas']!='0'){
	$sqlKso = "SELECT nama FROM b_ms_kso WHERE id=".$_REQUEST['StatusPas'];
	$rsKso = mysql_query($sqlKso);
	$rwKso = mysql_fetch_array($rsKso);
	$fKso = " AND kso_id=".$_REQUEST['StatusPas'];
}
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
?>
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
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
    <td colspan="4" align="center" height="50" style="font-size:15px;"><b>Laporan Kinerja Operator Pendaftaran Pasien Baru<br />Jenis Layanan <?php echo $rwUnit1['nama']?>  Jenis Layanan <?php if($_REQUEST['TmpLayanan']=='0') echo 'Semua'; else echo $rwUnit2['nama']?> Status Pasien <?php if($_REQUEST['StatusPas']=='0') echo 'Semua'; else echo $rwKso['nama']?><br/>
      Periode <?php echo $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2]?></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="15%" style="border-bottom:1px solid; border-top:1px solid; height:28;">&nbsp;</td>
    <td width="35%" style="border-bottom:1px solid; border-top:1px solid; height:28;">&nbsp;<b>NAMA PETUGAS</b></td>
    <td width="35%" align="right" style="border-bottom:1px solid; border-top:1px solid; height:28;"><b>JUMLAH INPUT DATA</b>&nbsp;</td>
    <td width="15%" style="border-bottom:1px solid; border-top:1px solid; height:28;">&nbsp;</td>
  </tr>
  <?php
  	$sqlPet = "SELECT mp.id,mp.nama,COUNT(k.id) jml FROM b_kunjungan k INNER JOIN b_ms_pegawai mp ON k.user_act=mp.id INNER JOIN b_ms_unit mu ON k.unit_id=mu.id WHERE k.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' AND k.isbaru=1 $fKso $fUnit GROUP BY k.user_act";
	$rsPet = mysql_query($sqlPet);
	while($rwPet = mysql_fetch_array($rsPet))
 	{
  ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;<?php echo $rwPet['nama']; ?></td>
    <td align="right"><?php echo $rwPet['jml']; ?>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php
	}
  ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right">Tgl Cetak: <?=$date_now;?>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right">Yang Mencetak&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td height="50">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
</table>
</body>
</html>
