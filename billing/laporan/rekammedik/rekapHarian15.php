<?php
session_start();
include("../../sesi.php");
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
	
	/* $cmbBln=$_POST['cmbBln'];
	if(substr($cmbBln/3,0,1)==0)
		$triBln = array('1','2','3');
	elseif(substr($cmbBln/3,0,1)==1)
		$triBln = array('4','5','6');
	elseif(substr($cmbBln/3,0,1)==2)
		$triBln = array('7','8','9');
	else
		$triBln = array('10','11','12');
	$cmbThn=$thn = $_POST['cmbThn'];
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember','1'=>'Januari','2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September'); */
	//======Pengambilan Ruang================
	$sqlUnit = "SELECT id,nama FROM b_ms_unit WHERE id = '".$tmpLayanan."'";
	$rsUnit = mysql_query($sqlUnit);
	$rwUnit = mysql_fetch_array($rsUnit);
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
  	<td colspan="2"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td colspan="2" align="center" style="font-weight:bold; font-size:14px;" height="70">REKAPITULASI HARIAN PASIEN RAWAT INAP&nbsp;</td>
  </tr>
  <tr>
    <td width="70%" style="font-weight:bold">&nbsp;</td>
    <td width="30%" style="font-weight:bold">Ruang Rawat Inap&nbsp;:&nbsp;<?php echo $rwUnit['nama']?></td>
  </tr>
  <tr>
    <td style="font-weight:bold">Data Bulan&nbsp;:&nbsp;<?php echo $arrBln[$bln]?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tahun&nbsp;:&nbsp;<?php echo $thn?>    </td>
	<?php 
			$qTt = mysql_query("SELECT SUM(jumlah_tt) AS jml FROM b_ms_kamar WHERE b_ms_kamar.unit_id='".$tmpLayanan."' AND aktif=1");
			$wTt = mysql_fetch_array($qTt);		
	?>
    <td style="font-weight:bold">Tempat Tidur Tersedia&nbsp;:&nbsp;<?php echo $wTt['jml'];?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
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
				for($i=1;$i<=$tgl;$i++)
				{
		  			$tglAwal=$thn."-".$bln."-".$i;
					
					$q2 = "SELECT COUNT(b_tindakan_kamar.pelayanan_id) AS jml FROM b_pelayanan
						INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
						WHERE DATE(b_tindakan_kamar.tgl_in)<'".$tglAwal."' AND (DATE(b_pelayanan.tgl_krs)>='".$tglAwal."' OR b_tindakan_kamar.tgl_out IS NULL OR DATE(b_tindakan_kamar.tgl_out)>='".$tglAwal."') AND b_pelayanan.unit_id='".$tmpLayanan."'";
					$rs2 = mysql_query($q2);
					$rw2 = mysql_fetch_array($rs2);
					
					$q3 = "SELECT COUNT(b_tindakan_kamar.pelayanan_id) AS jml FROM b_pelayanan
						INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
						INNER JOIN b_ms_unit ON b_ms_unit.id = b_tindakan_kamar.unit_id_asal
						WHERE DATE(b_tindakan_kamar.tgl_in) = '".$tglAwal."' AND b_pelayanan.unit_id='".$tmpLayanan."' AND b_ms_unit.inap = '0'";
					$rs3 = mysql_query($q3);
					$rw3 = mysql_fetch_array($rs3);
					
					$q4 = "SELECT COUNT(b_tindakan_kamar.pelayanan_id) AS jml FROM b_pelayanan
						INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
						INNER JOIN b_ms_unit ON b_ms_unit.id = b_tindakan_kamar.unit_id_asal
						WHERE DATE(b_tindakan_kamar.tgl_in) = '".$tglAwal."' AND b_pelayanan.unit_id='".$tmpLayanan."' AND b_ms_unit.inap = '1'";
					$rs4 = mysql_query($q4);
					$rw4 = mysql_fetch_array($rs4);
					
					
					$q6 = "SELECT COUNT(b_tindakan_kamar.pelayanan_id) AS jml FROM b_pelayanan
						INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
						INNER JOIN b_ms_unit ON b_ms_unit.id=b_tindakan_kamar.unit_id_asal
						WHERE DATE(b_tindakan_kamar.tgl_in)='".$tglAwal."' AND b_ms_unit.id='".$tmpLayanan."'";
					$rs6 = mysql_query($q6);
					$rw6 = mysql_fetch_array($rs6);
					
					$q7 = "SELECT COUNT(b_tindakan_kamar.pelayanan_id) AS jml FROM b_pelayanan
						INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
						LEFT JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_tindakan_kamar.pelayanan_id
						WHERE DATE(b_tindakan_kamar.tgl_out)='".$tglAwal."'
						AND b_pasien_keluar.cara_keluar != 'Meninggal' AND b_pelayanan.unit_id='".$tmpLayanan."'";
					$rs7 = mysql_query($q7);
					$rw7 = mysql_fetch_array($rs7);
					
					$q8 = "SELECT COUNT(b_tindakan_kamar.pelayanan_id) AS jml FROM b_pelayanan
						INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
						LEFT JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_tindakan_kamar.pelayanan_id
						WHERE DATE(b_tindakan_kamar.tgl_out)='".$tglAwal."'
						AND b_pasien_keluar.cara_keluar LIKE '%Meninggal' AND b_pelayanan.unit_id='".$tmpLayanan."'";
					$rs8 = mysql_query($q8);
					$rw8 = mysql_fetch_array($rs8);
										
					$q12 = "SELECT SUM(DATEDIFF(DATE(b_tindakan_kamar.tgl_out),DATE(b_tindakan_kamar.tgl_in))) AS jml  FROM b_pelayanan 
INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id 
LEFT JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_tindakan_kamar.pelayanan_id 
WHERE DATE(b_tindakan_kamar.tgl_out)='".$tglAwal."' AND b_pelayanan.unit_id='".$tmpLayanan."'";
					$rs12 = mysql_query($q12);
					$rw12 = mysql_fetch_array($rs12); 
					
					$q13 = "SELECT COUNT(b_pelayanan.id) AS jml FROM b_pelayanan INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_tindakan_kamar.pelayanan_id 
WHERE DATE(b_tindakan_kamar.tgl_in) = '".$tglAwal."' AND (DATE(b_tindakan_kamar.tgl_out)='".$tglAwal."' OR DATE(b_pelayanan.tgl_krs)='".$tglAwal."') AND b_pelayanan.unit_id='".$tmpLayanan."'";
					$rs13 = mysql_query($q13);
					$rw13 = mysql_fetch_array($rs13); 
					
					
					$q15 = "SELECT COUNT(b_pelayanan.id) AS jml FROM b_pelayanan INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_kelas ON b_ms_kelas.id=b_tindakan_kamar.kelas_id WHERE DATE(b_tindakan_kamar.tgl_in)<'".$tglAwal."' AND DATE(b_tindakan_kamar.tgl_out)>'".$tglAwal."' AND b_pelayanan.unit_id='".$tmpLayanan."' AND (b_ms_kelas.id=5 OR b_ms_kelas.id=6)";
					$rs15 = mysql_query($q15);
					$rw15 = mysql_fetch_array($rs15);
					
					if($jnsLayanan==50){
						$kls1 = "AND b_ms_kelas.id=7";
					}else{
						$kls1 = "AND b_ms_kelas.id=2";
					}
					$q16 = "SELECT COUNT(b_pelayanan.id) AS jml FROM b_pelayanan INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_kelas ON b_ms_kelas.id=b_tindakan_kamar.kelas_id WHERE DATE(b_tindakan_kamar.tgl_in)<'".$tglAwal."' AND DATE(b_tindakan_kamar.tgl_out)>'".$tglAwal."' AND b_pelayanan.unit_id='".$tmpLayanan."' $kls1";
					$rs16 = mysql_query($q16);
					$rw16 = mysql_fetch_array($rs16);
					
					if($jnsLayanan==50){
						$kls2 = "AND b_ms_kelas.id=8";
					}else{
						$kls2 = "AND b_ms_kelas.id=3";
					}
					$q17 = "SELECT COUNT(b_pelayanan.id) AS jml FROM b_pelayanan INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_kelas ON b_ms_kelas.id=b_tindakan_kamar.kelas_id WHERE DATE(b_tindakan_kamar.tgl_in)<'".$tglAwal."' AND DATE(b_tindakan_kamar.tgl_out)>'".$tglAwal."' AND b_pelayanan.unit_id='".$tmpLayanan."' $kls2";
					$rs17 = mysql_query($q17);
					$rw17 = mysql_fetch_array($rs17);
					
					$q18 = "SELECT COUNT(b_pelayanan.id) AS jml FROM b_pelayanan INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_kelas ON b_ms_kelas.id=b_tindakan_kamar.kelas_id WHERE DATE(b_tindakan_kamar.tgl_in)<'".$tglAwal."' AND DATE(b_tindakan_kamar.tgl_out)>'".$tglAwal."' AND b_pelayanan.unit_id='".$tmpLayanan."' AND b_ms_kelas.id=4";
					$rs18 = mysql_query($q18);
					$rw18 = mysql_fetch_array($rs18);
					
			?>
		  <tr>
		  	<td height="25" align="center" style="border:#8080ff 1px solid; border-top:none"><?php echo $i?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php echo $rw2['jml']?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php echo $rw3['jml']?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php echo $rw4['jml']?></td>
			<?php  $rw5 = $rw2['jml'] + $rw3['jml'] + $rw4['jml']; ?>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php echo $rw5?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php echo $rw6['jml']?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php echo $rw7['jml']?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php echo $rw8['jml']?></td>
			<?php
				if($rw8['jml']!=0){
					$q9 = "SELECT COUNT(j.jml) AS jml FROM 
						(SELECT b_pasien_keluar.pelayanan_id AS jml,
						IF(b_tindakan_kamar.status_out=0,(IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,
						NOW()),b_tindakan_kamar.tgl_in)=0,1, 
						DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in))), 
						(IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)=0,0, 
						DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)))) AS qtyHari, 
						b_pasien_keluar.cara_keluar, b_pasien_keluar.keadaan_keluar
						FROM b_pelayanan INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
						INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
						WHERE b_pelayanan.unit_id='".$tmpLayanan."' AND DATE(b_pasien_keluar.tgl_act)='".$tglAwal."'
						AND b_pasien_keluar.cara_keluar LIKE '%meninggal%') AS j WHERE j.qtyHari<2";
					$rs9 = mysql_query($q9);
					$rw9 = mysql_fetch_array($rs9);
					
					$q10 = "SELECT COUNT(j.jml) AS jml FROM 
						(SELECT b_pasien_keluar.pelayanan_id AS jml,
						IF(b_tindakan_kamar.status_out=0,(IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,
						NOW()),b_tindakan_kamar.tgl_in)=0,1, 
						DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in))), 
						(IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)=0,0, 
						DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)))) AS qtyHari, 
						b_pasien_keluar.cara_keluar, b_pasien_keluar.keadaan_keluar
						FROM b_pelayanan INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
						INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
						WHERE b_pelayanan.unit_id='".$tmpLayanan."' AND DATE(b_pasien_keluar.tgl_act)='".$tglAwal."'
						AND b_pasien_keluar.cara_keluar LIKE '%meninggal%') AS j WHERE j.qtyHari>2";
					$rs10 = mysql_query($q10);
					$rw10 = mysql_fetch_array($rs10);
				}
			?>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw8['jml']==0) echo 0; else echo $rw9['jml']?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php if($rw8['jml']==0) echo 0; else echo $rw10['jml']?></td>
			<?php $rw11 = $rw6['jml'] + $rw7['jml'] + $rw8['jml']?>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php echo $rw11?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php echo $rw12['jml']?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php echo $rw13['jml']?></td>
			<?php $rw14 = $rw5 - $rw11?>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php echo $rw14?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php echo $rw15['jml']?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php echo $rw16['jml']?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php echo $rw17['jml']?></td>
			<td align="center" style="border-bottom:#8080ff solid 1px; border-right:#8080ff solid 1px"><?php echo $rw18['jml']?></td>
		  </tr>
		  <?php }?>
	</table>	</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
 </body>
</html>
