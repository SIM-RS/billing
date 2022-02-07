<?php
include("../../sesi.php");
include("../../koneksi/konek.php");

$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$jam = date("G:i");


$cmbTahun = $_REQUEST['cmbTahun'];
$jenis = $_REQUEST['JnsLayananInapSaja'];
$unit = $_REQUEST['TmpLayananInapSaja'];
$tgl1 = $_REQUEST['tgl1'];
$tgl2 = $_REQUEST['tgl2'];
//$t1 = tglSQL($tgl1);
//$t2 = tglSQL($tgl2);

$t1 = $cmbTahun."-01-01";
$t2 = $cmbTahun."-12-31";

if($unit == 0){
	$unitO = "";
	$txtUnit = "SEMUA";
}else{
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayananInapSaja']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	$txtUnit = $rwUnit2['nama'];
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


$NDR = "SELECT 
  COUNT(tk.id) AS D 
FROM
  b_tindakan_kamar tk 
  INNER JOIN b_pelayanan p 
    ON tk.pelayanan_id = p.id 
  INNER JOIN b_kunjungan k 
    ON p.kunjungan_id = k.id
  INNER JOIN b_pasien_keluar pk
    ON pk.kunjungan_id = k.id
WHERE tk.aktif = 1 
  AND (
    (
      DATE(tk.tgl_out) BETWEEN '2013-01-01' AND '2013-12-31'
    ) 
    OR (
      tk.tgl_out IS NULL AND DATE(k.tgl_pulang) BETWEEN '2013-01-01' AND '2013-12-31'
    )
  )
  AND pk.cara_keluar='Meninggal' AND pk.keadaan_keluar='Meninggal < 48 jam'";


$nilaiO = $nO['O'];
$nilaiA = $nA['A'];
$nilaiD = $nD['D'];
$nilaiH = $nO['hr'];
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
<title>INDIKATOR PELAYANAN RUMAH SAKIT</title>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font:12px tahoma">
  <tr>
    <td width="10%" height="20"><img src="logo-bakti-husada.jpg" width="55" height="60" /></td>
    <td width="50%" height="20"><p>Formulir RL 1.2</p>
    <p>INDIKATOR PELAYANAN RUMAH SAKIT </p></td>
    <td width="40%" height="20"><table width="100%" border="0">
      <tr>
        <td colspan="4">&nbsp;</td>
        </tr>
      <tr>
	    <td>&nbsp;</td>
        <td colspan="3"><i>Ditjen Bina Upaya Kesehatan</i></td>
        </tr>
      <tr>
	  	<td>&nbsp;</td>
        <td colspan="3"><i>Kementrian Kesehatan RI</i></td>
        </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Kode RS</td>
    <td>: <?php echo $kodeRS;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nama RS</td>
    <td>: <?php echo $namaRS;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Tahun</td>
    <td>: <?php echo $cmbTahun; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Unit</td>
    <td>: <?php echo $txtUnit; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">RL 1.2 Indikator Pelayanan Rumah Sakit</td>
  </tr>
   <tr>
    <td colspan="3"><table width="100%" border="1">
	  <tr align="center">
        <td width="15%" rowspan="2">Tahun</td>
        <td width="10%" rowspan="2">BOR</td>
        <td width="10%" rowspan="2">LOS</td>
        <td width="10%" rowspan="2">BTO</td>
        <td width="10%" rowspan="2">TOI</td>
        <td width="10%" rowspan="2">NDR</td>
        <td width="10%" rowspan="2">GDR</td>
        <td width="25%">Rata-rata</td>
      </tr>
	  <tr align="center">
        <td>Kunjungan/Hari</td>
      </tr>
      <tr align="center" bgcolor="#CCCCCC">
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
        <td>6</td>
        <td>7</td>
        <td>8</td>
      </tr>
      <tr>
        <td align="center"><i><b><?php echo $cmbTahun; ?></b></i></td>
        <td align="center"><?php echo round($bor,2)." %" ?></td>
        <td align="center"><?php echo number_format($los,2,",",".") ?></td>
        <td align="center"><?php echo number_format($bto,2,",",".") ?></td>
        <td align="center"><?php echo number_format($toi,2,",",".") ?></td>
        <td align="center"><?php echo ''; ?></td>
        <td align="center"><?php echo ''; ?></td>
        <?php
		if($unit == 0){
			$fUnit = "b_ms_unit.inap = 1";
		}else{
			$fUnit = "b_ms_unit.id = ".$unit;
		}
		
		$sKunj = "SELECT jml/365 as jum FROM (SELECT COUNT(b_pelayanan.pasien_id) AS jml 
		FROM b_kunjungan 
		INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
		INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
		WHERE $fUnit AND DATE(b_pelayanan.tgl) BETWEEN '".$t1."' AND '".$t2."') AS tbl";
		$qKunj = mysql_query($sKunj);
		$wKunj = mysql_fetch_array($qKunj);
		?>
        <td align="center"><?php echo $wKunj['jum']; ?></td>
      </tr>
    </table></td>
  </tr>
  </table>
</body>
</html>
