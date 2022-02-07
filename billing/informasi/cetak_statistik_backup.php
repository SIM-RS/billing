<?php
session_start();
if(!isset($_SESSION['userId']))
{
	header('Location: ../index.php');
}else{
error_reporting(E_ALL^(E_NOTICE | E_WARNING));	
include("../koneksi/konek.php"); 

$jenis = $_REQUEST['jns'];
$unit = $_REQUEST['tmp'];
$tgl1 = $_REQUEST['tgl1'];
$tgl2 = $_REQUEST['tgl2'];
$t1 = tglSQL($tgl1);
$t2 = tglSQL($tgl2);

/* $O = "SELECT (DATEDIFF('".$t2."','".$t1."')+1) hr,
		  SUM(
			(SELECT 
			  COUNT(p.id) 
			FROM
			  b_ms_pasien p 
			  INNER JOIN b_kunjungan k 
				ON k.pasien_id = p.id 
			  INNER JOIN b_pelayanan pl 
				ON k.id = pl.kunjungan_id 
			  INNER JOIN b_tindakan_kamar tk 
				ON pl.id = tk.pelayanan_id 
			WHERE k.pulang = 0 
			  AND pl.dilayani = 1 
			  AND tk.tgl_out IS NULL 
			  AND pl.unit_id = '$unit')
		  ) AS O"; */

if($unit == 0){
	$unitO = "";
}else{
	$unitO = "AND p.unit_id = ".$unit;
}
		  
$O = "SELECT SUM(DATEDIFF(t2.tgl_out,t2.tgl_in))/(DATEDIFF('".$t2."','".$t1."')+1) O,
			 (DATEDIFF('".$t2."','".$t1."')+1) hr
		FROM (
			    SELECT t1.pelayanan_id,DATE(t1.tgl_in) tgl_in,IFNULL(DATE(t1.tgl_out),IFNULL(DATE(t1.tgl_pulang),'".$t2."')) tgl_out 
				FROM (SELECT gab.*, k.tgl_pulang FROM 
						(SELECT tk.*, p.kunjungan_id FROM b_tindakan_kamar tk 
							INNER JOIN b_pelayanan p ON tk.pelayanan_id = p.id 
							WHERE tk.aktif = 1 ".$unitO." AND 
								(
									DATE(tk.tgl_in) <= '".$t2."' AND (DATE(tk.tgl_out) > '".$t1."' OR tk.tgl_out IS NULL)
								)
						) AS gab 
				INNER JOIN b_kunjungan k ON gab.kunjungan_id = k.id) AS t1 
				WHERE DATE(t1.tgl_in) <= '".$t2."' AND 
					(DATE(t1.tgl_out) > '".$t1."' OR t1.tgl_out IS NULL) AND 
					(DATE(t1.tgl_pulang)>'".$t1."' OR t1.tgl_pulang IS NULL)
			  ) AS t2";
$qO = mysql_query($O);
$nO = mysql_fetch_array($qO);

if($unit == 0){
	$unitA = "";
}else{
	$unitA = "AND mu.id = ".$unit;
}

$A = "SELECT SUM(mk.jumlah_tt) A
		FROM b_ms_kamar mk
		INNER JOIN b_ms_unit mu
			ON mk.unit_id = mu.id
		WHERE mk.aktif = 1 AND mu.aktif = 1 ".$unitA;
$qA = mysql_query($A);
$nA = mysql_fetch_array($qA);

if($unit == 0){
	$unitD = "";
}else{
	$unitD = "AND p.unit_id = ".$unit;
}

$D = "SELECT COUNT(tk.id) AS D
		FROM b_tindakan_kamar tk
		INNER JOIN b_pelayanan p
			ON tk.pelayanan_id = p.id
		INNER JOIN b_kunjungan k
			ON p.kunjungan_id = k.id
		WHERE tk.aktif=1 ".$unitD." AND 
			(
				(DATE(tk.tgl_out) BETWEEN '".$t1."' AND '".$t2."')
				OR
				(tk.tgl_out IS NULL AND DATE(k.tgl_pulang) BETWEEN '".$t1."' AND '".$t2."')
			)";
$qD = mysql_query($D);
$nD = mysql_fetch_array($qD);

$nilaiO = $nO['O'];
$nilaiA = $nA['A'];
$nilaiD = $nD['D'];
$nilaiH = $nO['hr'];
$nilaiA = $_REQUEST['jmlB'];
/////////////////////
//$bor = $nilaiO*100/$nilaiA;
$bor = ($nilaiO / $nilaiA) * 100;
$los = $nilaiO*$nilaiH/$nilaiD;
$toi = ($nilaiA-$nilaiO)*$nilaiH/$nilaiD;
$bto = $nilaiD/$nilaiA;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="style_statistik.css">
<title>Laporan Statistik BOR, AvLOS, TOI dan BTO</title>
</head>

<body>
	<div align="center" style="background-color:#FFFFFF; width:1023px">
		<table width="970" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td class="textJdl1">Laporan Statistik BOR, AvLOS, TOI dan BTO</td>
			</tr>
		</table>

		<p>&nbsp;</p>

		<table width="700" align="center" cellpadding="0" cellspacing="0">
		<?php
			if($unit == 0){
				$unitNm = "";
			}else{
				$unitNm = "where id = ".$unit;
			}
			$j="select nama from b_ms_unit where id='$jenis'";
			$jj=mysql_query($j);
			$jn=mysql_fetch_array($jj);
			$u="select nama from b_ms_unit ".$unitNm;
			$uu=mysql_query($u);
			$un=mysql_fetch_array($uu);
		?>
			<tr>
				<td width="130" align="left">Jenis Layanan</td>
				<td>: <? echo $jn['nama'] ?></td>
			</tr>
			<tr>
				<td align="left">Tempat Layanan</td>
				<td>: <? if($unit == 0) echo "SEMUA"; else echo $un['nama'] ?></td>
			</tr>
			<tr>
				<td align="left">Periode</td>
				<td>: <? echo $tgl1." s/d ".$tgl2 ?></td>
			</tr>
		</table>
		
		<table align="center" cellpadding="0" cellspacing="0" width="700">
			<tr>
				<td class="jdlkiri" width="50" align="center">No</td>
				<td class="jdl" width="450" align="center">Laporan</td>
				<td class="jdl" width="200" align="center">Nilai</td>
			</tr>
			<tr>

				<td class="isikiri" align="center">1</td>
				<td class="isi">&nbsp;BOR (Bed Occupacion Rate)</td>
				<td class="isi" align="right"><?php echo round($bor,2)." %" ?>&nbsp;&nbsp;</td>
			</tr>
			<tr>

				<td class="isikiri" align="center">2</td>
				<td class="isi">&nbsp;AvLOS (Average Length of Stay)</td>
				<td class="isi" align="right"><?php echo number_format($los,2,",",".") ?>&nbsp;&nbsp;</td>
			</tr>
			<tr>

				<td class="isikiri" align="center">3</td>
				<td class="isi">&nbsp;TOI (Turn Over Interval)</td>
				<td class="isi" align="right"><?php echo number_format($toi,2,",",".") ?>&nbsp;&nbsp;</td>
			</tr>
			<tr>

				<td class="isikiri" align="center">3</td>
				<td class="isi">&nbsp;BTO (Bed Turn Over)</td>
				<td class="isi" align="right"><?php echo number_format($bto,2,",",".") ?>&nbsp;&nbsp;</td>
			</tr>
		</table>

		<div align="center" style="width:700px">
			<p align="justify">
				BOR = O / A x 100 %<br>
				AvLOS = O x H / D<br>
				TOI = (A - O) x  H / D<br>
				BTO = D / A<br>
				<br>
				Keterangan : <br>
				O = <?php echo $nilaiO; ?> = Rata-rata tempat tidur terisi dalam periode tertentu ( <? echo $tgl1." s/d ".$tgl2 ?> )<br>
				D = <?php echo $nilaiD; ?> = Jumlah pasien yang keluar dalam periode tertentu ( <? echo $tgl1." s/d ".$tgl2 ?> )<br>
				A = <?php echo $nilaiA; ?> = Jumlah tempat tidur<br>
				H = <?php echo $nilaiH; ?> = Jumlah hari dalam periode tertentu ( <? echo $tgl1." s/d ".$tgl2 ?> )
			</p>
		</div>
		<div align="center">
			<button type="button" id="ctk" name="ctk" onclick="window.print()" style="cursor:pointer">
				<img src="../../icon/printer.png" width="16" align="absmiddle" />&nbsp;Cetak
			</button>&nbsp;&nbsp;
			<button type="button" id="close" name="close" style="cursor:pointer" onclick="window.close()">
				<img src="../../icon/del.gif" width="16" align="absmiddle" />&nbsp;Close
			</button>
		</div>
	</div>
</body>
</html>
<? } ?>