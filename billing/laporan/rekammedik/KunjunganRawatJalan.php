<?php
session_start();
include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Kunjungan Rawat Jalan - P. ANAK</title>
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
	
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	
	$sqlKso = "SELECT id,nama from b_ms_kso where id = '".$_REQUEST['StatusPas']."'";
	$rsKso = mysql_query($sqlKso);
	$rwKso = mysql_fetch_array($rsKso);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
?>
<table width="925" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="5" style="font-size:13px;"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="center" height="50" style="font-size:15px;"><b>Laporan Kunjungan Berdasarkan Penjamin Pasien <?php if($rwKso['nama']=="") echo 'Semua'; else echo $rwKso['nama'] ?><br />Jenis Layanan <?php echo $rwUnit1['nama'];?>&nbsp;Tempat Layanan <?php echo $rwUnit2['nama'];?>
	<br />
      Periode <?php echo $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2]?></b></td>
  </tr>
  <tr>
    <td colspan="5" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="right">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="40%" height="28" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Status Pasien</td>
    <td width="15%" align="right" style="border-bottom:1px solid; border-top:1px solid;">Kunjungan Baru&nbsp;</td>
    <td width="15%" align="right" style="border-bottom:1px solid; border-top:1px solid;">Kunjungan Lama&nbsp;</td>
    <td width="15%" align="right" style="border-bottom:1px solid; border-top:1px solid;">Jumlah Kunjungan&nbsp;</td>
    <td width="15%" style="border-bottom:1px solid; border-top:1px solid;" align="right">Persentase&nbsp;</td>
  </tr>
  <?php
  		$fKso = '';
		if($_REQUEST['StatusPas']!=0) {
			$fKso = " AND k.kso_id = ".$_REQUEST['StatusPas'];
		}
		if($_REQUEST['TmpLayanan']==0) {
			$fTmp = " k.jenis_layanan = '".$_REQUEST['JnsLayanan']."' ";
		}
		else {
			$fTmp = " k.unit_id = '".$_REQUEST['TmpLayanan']."' ";
		}
  	$sql = "SELECT (SELECT COUNT(id) AS jml FROM b_kunjungan WHERE kso_id = kso.id AND isbaru=1) AS jmlBaru,
			(SELECT COUNT(id) AS jml FROM b_kunjungan WHERE kso_id = kso.id AND isbaru=0) AS jmlLama,
			(SELECT COUNT(id) AS jml FROM b_kunjungan WHERE kso_id = kso.id) AS jml,
			k.isbaru, k.kso_id, kso.nama AS penjamin
			FROM b_ms_pasien p
			INNER JOIN b_kunjungan k ON k.pasien_id = p.id
			INNER JOIN b_ms_kso kso ON kso.id = k.kso_id
			WHERE $fTmp $fKso
			AND (DATE(k.tgl) BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."')
			GROUP BY kso.id, kso.nama";
	$rs = mysql_query($sql);
	$totBr = 0;
	$totLm = 0;
	$totJml = 0;
	$totPros = 0;
	$pros = 0;
	while($row = mysql_fetch_array($rs))
	{
		$totJml = $totJml + $row['jml'];
	}
	$rs=mysql_query($sql);
	while($rw = mysql_fetch_array($rs))
	{
		$totBr = $totBr + $rw['jmlBaru'];
		$totLm = $totLm + $rw['jmlLama'];
		
  ?>
  <tr>
    <td>&nbsp;<?php echo $rw['penjamin'];?></td>
    <td align="right"><?php echo $rw['jmlBaru']; ?>&nbsp;</td>
    <td align="right"><?php echo $rw['jmlLama']; ?>&nbsp;</td>
    <td align="right"><?php echo $rw['jml']; ?>&nbsp;</td>
	<?php
		$pros = number_format(($rw['jml']/$totJml)*100,2,",",".");
		$totPros = number_format(($totJml/$totJml)*100);
	?>
    <td align="right"><?php echo $pros;?>&nbsp;%&nbsp;</td>
  </tr>
  <?php
	}
  ?>
  <tr>
  	<td style="border-bottom:1px solid; border-top:1px solid;" align="right">Total&nbsp;</td>
	<td style="border-bottom:1px solid; border-top:1px solid;" align="right"><?php echo $totBr;?>&nbsp;</td>
	<td style="border-bottom:1px solid; border-top:1px solid;" align="right"><?php echo $totLm;?>&nbsp;</td>
	<td style="border-bottom:1px solid; border-top:1px solid;" align="right"><?php echo $totJml;?>&nbsp;</td>
	<td style="border-bottom:1px solid; border-top:1px solid;" align="right"><?php echo $totPros;?>&nbsp;%&nbsp;</td>
  </tr>
  <tr>
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
	<td colspan="2" align="right">Tgl Cetak: <?php echo $date_now;?><br />Yang Mencetak</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="2" height="50">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="2" align="right"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
</table>
</body>
</html>
