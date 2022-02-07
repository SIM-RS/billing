<?php
session_start();
include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Pasien KRS :.</title>
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
    <td height="100" valign="top" style="font-size:14px; text-transform:uppercase; font-weight:bold; text-align:center;">laporan instalasi rawat inap<br />pasien krs<br />ruang <?php echo $ruang['nama'];?><br /><?php echo $Periode;?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<tr>
			  	<td width="10%" class="jdl">no</td>
				<td width="50%" height="30" class="jdl">uraian</td>
				<td width="40%" class="jdlKn">&sum;</td>
			</tr>
			<?php
					$sql = "SELECT b_ms_cara_keluar.id, b_ms_cara_keluar.nama FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_cara_keluar ON b_ms_cara_keluar.nama=b_pasien_keluar.cara_keluar WHERE b_pelayanan.unit_id='$tempat' $waktu GROUP BY b_ms_cara_keluar.id";
					$rs = mysql_query($sql);
					$no=1;
					$tot = 0;
					while($rw = mysql_fetch_array($rs))
					{
						$qJml = "SELECT b_ms_cara_keluar.id, b_ms_cara_keluar.nama, COUNT(b_pelayanan.id) AS jml FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_cara_keluar ON b_ms_cara_keluar.nama=b_pasien_keluar.cara_keluar WHERE b_pelayanan.unit_id='$tempat' $waktu AND b_ms_cara_keluar.id='".$rw['id']."'";
						$sJml = mysql_query($qJml);
						$wJml = mysql_fetch_array($sJml);
			?>
			<tr>
			  	<td align="center" class="isi"><?php echo $no;?></td>
				<td class="isi" style="padding-left:10px; text-transform:uppercase;" height="20"><?php echo $rw['nama']?></td>
				<td class="isiKn" style="text-align:center;"><?php echo $wJml['jml']?></td>
			</tr>
			<?php
					$no++;
					$tot = $tot + $wJml['jml'];
					}
			?>
			<tr>
			  	<td height="25" colspan="2" style="text-align:center;" class="bwh">TOTAL</td>
				<td class="bwhKn" style="text-align:center;"><?php echo $tot?></td>
			</tr>
	</table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
