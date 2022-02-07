<?php
session_start();
include("../../sesi.php");

if($_POST['isExcel']=='yes'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="rekapHarian.xls"');
}

?>
<?php
include ("../../koneksi/konek.php");
//====================================
	$tmpLayanan=$_REQUEST['TmpLayananInapSaja'];
	$jnsLayanan=$_REQUEST['JnsLayananInapSaja'];
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " AND pl.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " AND month(pl.tgl) = '$bln' and year(pl.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " AND pl.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$tgl1=GregorianToJD($tglAwal[1],$tglAwal[0],$tglAwal[2]);
		$tgl2=GregorianToJD($tglAkhir[1],$tglAkhir[0],$tglAkhir[2]);
		$selisih=$tgl2-$tgl1;
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	//======Pengambilan Ruang================
	$sqlUnit = "SELECT id,nama FROM b_ms_unit WHERE id = '".$tmpLayanan."'";
	$rsUnit = mysql_query($sqlUnit);
	$rwUnit = mysql_fetch_array($rsUnit);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Rekap Harian :.</title>
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
  	<td colspan="4"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td colspan="4" align="center" style="font-weight:bold; font-size:14px;" height="70">REKAPITULASI HARIAN PASIEN RAWAT INAP&nbsp;</td>
  </tr>
  <tr>
    <td width="5%" style="font-weight:bold">Bulan</td>
    <td width="67%" style="font-weight:bold">: <?php echo $arrBln[$bln]?></td>
    <td width="14%" style="font-weight:bold">Ruang Rawat Inap</td>
    <td width="14%" style="font-weight:bold">: <?php echo $rwUnit['nama']?></td>
  </tr>
  <tr>
    <td style="font-weight:bold">Tahun</td>
	<?php 
			$qTt = mysql_query("SELECT SUM(jumlah_tt+jumlah_tt_b) AS jml FROM b_ms_kamar WHERE b_ms_kamar.unit_id='".$tmpLayanan."' AND aktif=1");
			$wTt = mysql_fetch_array($qTt);		
	?>
    <td style="font-weight:bold">: <?php echo $thn?></td>
    <td width="14%" style="font-weight:bold">Tempat Tidur Tersedia</td>
    <td width="14%" style="font-weight:bold">: <?php echo $wTt['jml'];?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:10px;">
			<tr>
				<td height="30" rowspan="2" align="center" style="border:#FFFFFF 1px solid; font-weight:bold; background-color:#00FF00;">Tgl</td>
				<td rowspan="2" align="center" style="border:#FFFFFF 1px solid; border-left:none; font-weight:bold; background-color:#00FF00;">Pasien Awal</td>
				<td rowspan="2" align="center" style="border:#FFFFFF 1px solid; border-left:none; font-weight:bold; background-color:#00FF00;">Pasien Masuk</td>
				<td rowspan="2" align="center" style="border:#FFFFFF 1px solid; border-left:none; font-weight:bold; background-color:#00FF00;">Pasien Pindahan</td>
				<td rowspan="2" align="center" style="border:#FFFFFF 1px solid; border-left:none; font-weight:bold; background-color:#00FF00;">Jumlah<br />(2+3+4)</td>
				<td rowspan="2" align="center" style="border:#FFFFFF 1px solid; border-left:none; font-weight:bold; background-color:#00FF00;">Pasien Dipindahkan</td>
				<td rowspan="2" align="center" style="border:#FFFFFF 1px solid; border-left:none; font-weight:bold; background-color:#00FF00;">Pasien Keluar Hidup</td>
				<td rowspan="2" align="center" style="border:#FFFFFF 1px solid; border-left:none; font-weight:bold; background-color:#00FF00;">Pasien Mati<br />(9+10)</td>
				<td colspan="2" align="center" style="border:#FFFFFF 1px solid; border-left:none; font-weight:bold; background-color:#00FF00;">Perincian Pasien Mati </td>
				<td rowspan="2" align="center" style="border:#FFFFFF 1px solid; border-left:none; font-weight:bold; background-color:#00FF00;">Jumlah<br />(6+7+8) </td>
				<td rowspan="2" align="center" style="border:#FFFFFF 1px solid; border-left:none; font-weight:bold; background-color:#00FF00;">Jml Lama dirawat </td>
				<td rowspan="2" align="center" style="border:#FFFFFF 1px solid; border-left:none; font-weight:bold; background-color:#00FF00;">Pasien Keluar /Masuk Pada Hari yang Sama </td>
				<td rowspan="2" align="center" style="border:#FFFFFF 1px solid; border-left:none; font-weight:bold; background-color:#00FF00;">Pasien Sisa yang Masih dirawat </td>
				<td colspan="4" align="center" style="border:#FFFFFF 1px solid; border-left:none; font-weight:bold; background-color:#00FF00;">Perincian Jumlah Pasien per Kelas </td>
			</tr>
			<tr>
			  <td height="30" align="center" style="border:#FFFFFF 1px solid; border-left:none; border-top:none; font-weight:bold; background-color:#00FF00;"><48 Jam</td>
			  <td align="center" style="border:#FFFFFF 1px solid; border-left:none; border-top:none; font-weight:bold; background-color:#00FF00;">>48 Jam</td>
		      <td align="center" style="border:#FFFFFF 1px solid; border-left:none; border-top:none; font-weight:bold; background-color:#00FF00;">Kelas VIP /Utama</td>
		      <td align="center" style="border:#FFFFFF 1px solid; border-left:none; border-top:none; font-weight:bold; background-color:#00FF00;"><?php if($jnsLayanan==50) echo "I Pav"; else echo "Kelas I"?></td>
		      <td align="center" style="border:#FFFFFF 1px solid; border-left:none; border-top:none; font-weight:bold; background-color:#00FF00;"><?php if($jnsLayanan==50) echo "II Pav"; else echo "Kelas II"?></td>
		      <td align="center" style="border:#FFFFFF 1px solid; border-left:none; border-top:none; font-weight:bold; background-color:#00FF00;"><?php if($jnsLayanan==50) echo "---"; else echo "Kelas III"?></td>
	      </tr>
		  <tr>
		  	<td height="20" width="5%" align="center" style="border:#FFFFFF 1px solid; border-top:none; background-color:#8080ff;">1</td>
			<td width="5%" align="center" style="border-bottom:#FFFFFF solid 1px; border-right:#FFFFFF solid 1px; background-color:#8080ff;">2</td>
			<td width="5%" align="center" style="border-bottom:#FFFFFF solid 1px; border-right:#FFFFFF solid 1px; background-color:#8080ff;">3</td>
			<td width="6%" align="center" style="border-bottom:#FFFFFF solid 1px; border-right:#FFFFFF solid 1px; background-color:#8080ff;">4</td>
			<td width="6%" align="center" style="border-bottom:#FFFFFF solid 1px; border-right:#FFFFFF solid 1px; background-color:#8080ff;">5</td>
			<td width="7%" align="center" style="border-bottom:#FFFFFF solid 1px; border-right:#FFFFFF solid 1px; background-color:#8080ff;">6</td>
			<td width="5%" align="center" style="border-bottom:#FFFFFF solid 1px; border-right:#FFFFFF solid 1px; background-color:#8080ff;">7</td>
			<td width="5%" align="center" style="border-bottom:#FFFFFF solid 1px; border-right:#FFFFFF solid 1px; background-color:#8080ff;">8</td>
			<td width="5%" align="center" style="border-bottom:#FFFFFF solid 1px; border-right:#FFFFFF solid 1px; background-color:#8080ff;">9</td>
			<td width="5%" align="center" style="border-bottom:#FFFFFF solid 1px; border-right:#FFFFFF solid 1px; background-color:#8080ff;">10</td>
			<td width="5%" align="center" style="border-bottom:#FFFFFF solid 1px; border-right:#FFFFFF solid 1px; background-color:#8080ff;">11</td>
			<td width="6%" align="center" style="border-bottom:#FFFFFF solid 1px; border-right:#FFFFFF solid 1px; background-color:#8080ff;">12</td>
			<td width="8%" align="center" style="border-bottom:#FFFFFF solid 1px; border-right:#FFFFFF solid 1px; background-color:#8080ff;">13</td>
			<td width="7%" align="center" style="border-bottom:#FFFFFF solid 1px; border-right:#FFFFFF solid 1px; background-color:#8080ff;">14</td>
			<td width="5%" align="center" style="border-bottom:#FFFFFF solid 1px; border-right:#FFFFFF solid 1px; background-color:#8080ff;">15</td>
			<td width="5%" align="center" style="border-bottom:#FFFFFF solid 1px; border-right:#FFFFFF solid 1px; background-color:#8080ff;">16</td>
			<td width="5%" align="center" style="border-bottom:#FFFFFF solid 1px; border-right:#FFFFFF solid 1px; background-color:#8080ff;">17</td>
			<td width="5%" align="center" style="border-bottom:#FFFFFF solid 1px; border-right:#FFFFFF solid 1px; background-color:#8080ff;">18</td>
		  </tr>
		  <?php
				$bln = $_POST['cmbBln'];
				$thn = $_POST['cmbThn'];
				if($bln=='01' || $bln=='03' || $bln=='05' || $bln=='07' || $bln=='08' || $bln=='10' || $bln=='12'){
					$tgl = 31;
				}else if($bln == '02'){
					if(($thn54==0) && ($thn%100 !=0)){
						$tgl = 29;
					}else{
						$tgl = 28;
					}
				}else{
					$tgl = 30;
				}
				
				//$tgl=1;
								
				$tot2=$tot3=$tot4=$tot5=$tot6=$tot7=$tot8=$tot9=$tot10=$tot11=$tot12=$tot13=$tot14=$tot15=$tot16=$tot17=$tot18=0;
				for($i=1;$i<=$tgl;$i++)
				{
		  			$tglAwal=$thn."-".$bln."-".$i;

					/* Pasien Awal */
					/*
				    $q2 = "SELECT 
					  COUNT(b_tindakan_kamar.pelayanan_id) AS jml 
					FROM
					  b_pelayanan 
					  INNER JOIN b_tindakan_kamar 
						ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
					WHERE DATE(b_tindakan_kamar.tgl_in) < '".$tglAwal."'
					  AND (b_tindakan_kamar.tgl_out IS NULL OR DATE(b_tindakan_kamar.tgl_out) >= '".$tglAwal."')
					  AND b_pelayanan.unit_id = '".$tmpLayanan."'";
					*/  
					$q2 = "SELECT 
							  COUNT(*) AS jml
							FROM
							  (SELECT 
								b_ms_pasien.nama,
								b_tindakan_kamar.tgl_in,
								b_tindakan_kamar.tgl_out,
								b_kunjungan.pulang 
							  FROM
								b_pelayanan 
								INNER JOIN b_kunjungan 
								  ON b_kunjungan.id = b_pelayanan.kunjungan_id 
								INNER JOIN b_tindakan_kamar 
								  ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
								INNER JOIN b_ms_pasien 
								  ON b_ms_pasien.id = b_pelayanan.pasien_id 
							  WHERE DATE(b_tindakan_kamar.tgl_in) < '".$tglAwal."' 
								AND DATE(b_tindakan_kamar.tgl_out) >= '".$tglAwal."' 
								AND b_pelayanan.unit_id = '".$tmpLayanan."' 
							  UNION
							  SELECT 
								b_ms_pasien.nama,
								b_tindakan_kamar.tgl_in,
								b_tindakan_kamar.tgl_out,
								b_kunjungan.pulang 
							  FROM
								b_pelayanan 
								INNER JOIN b_kunjungan 
								  ON b_kunjungan.id = b_pelayanan.kunjungan_id 
								INNER JOIN b_tindakan_kamar 
								  ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
								INNER JOIN b_ms_pasien 
								  ON b_ms_pasien.id = b_pelayanan.pasien_id 
							  WHERE DATE(b_tindakan_kamar.tgl_in) < '".$tglAwal."' 
								AND b_tindakan_kamar.tgl_out IS NULL 
								AND b_kunjungan.pulang = 0 
								AND b_pelayanan.unit_id = '".$tmpLayanan."') AS tbl";
					$rs2 = mysql_query($q2);
					$rw2 = mysql_fetch_array($rs2);
					
					/* Pasien Masuk */
					$q3 = "SELECT 
					  COUNT(b_tindakan_kamar.pelayanan_id) AS jml
					FROM
					  b_pelayanan 
					  INNER JOIN b_tindakan_kamar 
						ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
					WHERE DATE(b_tindakan_kamar.tgl_in) = '".$tglAwal."' 
					  AND b_pelayanan.unit_id = '".$tmpLayanan."' 
					  AND b_tindakan_kamar.unit_id_asal IN 
					  (SELECT 
						id 
					  FROM
						b_ms_unit u 
					  WHERE u.inap <> '1')";
					$rs3 = mysql_query($q3);
					$rw3 = mysql_fetch_array($rs3);
					
					/* Pasien Pindahan */
					$q4 = "SELECT
					  COUNT(b_tindakan_kamar.pelayanan_id) AS jml
					FROM
					  b_pelayanan 
					  INNER JOIN b_tindakan_kamar 
						ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
					WHERE DATE(b_tindakan_kamar.tgl_in) = '".$tglAwal."' 
					  AND b_pelayanan.unit_id = '".$tmpLayanan."' 
					  AND b_tindakan_kamar.unit_id_asal IN  
					  (SELECT 
						id 
					  FROM
						b_ms_unit u 
					  WHERE u.inap = '1')";
					$rs4 = mysql_query($q4);
					$rw4 = mysql_fetch_array($rs4);
					
					/* Pasien di Pindahkan */
					$q6 = "SELECT 
					  COUNT(b_tindakan_kamar.pelayanan_id) AS jml 
					FROM
					  b_pelayanan 
					  INNER JOIN b_tindakan_kamar 
						ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
					WHERE DATE(b_tindakan_kamar.tgl_out) = '".$tglAwal."' 
					  AND b_pelayanan.unit_id = '".$tmpLayanan."' 
					  AND b_tindakan_kamar.status_out = '1'";
					$rs6 = mysql_query($q6);
					$rw6 = mysql_fetch_array($rs6);
					
					/* Pasien Keluar Hidup */
					$q7 = "SELECT 
					  COUNT(b_tindakan_kamar.pelayanan_id) AS jml 
					FROM
					  b_pelayanan 
					  INNER JOIN b_tindakan_kamar 
						ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
					   LEFT JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
					WHERE DATE(b_tindakan_kamar.tgl_out) = '".$tglAwal."' 
					  AND b_pelayanan.unit_id = '".$tmpLayanan."' 
					  AND b_tindakan_kamar.status_out = '0' 
					  AND (b_pasien_keluar.cara_keluar <> 'Meninggal' OR b_pasien_keluar.cara_keluar IS NULL)";
					$rs7 = mysql_query($q7);
					$rw7 = mysql_fetch_array($rs7);
					
					/* Pasien Mati */
					$q8 = "SELECT
					  COUNT(b_tindakan_kamar.pelayanan_id) AS jml
					FROM
					  b_pelayanan 
					  INNER JOIN b_tindakan_kamar 
						ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
					  INNER JOIN b_pasien_keluar 
						ON b_pasien_keluar.pelayanan_id = b_pelayanan.id
					WHERE DATE(b_tindakan_kamar.tgl_out) = '".$tglAwal."'
					  AND b_pasien_keluar.cara_keluar = 'Meninggal' 
					  AND b_pelayanan.unit_id = '".$tmpLayanan."'";
					$rs8 = mysql_query($q8);
					$rw8 = mysql_fetch_array($rs8);
					
					/* meninggal < 48 jam */
					$q9 = "SELECT
					  COUNT(b_tindakan_kamar.pelayanan_id) jml
					FROM
					  b_pelayanan 
					  INNER JOIN b_tindakan_kamar 
						ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
					  INNER JOIN b_pasien_keluar 
						ON b_pasien_keluar.pelayanan_id = b_pelayanan.id
					WHERE DATE(b_tindakan_kamar.tgl_out) = '".$tglAwal."'
					  AND b_pasien_keluar.cara_keluar = 'Meninggal'
					  AND (b_pasien_keluar.keadaan_keluar = 'Meninggal < 48 jam' OR b_pasien_keluar.keadaan_keluar = 'Meninggal sebelum dirawat') 
					  AND b_pelayanan.unit_id = '".$tmpLayanan."'";
					$rs9 = mysql_query($q9);
					$rw9 = mysql_fetch_array($rs9);
					
					/* meninggal > 48 jam */
					$rw10 = 0;
					$rw10 = $rw8['jml'] - $rw9['jml'];
					// =========================
						
					
					/* Jumlah Lama Di Rawat */					
					$q12 = "SELECT 
					  SUM(
						DATEDIFF(
						  b_tindakan_kamar.tgl_out,
						  b_tindakan_kamar.tgl_in
						)
					  ) AS jml 
					FROM
					  b_pelayanan 
					  INNER JOIN b_tindakan_kamar 
						ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id  
					WHERE DATE(b_tindakan_kamar.tgl_out) = '".$tglAwal."' 
					  AND b_pelayanan.unit_id = '".$tmpLayanan."'";
					$rs12 = mysql_query($q12);
					$rw12 = mysql_fetch_array($rs12); 
					
					
					/* Pasien Keluar Masuk pada hari yang sama */
					$q13 = "SELECT 
					  COUNT(b_tindakan_kamar.pelayanan_id) AS jml 
					FROM
					  b_pelayanan 
					  INNER JOIN b_tindakan_kamar 
						ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
					WHERE DATE(b_tindakan_kamar.tgl_in) = '".$tglAwal."' 
					  AND DATE(b_tindakan_kamar.tgl_out) = '".$tglAwal."' 
					  AND b_pelayanan.unit_id = '".$tmpLayanan."'";
					$rs13 = mysql_query($q13);
					$rw13 = mysql_fetch_array($rs13); 
					
					
					/* Kelas VIP/Utama */
					$q15 = "SELECT 
					   COUNT(b_tindakan_kamar.pelayanan_id) AS jml 
					FROM
					  b_pelayanan 
					  INNER JOIN b_tindakan_kamar 
						ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
					  INNER JOIN b_ms_kelas
						ON b_ms_kelas.id = b_tindakan_kamar.kelas_id 
					WHERE DATE(b_tindakan_kamar.tgl_in) <= '".$tglAwal."'
					  AND (b_tindakan_kamar.tgl_out IS NULL OR DATE(b_tindakan_kamar.tgl_out) > '".$tglAwal."')
					  AND b_pelayanan.unit_id = '".$tmpLayanan."' AND b_ms_kelas.id IN (5,6)";
					$q15 = "SELECT 
							  COUNT(*) AS jml
							FROM
							  (SELECT 
								b_ms_pasien.nama,
								b_tindakan_kamar.tgl_in,
								b_tindakan_kamar.tgl_out,
								b_kunjungan.pulang 
							  FROM
								b_pelayanan 
								INNER JOIN b_kunjungan 
								  ON b_kunjungan.id = b_pelayanan.kunjungan_id 
								INNER JOIN b_tindakan_kamar 
								  ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
								INNER JOIN b_ms_pasien 
								  ON b_ms_pasien.id = b_pelayanan.pasien_id
								INNER JOIN b_ms_kelas
								  ON b_ms_kelas.id = b_tindakan_kamar.kelas_id 
							  WHERE DATE(b_tindakan_kamar.tgl_in) < '".$tglAwal."' 
								AND DATE(b_tindakan_kamar.tgl_out) >= '".$tglAwal."' 
								AND b_pelayanan.unit_id = '".$tmpLayanan."'
								AND b_ms_kelas.id IN (5,6) 
							  UNION
							  SELECT 
								b_ms_pasien.nama,
								b_tindakan_kamar.tgl_in,
								b_tindakan_kamar.tgl_out,
								b_kunjungan.pulang 
							  FROM
								b_pelayanan 
								INNER JOIN b_kunjungan 
								  ON b_kunjungan.id = b_pelayanan.kunjungan_id 
								INNER JOIN b_tindakan_kamar 
								  ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
								INNER JOIN b_ms_pasien 
								  ON b_ms_pasien.id = b_pelayanan.pasien_id
								INNER JOIN b_ms_kelas
								  ON b_ms_kelas.id = b_tindakan_kamar.kelas_id 
							  WHERE DATE(b_tindakan_kamar.tgl_in) < '".$tglAwal."' 
								AND b_tindakan_kamar.tgl_out IS NULL 
								AND b_kunjungan.pulang = 0 
								AND b_pelayanan.unit_id = '".$tmpLayanan."'
								AND b_ms_kelas.id IN (5,6)) AS tbl";
					$rs15 = mysql_query($q15);
					$rw15 = mysql_fetch_array($rs15);
					
					/* Kelas 1 */
					$q16 = "SELECT 
							  COUNT(*) AS jml
							FROM
							  (SELECT 
								b_ms_pasien.nama,
								b_tindakan_kamar.tgl_in,
								b_tindakan_kamar.tgl_out,
								b_kunjungan.pulang 
							  FROM
								b_pelayanan 
								INNER JOIN b_kunjungan 
								  ON b_kunjungan.id = b_pelayanan.kunjungan_id 
								INNER JOIN b_tindakan_kamar 
								  ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
								INNER JOIN b_ms_pasien 
								  ON b_ms_pasien.id = b_pelayanan.pasien_id
								INNER JOIN b_ms_kelas
								  ON b_ms_kelas.id = b_tindakan_kamar.kelas_id 
							  WHERE DATE(b_tindakan_kamar.tgl_in) < '".$tglAwal."' 
								AND DATE(b_tindakan_kamar.tgl_out) >= '".$tglAwal."' 
								AND b_pelayanan.unit_id = '".$tmpLayanan."'
								AND b_ms_kelas.id IN (2,7) 
							  UNION
							  SELECT 
								b_ms_pasien.nama,
								b_tindakan_kamar.tgl_in,
								b_tindakan_kamar.tgl_out,
								b_kunjungan.pulang 
							  FROM
								b_pelayanan 
								INNER JOIN b_kunjungan 
								  ON b_kunjungan.id = b_pelayanan.kunjungan_id 
								INNER JOIN b_tindakan_kamar 
								  ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
								INNER JOIN b_ms_pasien 
								  ON b_ms_pasien.id = b_pelayanan.pasien_id
								INNER JOIN b_ms_kelas
								  ON b_ms_kelas.id = b_tindakan_kamar.kelas_id 
							  WHERE DATE(b_tindakan_kamar.tgl_in) < '".$tglAwal."' 
								AND b_tindakan_kamar.tgl_out IS NULL 
								AND b_kunjungan.pulang = 0 
								AND b_pelayanan.unit_id = '".$tmpLayanan."'
								AND b_ms_kelas.id IN (2,7)) AS tbl";
					$rs16 = mysql_query($q16);
					$rw16 = mysql_fetch_array($rs16);
					
					/* Kelas 2 */
					$q17 = "SELECT 
							  COUNT(*) AS jml
							FROM
							  (SELECT 
								b_ms_pasien.nama,
								b_tindakan_kamar.tgl_in,
								b_tindakan_kamar.tgl_out,
								b_kunjungan.pulang 
							  FROM
								b_pelayanan 
								INNER JOIN b_kunjungan 
								  ON b_kunjungan.id = b_pelayanan.kunjungan_id 
								INNER JOIN b_tindakan_kamar 
								  ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
								INNER JOIN b_ms_pasien 
								  ON b_ms_pasien.id = b_pelayanan.pasien_id
								INNER JOIN b_ms_kelas
								  ON b_ms_kelas.id = b_tindakan_kamar.kelas_id 
							  WHERE DATE(b_tindakan_kamar.tgl_in) < '".$tglAwal."' 
								AND DATE(b_tindakan_kamar.tgl_out) >= '".$tglAwal."' 
								AND b_pelayanan.unit_id = '".$tmpLayanan."'
								AND b_ms_kelas.id IN (3,8) 
							  UNION
							  SELECT 
								b_ms_pasien.nama,
								b_tindakan_kamar.tgl_in,
								b_tindakan_kamar.tgl_out,
								b_kunjungan.pulang 
							  FROM
								b_pelayanan 
								INNER JOIN b_kunjungan 
								  ON b_kunjungan.id = b_pelayanan.kunjungan_id 
								INNER JOIN b_tindakan_kamar 
								  ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
								INNER JOIN b_ms_pasien 
								  ON b_ms_pasien.id = b_pelayanan.pasien_id
								INNER JOIN b_ms_kelas
								  ON b_ms_kelas.id = b_tindakan_kamar.kelas_id 
							  WHERE DATE(b_tindakan_kamar.tgl_in) < '".$tglAwal."' 
								AND b_tindakan_kamar.tgl_out IS NULL 
								AND b_kunjungan.pulang = 0 
								AND b_pelayanan.unit_id = '".$tmpLayanan."'
								AND b_ms_kelas.id IN (3,8)) AS tbl";
					$rs17 = mysql_query($q17);
					$rw17 = mysql_fetch_array($rs17);
					
					/* Kelas 3 */
					$q18 = "SELECT 
							  COUNT(*) AS jml
							FROM
							  (SELECT 
								b_ms_pasien.nama,
								b_tindakan_kamar.tgl_in,
								b_tindakan_kamar.tgl_out,
								b_kunjungan.pulang 
							  FROM
								b_pelayanan 
								INNER JOIN b_kunjungan 
								  ON b_kunjungan.id = b_pelayanan.kunjungan_id 
								INNER JOIN b_tindakan_kamar 
								  ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
								INNER JOIN b_ms_pasien 
								  ON b_ms_pasien.id = b_pelayanan.pasien_id
								INNER JOIN b_ms_kelas
								  ON b_ms_kelas.id = b_tindakan_kamar.kelas_id 
							  WHERE DATE(b_tindakan_kamar.tgl_in) < '".$tglAwal."' 
								AND DATE(b_tindakan_kamar.tgl_out) >= '".$tglAwal."' 
								AND b_pelayanan.unit_id = '".$tmpLayanan."'
								AND b_ms_kelas.id IN (4) 
							  UNION
							  SELECT 
								b_ms_pasien.nama,
								b_tindakan_kamar.tgl_in,
								b_tindakan_kamar.tgl_out,
								b_kunjungan.pulang 
							  FROM
								b_pelayanan 
								INNER JOIN b_kunjungan 
								  ON b_kunjungan.id = b_pelayanan.kunjungan_id 
								INNER JOIN b_tindakan_kamar 
								  ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
								INNER JOIN b_ms_pasien 
								  ON b_ms_pasien.id = b_pelayanan.pasien_id
								INNER JOIN b_ms_kelas
								  ON b_ms_kelas.id = b_tindakan_kamar.kelas_id 
							  WHERE DATE(b_tindakan_kamar.tgl_in) < '".$tglAwal."' 
								AND b_tindakan_kamar.tgl_out IS NULL 
								AND b_kunjungan.pulang = 0 
								AND b_pelayanan.unit_id = '".$tmpLayanan."'
								AND b_ms_kelas.id IN (4)) AS tbl";
					$rs18 = mysql_query($q18);
					$rw18 = mysql_fetch_array($rs18);
			?>
		  <tr>
		  	<td height="25" align="center" style="border:#8080ff 1px solid; border-top:none"><?php echo $i?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw2['jml']=='0') echo ''; else echo $rw2['jml']?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw3['jml']=='0') echo ''; else echo $rw3['jml']?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw4['jml']=='0') echo ''; else echo $rw4['jml']?></td>
			<?php  $rw5 = $rw2['jml'] + $rw3['jml'] + $rw4['jml']; ?>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw5=='0') echo ''; else echo $rw5?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw6['jml']=='0') echo ''; else echo $rw6['jml']?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw7['jml']=='0') echo ''; else echo $rw7['jml']?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw8['jml']=='0') echo ''; else echo $rw8['jml']?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw9['jml']=='0') echo ''; else echo $rw9['jml']?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw10=='0') echo ''; else echo $rw10?></td>
			<?php $rw11 = $rw6['jml'] + $rw7['jml'] + $rw8['jml']?>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw11=='0') echo ''; else echo $rw11?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php echo $rw12['jml'];?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw13['jml']=='0') echo ''; else echo $rw13['jml']?></td>
			<?php $rw14 = $rw5 - $rw11?>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw14=='0') echo ''; else echo $rw14?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw15['jml']=='0') echo ''; else echo $rw15['jml']?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw16['jml']=='0') echo ''; else echo $rw16['jml']?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw17['jml']=='0') echo ''; else echo $rw17['jml']?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw18['jml']=='0') echo ''; else echo $rw18['jml']?></td>
		  </tr>
          <?php
          $tot2 = $tot2 + $rw2['jml'];
		  $tot3 = $tot3 + $rw3['jml'];
		  $tot4 = $tot4 + $rw4['jml'];
		  $tot5 = $tot5 + $rw5;
		  $tot6 = $tot6 + $rw6['jml'];
		  $tot7 = $tot7 + $rw7['jml'];
		  $tot8 = $tot8 + $rw8['jml'];
		  $tot9 = $tot9 + $rw9['jml'];
		  $tot10 = $tot10 + $rw10;
		  $tot11 = $tot11 + $rw11;
		  $tot12 = $tot12 + $rw12['jml'];
		  $tot13 = $tot13 + $rw13['jml'];
		  $tot14 = $tot14 + $rw14;
		  $tot15 = $tot15 + $rw15['jml'];
		  $tot16 = $tot16 + $rw16['jml'];
		  $tot17 = $tot17 + $rw17['jml'];
		  $tot18 = $tot18 + $rw18['jml'];
		   }
		   ?>
          <tr>
		  	<td height="25" align="center" style="border:#8080ff 1px solid; border-top:none; font-weight:bold">Total</td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot2=='0') echo ''; else echo $tot2?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot3=='0') echo ''; else echo $tot3?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot4=='0') echo ''; else echo $tot4?></td>
			<?php  $rw5 = $rw2['jml'] + $rw3['jml'] + $rw4['jml']; ?>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot5=='0') echo ''; else echo $tot5?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot6=='0') echo ''; else echo $tot6?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot7=='0') echo ''; else echo $tot7?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot8=='0') echo ''; else echo $tot8?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot9=='0') echo ''; else echo $tot9?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot10=='0') echo ''; else echo $tot10?></td>
			<?php $rw11 = $rw6['jml'] + $rw7['jml'] + $rw8['jml']?>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot11=='0') echo ''; else echo $tot11?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot12=='0') echo ''; else echo $tot12?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot13=='0') echo ''; else echo $tot13?></td>
			<?php $rw14 = $rw5 - $rw11?>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot14=='0') echo ''; else echo $tot14?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot15=='0') echo ''; else echo $tot15?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot16=='0') echo ''; else echo $tot16?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot17=='0') echo ''; else echo $tot17?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($tot18=='0') echo ''; else echo $tot18?></td>
		  </tr>
	</table>	</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
	<tr>
		<td colspan="4" style="padding-top:5px; font-size:12px;" align="right">
			Printed By : <?php echo $rwPeg['nama']; ?>
		</td>
	</tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>
 </body>
</html>
