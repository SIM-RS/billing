<?php
session_start();
include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>10 Diagnosis Terbanyak Pasien Rawat Jalan - P. ANAK</title>
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
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
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
    <td colspan="4" align="center" height="50" style="font-size:15px;"><b>Laporan 10 Diagnosis Terbanyak Pasien <?php echo $rwUnit1['nama'] ?> - <?php if($rwUnit2['nama']=="") echo 'Semua'; else echo $rwUnit2['nama'] ?><br />
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
    <td colspan="2" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td width="5%" height="28" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;No</td>
    <td width="10%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;ICD X</td>
    <td width="65%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Diagnosis</td>
    <td width="20%" align="right" style="border-top:1px solid; border-bottom:1px solid;">Jumlah&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <?php
  		if($_REQUEST['StatusPas']!=0)
			$fKso = " AND b_kunjungan.kso_id = ".$_REQUEST['StatusPas'];
		if($_REQUEST['TmpLayanan']==0)
		{ 
			$sqlDiag = "SELECT b_diagnosa_rm.diagnosa_id, b_ms_diagnosa.nama, b_ms_diagnosa.kode,
						(SELECT COUNT(kunjungan_id) FROM b_diagnosa_rm WHERE kunjungan_id = b_kunjungan.id) AS jml
						FROM b_ms_diagnosa
						INNER JOIN b_diagnosa_rm ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id
						INNER JOIN b_pelayanan ON b_pelayanan.id = b_diagnosa_rm.pelayanan_id
						INNER JOIN b_kunjungan ON b_kunjungan.id = b_pelayanan.kunjungan_id
						WHERE b_kunjungan.jenis_layanan = '".$_REQUEST['JnsLayanan']."'
						$fKso
						AND (DATE(b_kunjungan.tgl) BETWEEN '2010-10-01' AND '2010-10-31') 
						ORDER BY jml DESC
						LIMIT 10";
			$rsDiag = mysql_query($sqlDiag);
		}
		else
		{
			$sqlDiag = "SELECT b_diagnosa_rm.diagnosa_id, b_ms_diagnosa.nama, b_ms_diagnosa.kode,
						(SELECT COUNT(kunjungan_id) FROM b_diagnosa_rm WHERE kunjungan_id = b_kunjungan.id) AS jml
						FROM b_ms_diagnosa
						INNER JOIN b_diagnosa_rm ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id
						INNER JOIN b_pelayanan ON b_pelayanan.id = b_diagnosa_rm.pelayanan_id
						INNER JOIN b_kunjungan ON b_kunjungan.id = b_pelayanan.kunjungan_id
						WHERE b_kunjungan.unit_id = '".$_REQUEST['TmpLayanan']."'
						$fKso
						AND (DATE(b_kunjungan.tgl) BETWEEN '2010-10-01' AND '2010-10-31') 
						ORDER BY jml DESC
						LIMIT 10";
			$rsDiag = mysql_query($sqlDiag);
		}
		$no = 1;
		//echo $sqlDiag;
		while($rwDiag = mysql_fetch_array($rsDiag))
		{
  ?>
  <tr>
  	<td>&nbsp;<?php echo $no; ?></td>
	<td>&nbsp;<?php echo $rwDiag['kode']; ?></td>
	<td>&nbsp;<?php echo $rwDiag['nama']; ?></td>
    <td align="right"><?php echo $rwDiag['jml']; ?>&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <?php
  		 $no++;
	}
  ?>
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
	<td colspan="2" align="right">Tgl Cetak: <?=$date_now;?>&nbsp;</td>
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
	<td colspan="2" align="right"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
</table>
</body>
</html>
