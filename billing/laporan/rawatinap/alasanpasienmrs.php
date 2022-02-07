<?php
session_start();
include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Alasan Pasien MRS :.</title>
</head>

<body>
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(b_tindakan_kamar.tgl_in) = '$bln' and year(b_tindakan_kamar.tgl_in) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
		$PeriodeWaktu = "$arrBln[$bln] $thn";
	}
	
	$jenis = $_REQUEST['JnsLayananInapSaja'];
	$tempat = $_REQUEST['TmpLayananInapSaja'];
	
	$q = "SELECT id, nama FROM b_ms_unit WHERE id='$tempat'";
	$s = mysql_query($q);
	$ruang = mysql_fetch_array($s);
?>
<style>
	.jdl{
		border-top:1px solid #000000;
		border-left:1px solid #000000;
		border-bottom:1px solid #000000;
		text-align:center;
		text-transform:uppercase;
		font-weight:bold;
		background-color:#99FF00;
	}
	.jdlKn{
		border-top:1px solid #000000;
		border-left:1px solid #000000;
		border-bottom:1px solid #000000;
		border-right:1px solid #000000;
		text-align:center;
		text-transform:uppercase;
		font-weight:bold;
		background-color:#99FF00;
	}
	.isi{
		border-left:1px solid #000000;
		border-bottom:1px solid #000000;
	}
	.isiKn{
		border-left:1px solid #000000;
		border-bottom:1px solid #000000;
		border-right:1px solid #000000;
	}
	.bwh{
		border-bottom:1px solid #000000;
		border-left:1px solid #000000;
		font-weight:bold;
		background-color:#FFFF00;
	}
	.bwhKn{
		border-bottom:1px solid #000000;
		border-left:1px solid #000000;
		border-right:1px solid #000000;
		font-weight:bold;
		background-color:#FFFF00;
	}
</style>
<table width="700" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td height="100" valign="top" style="font-size:14px; text-transform:uppercase; font-weight:bold; text-align:center;">laporan instalasi rawat inap<br />alasan pasien mrs<br />ruang <?php echo $ruang['nama'];?><br /><?php echo $Periode;?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<tr>
			  <td width="10%" class="jdl">no</td>
				<td width="40%" height="30" class="jdl">uraian</td>
				<td width="25%" class="jdl">&sum;</td>
				<td width="25%" class="jdlKn">Prosentase (%)</td>
			</tr>
			<?php
					$qTot = "SELECT COUNT(b_pelayanan.id) AS jml FROM b_ms_asal_rujukan INNER JOIN b_kunjungan ON b_kunjungan.asal_kunjungan=b_ms_asal_rujukan.id INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id WHERE b_pelayanan.unit_id='$tempat' $waktu";
					$sTot = mysql_query($qTot);
					$wTot = mysql_fetch_array($sTot);
					
					$qJml1 = "SELECT COUNT(b_pelayanan.id) AS jml FROM b_pelayanan INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_unit ON b_ms_unit.id=b_tindakan_kamar.unit_id_asal WHERE b_pelayanan.unit_id='$tempat' AND b_ms_unit.id=115 $waktu";
					$sJm1l = mysql_query($qJml1);
					$wJml1 = mysql_fetch_array($sJm1l);
					
					$qJml2 = "SELECT COUNT(b_pelayanan.id) AS jml FROM b_pelayanan INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_unit ON b_ms_unit.id=b_tindakan_kamar.unit_id_asal WHERE b_pelayanan.unit_id='$tempat' AND b_ms_unit.inap=0 $waktu";
					$sJm12 = mysql_query($qJml2);
					$wJml2 = mysql_fetch_array($sJm12);
					
					$qJml3 = "SELECT COUNT(b_pelayanan.id) AS jml FROM b_pelayanan INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_unit ON b_ms_unit.id=b_tindakan_kamar.unit_id_asal WHERE b_pelayanan.unit_id='$tempat' AND b_ms_unit.inap=1 $waktu";
					$sJm13 = mysql_query($qJml3);
					$wJml3 = mysql_fetch_array($sJm13);
			?>
			<tr>
			  <td align="center" class="isi">1</td>
				<td class="isi" style="padding-left:10px;" height="20">DATANG SENDIRI</td>
				<td class="isi" style="text-align:center;"><?php echo $wJml1['jml']?></td>
				<td class="isiKn" style="text-align:right; padding-right:60px;"><?php if($wJml1==0 || $wJml1=="") echo 0; else echo number_format($wJml1['jml']/$wTot['jml']*100,2,",",".")?>&nbsp;%</td>
			</tr>
			<tr>
			  <td align="center" class="isi">2</td>
				<td class="isi" style="padding-left:10px;" height="20">RUJUKAN</td>
				<td class="isi" style="text-align:center;"><?php echo $wJml2['jml']?></td>
				<td class="isiKn" style="text-align:right; padding-right:60px;"><?php if($wJml2==0 || $wJml2=="") echo 0; else echo number_format($wJml2['jml']/$wTot['jml']*100,2,",",".")?>&nbsp;%</td>
			</tr>
			<tr>
			  <td align="center" class="isi">3</td>
				<td class="isi" style="padding-left:10px;" height="20">PINDAHAN</td>
				<td class="isi" style="text-align:center;"><?php echo $wJml3['jml']?></td>
				<td class="isiKn" style="text-align:right; padding-right:60px;"><?php if($wJml3==0 || $wJml3=="") echo 0; else echo number_format($wJml3['jml']/$wTot['jml']*100,2,",",".")?>&nbsp;%</td>
			</tr>
			<?php $tot = $wJml1['jml'] + $wJml2['jml'] + $wJml3['jml'];?>
			<tr>
			  	<td height="25" colspan="2" style="text-align:center;" class="bwh">TOTAL</td>
				<td class="bwh" style="text-align:center;"><?php echo $tot?></td>
				<td class="bwhKn" style="text-align:right; padding-right:60px;"><?php if($tot==0) echo "0&nbsp;%"; else echo "100&nbsp;%"?></td>
			</tr>
	</table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
