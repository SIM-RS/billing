<?php
session_start();
include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Asal Pasien Berdasarkan Tempat Layanan</title>
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
    <td colspan="7" style="font-size:13px;"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
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
    <td colspan="7" align="center" height="50" style="font-size:15px;"><b>Laporan Asal Pasien <?php echo $rwKso['nama'];?><br />Berdasarkan Tempat Layanan <?php echo $rwUnit2['nama'] ?><br />Periode 
<?php echo $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2]?></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" align="right">Tanggal Cetak :&nbsp;<?=$date_now;?>&nbsp;</td>
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
    <td colspan="7">
		<table border="0" cellpadding="0" cellspacing="0" width="925">
			<tr>
				<td>&nbsp;</td>
				<td colspan="2">&nbsp;JUMLAH/CARA MASUK PASIEN</td>
			  </tr>
			  <tr>
				<td width="15%" height="28" style="border-bottom:1px solid;">&nbsp;TEMPAT LAYANAN</td>
				<?php
					$sqlCM = "SELECT k.asal_kunjungan, ar.nama
								FROM b_kunjungan k
								INNER JOIN b_ms_asal_rujukan ar ON ar.id = k.asal_kunjungan
								WHERE k.kso_id = '".$rwKso['id']."' 
								AND k.unit_id = '".$rwUnit2['id']."'
								AND (DATE(k.tgl) BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."')
								GROUP BY ar.nama
								ORDER BY ar.nama";
					$rsCM = mysql_query($sqlCM);
					while($rwCM = mysql_fetch_array($rsCM))
					{
				?>
				<td style="border-left:1px solid; border-top:1px solid; text-align:right; border-bottom:1px solid;"><?php echo $rwCM['nama'];?>&nbsp;</td>
				<?php
					}
				?>
				<td width="10%" style="border-left:1px solid; border-top:1px solid; text-align:right; border-right:1px solid; border-bottom:1px solid;">TOTAL&nbsp;</td>
			  </tr>
			  <tr>
				<td style="border-left:1px solid; border-bottom:1px solid;" height="20">&nbsp;<?php echo $rwUnit2['nama'] ?></td>
			  <?php
			  		$sqlAK = "SELECT k.asal_kunjungan
								FROM b_kunjungan k
								INNER JOIN b_ms_asal_rujukan ar ON ar.id = k.asal_kunjungan
								WHERE k.kso_id = '".$rwKso['id']."' 
								AND k.unit_id = '".$rwUnit2['id']."'
								AND (DATE(k.tgl) BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."')
								GROUP BY k.asal_kunjungan";
					$rsAK = mysql_query($sqlAK);
					$tot=0;
					while($rwAK = mysql_fetch_array($rsAK))
					{ 
						$sqlJml = "SELECT COUNT(k.pasien_id) AS jml, k.asal_kunjungan, k.unit_id
									FROM b_kunjungan k
									WHERE k.asal_kunjungan = '".$rwAK['asal_kunjungan']."'
									AND k.unit_id = '".$rwUnit2['id']."'
									AND k.kso_id = '".$rwKso['id']."' 
									AND (DATE(k.tgl) BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."')";
						$rsJml = mysql_query($sqlJml);
						$rwJml = mysql_fetch_array($rsJml);
				  ?>
				<td style="border-left:1px solid; border-bottom:1px solid; text-align:right;"><?php echo $rwJml['jml'];?>&nbsp;</td>
				<?php 
						$tot=$tot+$rwJml['jml'];
						$jml[$rwAK['asal_kunjungan']]=$jml[$rwAK['asal_kunjungan']]+$rwJml['jml'];
					}
				?>
				<td style="border-left:1px solid; border-bottom:1px solid; text-align:right; border-right:1px solid;"><?=$tot;?>&nbsp;</td>
			  </tr>
			  <tr>
			  <td style="border-left:1px solid; text-align:right; border-bottom:1px solid;" height="20">&nbsp;</td>
			  <?php
			  $qJmlKunj=mysql_query("SELECT k.asal_kunjungan FROM b_kunjungan k INNER JOIN b_ms_asal_rujukan ar ON ar.id = k.asal_kunjungan WHERE k.kso_id = '".$rwKso['id']."' AND k.unit_id = '".$rwUnit2['id']."' AND (DATE(k.tgl) BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."') GROUP BY k.asal_kunjungan");
			  while($rwJmlKunj=mysql_fetch_array($qJmlKunj)){								
			  ?>
				<td style="border-left:1px solid; text-align:right; border-bottom:1px solid;" height="20"><?php echo $jml[$rwJmlKunj['asal_kunjungan']]?>&nbsp;</td>
			  <?php
			  	$jmlTot=$jmlTot+$jml[$rwJmlKunj['asal_kunjungan']];
			  }
			  ?>
				<td style="border-left:1px solid; text-align:right; border-bottom:1px solid; border-right:1px solid;"><?=$jmlTot;?>&nbsp;</td>
			  </tr>
		</table>	</td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
