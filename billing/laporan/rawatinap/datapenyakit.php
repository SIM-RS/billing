<?php
session_start();
include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Data 10 Besar Penyakit :.</title>
</head>

<body>
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	$stsPas = $_REQUEST['StatusPas'];
	if($stsPas!=0) $fKso = "AND b_pelayanan.kso_id = '".$stsPas."'";
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(b_diagnosa_rm.tgl) = '$bln' and year(b_diagnosa_rm.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
		$PeriodeWaktu = "$arrBln[$bln] $thn";
	}
	
	$jenis = $_REQUEST['JnsLayananInapSaja'];
	$tempat = $_REQUEST['TmpLayananInapSaja'];
	
	$q = "SELECT id, nama FROM b_ms_unit WHERE id='$tempat'";
	$s = mysql_query($q);
	$ruang = mysql_fetch_array($s);
	
	$qK = "SELECT id, nama FROM b_ms_kso WHERE id = '$stsPas'";
	$sK = mysql_query($qK);
	$wK = mysql_fetch_array($sK);
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
    <td height="100" valign="top" style="font-size:14px; text-transform:uppercase; font-weight:bold; text-align:center;">laporan instalasi rawat inap<br />data 10 besar penyakit <?php if($stsPas!=0) echo "pasien ".$wK['nama']; else echo "";?><br />ruang <?php echo $ruang['nama'];?><br /><?php echo $Periode;?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<tr>
			  <td width="5%" class="jdl">no</td>
				<td width="60%" height="30" class="jdl">diagnosis</td>
				<td width="15%" class="jdl">&sum;</td>
				<td width="20%" class="jdlKn">Prosentase (%)</td>
			</tr>
			<?php
					
					$sql = "SELECT t.id, t.nama, t.jml FROM (SELECT b_ms_diagnosa.id, b_ms_diagnosa.nama, COUNT(b_pelayanan.id) AS jml FROM b_pelayanan INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id WHERE b_pelayanan.unit_id='$tempat' $waktu $fKso GROUP BY b_ms_diagnosa.id ) AS t ORDER BY t.jml DESC LIMIT 10";
					$rs = mysql_query($sql);
					$no=1;
					$tot = 0;
					while($rw = mysql_fetch_array($rs))
					{
						$qTot = "SELECT COUNT(b_diagnosa_rm.pelayanan_id) AS jml FROM b_pelayanan INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id WHERE b_pelayanan.unit_id='$tempat' $fKso $waktu";
						$sTot = mysql_query($qTot);
						$wTot = mysql_fetch_array($sTot);
						
						$qJml = "SELECT COUNT(b_diagnosa_rm.pelayanan_id) AS jml FROM b_pelayanan INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id WHERE b_pelayanan.unit_id='$tempat' AND b_diagnosa_rm.ms_diagnosa_id='".$rw['id']."' $fKso $waktu";
						$sJml = mysql_query($qJml);
						$wJml = mysql_fetch_array($sJml); 
			?>
			<tr>
			  <td align="center" class="isi"><?php echo $no;?></td>
				<td class="isi" style="padding-left:10px; text-transform:uppercase;" height="20"><?php echo $rw['nama']?></td>
				<td class="isi" style="text-align:center;"><?php echo $wJml['jml']?></td>
				<td class="isiKn" style="text-align:right; padding-right:40px;"><?php if($wJml['jml']==0 || $wJml['jml']=="") echo 0; else echo number_format($wJml['jml']/$wTot['jml']*100,2,",",".")?>&nbsp;%</td>
			</tr>
			<?php
					$no++;
					$tot = $tot + $wJml['jml'];
					}
			?>
			<tr>
			  	<td height="25" colspan="2" style="text-align:center;" class="bwh">TOTAL</td>
				<td class="bwh" style="text-align:center;"><?php echo $tot?></td>
				<td class="bwhKn" style="text-align:right; padding-right:40px;"><?php if($tot==0) echo "0&nbsp;%"; else echo "100&nbsp;%"?></td>
			</tr>
	</table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
