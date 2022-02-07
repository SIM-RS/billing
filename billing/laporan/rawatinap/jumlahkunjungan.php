<?php
session_start();
include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Jumlah Kunjungan :.</title>
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
    <td height="100" valign="top" style="font-size:14px; text-transform:uppercase; font-weight:bold; text-align:center;">laporan instalasi rawat inap<br />jumlah kunjungan<br />ruang <?php echo $ruang['nama'];?><br /><?php echo $Periode;?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<tr>
				<td width="40%" height="30" class="jdl">uraian</td>
				<td width="30%" class="jdl"><?php echo $PeriodeWaktu;?></td>
				<td width="30%" class="jdlKn">tt</td>
			</tr>
			<?php
					$sql = "SELECT COUNT(t.jml) AS jml FROM (SELECT b_tindakan_kamar.pelayanan_id AS jml FROM b_kunjungan
INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
WHERE b_pelayanan.unit_id='$tempat' $waktu
GROUP BY b_tindakan_kamar.pelayanan_id) AS t";
					$rs = mysql_query($sql);
					$rw = mysql_fetch_array($rs);
					
					if($tempat==37){
						$fTmp = "(b_ms_kamar.unit_id=37 OR b_ms_kamar.unit_id=103)";
					}else if($tempat==38){
						$fTmp = "(b_ms_kamar.unit_id=38 OR b_ms_kamar.unit_id=102)";
					}else if($tempat==39){
						$fTmp = "(b_ms_kamar.unit_id=39 OR b_ms_kamar.unit_id=101)";
					}else{
						$fTmp = "b_ms_kamar.unit_id = '".$tempat."'";
					}
					
					$qTT = "SELECT SUM(b_ms_kamar.jumlah_tt) AS jml_tt FROM b_ms_kamar WHERE $fTmp";
					$sTT = mysql_query($qTT);
					$wTT = mysql_fetch_array($sTT);
			?>
			<tr>
				<td align="center" class="isi" height="25">JUMLAH KUNJUNGAN</td>
				<td class="isi" style="text-align:center;"><?php echo $rw['jml']?></td>
				<td class="isiKn" style="text-align:center;"><?php echo $wTT['jml_tt'];?></td>
			</tr>
			<tr>
				<td height="25" align="center" class="bwh">TOTAL</td>
				<td class="bwh" style="text-align:center;"><?php echo $rw['jml']?></td>
				<td class="bwhKn" style="text-align:center;"><?php echo $wTT['jml_tt'];?></td>
			</tr>
	</table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
