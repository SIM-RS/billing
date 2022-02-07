<?php
	session_start();
	include("../../koneksi/konek.php");
	include("../../sesi.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " b_tindakan.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " month(b_tindakan.tgl) = '$bln' and year(b_tindakan.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " b_tindakan.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
	mysql_free_result($rsPeg);
	
	$sqlKso = "SELECT id, nama FROM b_ms_kso where id = '".$_REQUEST['StatusPas']."'";
	$rsKso = mysql_query($sqlKso);
	$rwKso = mysql_fetch_array($rsKso);
	
	$jnsLay = $_REQUEST['JnsLayanan'];
	$penjamin = $_REQUEST['StatusPas']=='0'?"":" AND b_tindakan.kso_id='".$_REQUEST['StatusPas']."' ";
	$unit = ($_REQUEST['TmpLayanan']!='0')? $_REQUEST['TmpLayanan']:'semua';
	
	if($unit!='semua'){
		$sqlUnit = "SELECT u.id, u.nama, inap FROM b_ms_unit u where u.id=$unit";
		$rsUnit = mysql_query($sqlUnit);
		$rwUnit = mysql_fetch_array($rsUnit);
		mysql_free_result($rsUnit);
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title style="text-transform:capitalize;">Laporan Jasa Pelaksana <?php echo ($unit!='semua')?$rwUnit['nama']:$unit;?></title>
</head>

<body>

<table width="750" border="0" cellspacing="0" cellpadding="0" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <!--tr>
  	<td colspan="8" height="30">&nbsp;</td>
  </tr-->
  <tr>
    <td width="5%"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td align="center" height="70" valign="top" style="font-size:14px;text-transform:uppercase;"><b>Laporan Penghitungan Jasa Pelaksana <?php echo ($unit!='semua')?$rwUnit['nama']:$unit;?><br />Penjamin Pasien <?php if($_REQUEST['StatusPas']!=0) echo $rwKso['nama']; else echo "SEMUA" ?><br /><?php echo $Periode;?></b></td>
  </tr>
  <tr>
    <td align="right" height="28">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<?php
			if($_REQUEST['JnsLayanan']==1){
	?>
		<div id="jalan">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<tr height="30">
				<td width="5%" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">&nbsp;NO</td>
				<td width="35%" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">&nbsp;PELAKSANA</td>
				<td colspan="2" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">&nbsp;RETRIBUSI</td>
				<td colspan="2" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">&nbsp;R. JAPEL</td>
				<td colspan="2" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">&nbsp;TINDAKAN</td>
				<td colspan="2" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">&nbsp;T. JAPEL</td>
				<td colspan="2" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid; border-right:1px solid;">&nbsp;JUMLAH (R+T)</td>
			  </tr>
			  <?php
					 $sqlJapel = "SELECT b_ms_pegawai.id, b_ms_pegawai.nama
			FROM b_ms_pegawai
			INNER JOIN b_tindakan ON b_tindakan.user_id = b_ms_pegawai.id
			INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id=b_pelayanan.id
			WHERE ".($unit!='semua'?"b_pelayanan.unit_id= '".$unit."' AND":"")."
			$waktu $penjamin
			GROUP BY b_ms_pegawai.nama ORDER BY b_ms_pegawai.nama";
			//echo $sqlJapel."<br>";
					$rsJapel = mysql_query($sqlJapel);
					$no = 1;
					$jmlRet = 0;
					$jmlJapel = 0;
					$jmlTind = 0;
					$jmlTJapel = 0;
					$jmlJml = 0;
					while($rwJapel = mysql_fetch_array($rsJapel))
					{
						///
						$sqlRetribusi = "SELECT SUM(b_tindakan.qty*b_tindakan.biaya) as retribusi,SUM(b_tindakan.qty*b_tindakan_komponen.tarip) AS japel FROM b_tindakan 
			LEFT JOIN b_tindakan_komponen ON b_tindakan_komponen.tindakan_id=b_tindakan.id
			INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id=b_tindakan.ms_tindakan_kelas_id
			INNER JOIN b_ms_tindakan ON b_ms_tindakan.id=b_ms_tindakan_kelas.ms_tindakan_id
			INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id=b_pelayanan.id
			WHERE ".($unit!='semua'?"b_pelayanan.unit_id= '".$unit."' AND":"")."
			b_ms_tindakan.klasifikasi_id=11 AND (b_tindakan_komponen.ms_komponen_id = 2 OR b_tindakan_komponen.ms_komponen_id IS NULL) 
			AND b_tindakan.user_id= '".$rwJapel['id']."' AND $waktu $penjamin";
						//*/
						//echo $sqlRetribusi."<br>";
						$rsRetribusi = mysql_query($sqlRetribusi);
						$rwRetribusi = mysql_fetch_array($rsRetribusi);
						mysql_free_result($rsRetribusi);
						
						$sqlTindakan="SELECT SUM(b_tindakan.qty*b_tindakan.biaya) AS tindakan,SUM(b_tindakan.qty * IFNULL(b_tindakan_komponen.tarip,0)) AS tjapel FROM b_tindakan 
			LEFT JOIN b_tindakan_komponen ON b_tindakan_komponen.tindakan_id = b_tindakan.id
			INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id=b_tindakan.ms_tindakan_kelas_id
			INNER JOIN b_ms_tindakan ON b_ms_tindakan.id=b_ms_tindakan_kelas.ms_tindakan_id
			INNER JOIN b_pelayanan ON b_tindakan.pelayanan_id=b_pelayanan.id
			WHERE ".($unit!='semua'?"b_pelayanan.unit_id= '".$unit."' AND":"")."
			b_ms_tindakan.klasifikasi_id<>11 AND (b_tindakan_komponen.ms_komponen_id = 2 OR b_tindakan_komponen.ms_komponen_id IS NULL) 
			AND b_tindakan.user_id = '".$rwJapel['id']."' AND $waktu $penjamin";
						//echo $sqlTindakan."<br>";
						$rsTindakan = mysql_query($sqlTindakan);
						$rwTindakan = mysql_fetch_array($rsTindakan);
						mysql_free_result($rsTindakan);
						
			  ?>
			  <tr>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="center"><?php echo $no;?></td>
				<td style="border-left:1px solid; border-bottom:1px solid; text-transform:uppercase;">&nbsp;<?php echo $rwJapel['nama'];?></td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="right">Rp.&nbsp;</td>
				<td style="border-bottom:1px solid;" align="right"><?php echo number_format($rwRetribusi['retribusi'],0,",",".");?>&nbsp;&nbsp;&nbsp;</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="right">Rp.&nbsp;</td>
				<td style="border-bottom:1px solid;" align="right"><?php echo number_format($rwRetribusi['japel'],0,",",".");?>&nbsp;&nbsp;&nbsp;</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="right">Rp.&nbsp;</td>
				<td style="border-bottom:1px solid;" align="right"><?php echo number_format($rwTindakan['tindakan'],0,",",".");?>&nbsp;&nbsp;&nbsp;</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="right">Rp.&nbsp;</td>
				<td style="border-bottom:1px solid;" align="right"><?php echo number_format($rwTindakan['tjapel'],0,",",".");?>&nbsp;&nbsp;&nbsp;</td>	
				<td style="border-left:1px solid; border-bottom:1px solid;" align="right">Rp.&nbsp;</td>
				<?php $jml = $rwRetribusi['retribusi'] + $rwTindakan['tindakan'];?>
				<td style="border-bottom:1px solid; border-right:1px solid;" align="right"><?php echo number_format($jml,0,",","."); ?>&nbsp;&nbsp;&nbsp;</td>
			  </tr>
			  <?php
					$no++;
					$jmlRet = $jmlRet + $rwRetribusi['retribusi'];
					$jmlJapel = $jmlJapel + $rwRetribusi['japel'];
					$jmlTind = $jmlTind + $rwTindakan['tindakan'];
					$jmlTJapel = $jmlTJapel + $rwTindakan['tjapel'];
					$jmlJml = $jmlJml + $jml;
					
					}
			  ?>
			  <tr style="font-weight:bold;">
				<td style="border-left:1px solid; border-bottom:1px solid;" align="center">&nbsp;</td>
				<td style="border-left:1px solid; border-bottom:1px solid;">&nbsp;</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="right">Rp.&nbsp;</td>
				<td style="border-bottom:1px solid;" align="right"><?php echo number_format($jmlRet,0,",",".");?>&nbsp;&nbsp;&nbsp;</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="right">Rp.&nbsp;</td>
				<td style="border-bottom:1px solid;" align="right"><?php echo number_format($jmlJapel,0,",",".");?>&nbsp;&nbsp;&nbsp;</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="right">Rp.&nbsp;</td>
				<td style="border-bottom:1px solid;" align="right"><?php echo number_format($jmlTind,0,",",".");?>&nbsp;&nbsp;&nbsp;</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="right">Rp.&nbsp;</td>
				<td style="border-bottom:1px solid;" align="right"><?php echo number_format($jmlTJapel,0,",",".");?>&nbsp;&nbsp;&nbsp;</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="right">Rp.&nbsp;</td>
				<td style="border-bottom:1px solid; border-right:1px solid;" align="right"><?php echo number_format($jmlJml,0,",","."); ?>&nbsp;&nbsp;&nbsp;</td>
			  </tr>
			</table>
		</div>
	<?php 
			}
			else if($_REQUEST['TmpLayanan']==45)
			{
	?>
		<div id="inap">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<tr height="30">
				<td width="5%" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">&nbsp;NO</td>
				<td width="35%" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">&nbsp;PELAKSANA</td>
				<td colspan="2" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">&nbsp;RETRIBUSI</td>
				<td colspan="2" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">&nbsp;R. JAPEL</td>
				<td colspan="2" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">&nbsp;TINDAKAN</td>
				<td colspan="2" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid;">&nbsp;T. JAPEL</td>
				<td colspan="2" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid; border-right:1px solid;">&nbsp;JUMLAH (R+T)</td>
			  </tr>
			  <?php
					 $sqlJapel = "SELECT b_ms_pegawai.id, b_ms_pegawai.nama
			FROM b_ms_pegawai
			INNER JOIN b_tindakan ON b_tindakan.user_id = b_ms_pegawai.id
			INNER JOIN b_tindakan_komponen ON b_tindakan_komponen.tindakan_id = b_tindakan.id
			WHERE ".($unit!='semua'?"b_tindakan.ms_tindakan_unit_id= '".$unit."' AND":"")."
			b_ms_pegawai.spesialisasi_id = '62' AND $waktu $penjamin
			GROUP BY b_ms_pegawai.nama ORDER BY b_ms_pegawai.nama";
			//echo $sqlJapel."<br>";
					$rsJapel = mysql_query($sqlJapel);
					$no = 1;
					$jmlRet = 0;
					$jmlJapel = 0;
					$jmlTind = 0;
					$jmlTJapel = 0;
					$jmlJml = 0;
					while($rwJapel = mysql_fetch_array($rsJapel))
					{
						///
						 $sqlRetribusi = "SELECT SUM(b_tindakan.biaya) as retribusi,SUM(b_tindakan_komponen.tarip) AS japel FROM b_tindakan 
			INNER JOIN b_tindakan_komponen ON b_tindakan_komponen.tindakan_id=b_tindakan.id
			INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id=b_tindakan.ms_tindakan_kelas_id
			INNER JOIN b_ms_tindakan ON b_ms_tindakan.id=b_ms_tindakan_kelas.ms_tindakan_id
			INNER JOIN b_ms_kelompok_tindakan ON b_ms_kelompok_tindakan.id = b_ms_tindakan.kel_tindakan_id
			WHERE ".($unit!='semua'?"b_tindakan.ms_tindakan_unit_id= '".$unit."' AND":"")."
			b_ms_tindakan.klasifikasi_id=11 AND b_tindakan_komponen.ms_komponen_id = 2 AND b_tindakan.user_id= '".$rwJapel['id']."'
			AND $waktu $penjamin";
						//*/
						//echo $sqlRetribusi."<br>";
						$rsRetribusi = mysql_query($sqlRetribusi);
						$rwRetribusi = mysql_fetch_array($rsRetribusi);
						mysql_free_result($rsRetribusi);
						
						$sqlTindakan="SELECT SUM(b_tindakan.biaya) AS tindakan,SUM(b_tindakan_komponen.tarip) AS tjapel FROM b_tindakan_komponen 
			INNER JOIN b_tindakan ON b_tindakan_komponen.tindakan_id = b_tindakan.id
			INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id=b_tindakan.ms_tindakan_kelas_id
			INNER JOIN b_ms_tindakan ON b_ms_tindakan.id=b_ms_tindakan_kelas.ms_tindakan_id
			INNER JOIN b_ms_kelompok_tindakan ON b_ms_kelompok_tindakan.id = b_ms_tindakan.kel_tindakan_id
			WHERE ".($unit!='semua'?"b_tindakan.ms_tindakan_unit_id= '".$unit."' AND":"")."
			b_ms_tindakan.klasifikasi_id<>11 AND b_tindakan_komponen.ms_komponen_id = 2 AND b_tindakan.user_id = '".$rwJapel['id']."'
			AND $waktu $penjamin";
						$rsTindakan = mysql_query($sqlTindakan);
						$rwTindakan = mysql_fetch_array($rsTindakan);
						mysql_free_result($rsTindakan);
						
			  ?>
			  <tr>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="center"><?php echo $no;?></td>
				<td style="border-left:1px solid; border-bottom:1px solid; text-transform:uppercase;">&nbsp;<?php echo $rwJapel['nama'];?></td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="right">Rp.&nbsp;</td>
				<td style="border-bottom:1px solid;" align="right"><?php echo number_format($rwRetribusi['retribusi'],0,",",".");?>&nbsp;&nbsp;&nbsp;</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="right">Rp.&nbsp;</td>
				<td style="border-bottom:1px solid;" align="right"><?php echo number_format($rwRetribusi['japel'],0,",",".");?>&nbsp;&nbsp;&nbsp;</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="right">Rp.&nbsp;</td>
				<td style="border-bottom:1px solid;" align="right"><?php echo number_format($rwTindakan['tindakan'],0,",",".");?>&nbsp;&nbsp;&nbsp;</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="right">Rp.&nbsp;</td>
				<td style="border-bottom:1px solid;" align="right"><?php echo number_format($rwTindakan['tjapel'],0,",",".");?>&nbsp;&nbsp;&nbsp;</td>	
				<td style="border-left:1px solid; border-bottom:1px solid;" align="right">Rp.&nbsp;</td>
				<?php $jml = $rwRetribusi['retribusi'] + $rwTindakan['tindakan'];?>
				<td style="border-bottom:1px solid; border-right:1px solid;" align="right"><?php echo number_format($jml,0,",","."); ?>&nbsp;&nbsp;&nbsp;</td>
			  </tr>
			  <?php
					$no++;
					$jmlRet = $jmlRet + $rwRetribusi['retribusi'];
					$jmlJapel = $jmlJapel + $rwRetribusi['japel'];
					$jmlTind = $jmlTind + $rwTindakan['tindakan'];
					$jmlTJapel = $jmlTJapel + $rwTindakan['tjapel'];
					$jmlJml = $jmlJml + $jml;
					
					}
			  ?>
			  <tr style="font-weight:bold;">
				<td style="border-left:1px solid; border-bottom:1px solid;" align="center">&nbsp;</td>
				<td style="border-left:1px solid; border-bottom:1px solid;">&nbsp;</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="right">Rp.&nbsp;</td>
				<td style="border-bottom:1px solid;" align="right"><?php echo number_format($jmlRet,0,",",".");?>&nbsp;&nbsp;&nbsp;</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="right">Rp.&nbsp;</td>
				<td style="border-bottom:1px solid;" align="right"><?php echo number_format($jmlJapel,0,",",".");?>&nbsp;&nbsp;&nbsp;</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="right">Rp.&nbsp;</td>
				<td style="border-bottom:1px solid;" align="right"><?php echo number_format($jmlTind,0,",",".");?>&nbsp;&nbsp;&nbsp;</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="right">Rp.&nbsp;</td>
				<td style="border-bottom:1px solid;" align="right"><?php echo number_format($jmlTJapel,0,",",".");?>&nbsp;&nbsp;&nbsp;</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="right">Rp.&nbsp;</td>
				<td style="border-bottom:1px solid; border-right:1px solid;" align="right"><?php echo number_format($jmlJml,0,",","."); ?>&nbsp;&nbsp;&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
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
				<td>&nbsp;</td>
			  </tr>
			  <tr height="30">
				<td align="center" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;">NO</td>
				<td style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;">&nbsp;PELAKSANA</td>
				<td colspan="2" align="right" style="border-left:1px solid; border-bottom:1px solid; border-top:1px solid; border-right:1px solid;">TOTAL&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <?php 
					$qKonsul = "SELECT b_ms_pegawai.nama AS pelaksana, b_ms_tindakan.nama, SUM(b_tindakan.biaya) AS jml FROM b_pelayanan
INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id
INNER JOIN b_ms_klasifikasi ON b_ms_klasifikasi.id = b_ms_tindakan.klasifikasi_id
INNER JOIN b_ms_pegawai ON b_ms_pegawai.id = b_tindakan.user_id
WHERE b_pelayanan.unit_id = '".$unit."' AND b_ms_klasifikasi.id = '14'
AND $waktu $penjamin GROUP BY b_ms_pegawai.id";
					//echo $qKonsul."<br>";
					$rsKonsul = mysql_query($qKonsul);
					$no = 1;
					$JmlKonsul = 0;
					while($rwKonsul = mysql_fetch_array($rsKonsul))
					{
			  ?>
			  <tr>
				<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php echo $no;?></td>
				<td style="border-left:1px solid; border-bottom:1px solid;">&nbsp;<?php echo $rwKonsul['pelaksana'];?></td>
				<td align="right" style="border-left:1px solid; border-bottom:1px solid;">Rp.</td>
				<td style="border-right:1px solid; border-bottom:1px solid;" align="right"><?php echo number_format($rwKonsul['jml'],0,",",".");?>&nbsp;&nbsp;&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <?php
					$no++;
					$JmlKonsul = $JmlKonsul + $rwKonsul['jml'];
					}
			  ?>
			  <tr style="font-weight:bold;">
				<td align="center" style="border-left:1px solid; border-bottom:1px solid;">&nbsp;</td>
				<td style="border-left:1px solid; border-bottom:1px solid;">&nbsp;</td>
				<td align="right" style="border-left:1px solid; border-bottom:1px solid;">Rp.</td>
				<td style="border-right:1px solid; border-bottom:1px solid;" align="right"><?php echo number_format($JmlKonsul,2,",",".");?>&nbsp;&nbsp;&nbsp;</td>
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
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr height="30">
				<td align="center" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;">NO</td>
				<td style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;">&nbsp;PELAKSANA</td>
				<td colspan="2" align="right" style="border-left:1px solid; border-bottom:1px solid; border-top:1px solid; border-right:1px solid;">TOTAL&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <?php 
					$qVisite = "SELECT b_ms_pegawai.nama AS pelaksana, b_ms_tindakan.nama, SUM(b_tindakan.biaya) AS jml FROM b_pelayanan
INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id
INNER JOIN b_ms_klasifikasi ON b_ms_klasifikasi.id = b_ms_tindakan.klasifikasi_id
INNER JOIN b_ms_pegawai ON b_ms_pegawai.id = b_tindakan.user_id
WHERE b_pelayanan.unit_id = '".$unit."' AND b_ms_klasifikasi.id = '13'
AND $waktu $penjamin GROUP BY b_ms_pegawai.id";					
					$rsVisite = mysql_query($qVisite);
					$no = 1;
					$JmlVisite = 0;
					while($rwVisite = mysql_fetch_array($rsVisite))
					{
			  ?>
			  <tr>
				<td align="center" style="border-left:1px solid; border-bottom:1px solid;"><?php echo $no;?></td>
				<td style="border-left:1px solid; border-bottom:1px solid;">&nbsp;<?php echo $rwVisite['pelaksana'];?></td>
				<td align="right" style="border-left:1px solid; border-bottom:1px solid;">Rp.</td>
				<td style="border-right:1px solid; border-bottom:1px solid;" align="right"><?php echo number_format($rwVisite['jml'],2,",",".");?>&nbsp;&nbsp;&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <?php
					$no++;
					$JmlVisite = $JmlVisite + $rwVisite['jml'];
					}
			  ?>
			  <tr style="font-weight:bold;">
				<td align="center" style="border-left:1px solid; border-bottom:1px solid;">&nbsp;</td>
				<td style="border-left:1px solid; border-bottom:1px solid;">&nbsp;</td>
				<td align="right" style="border-left:1px solid; border-bottom:1px solid;">Rp.</td>
				<td style="border-right:1px solid; border-bottom:1px solid;" align="right"><?php echo number_format($JmlVisite,2,",",".");?>&nbsp;&nbsp;&nbsp;</td>
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
				<td>&nbsp;</td>
				<td align="right" style="font-size:11px;">Rp.&nbsp;</td>
				<td align="right" style="font-size:11px;"><?php echo number_format($jmlJml,2,",",".");?>&nbsp;&nbsp;&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right" style="font-size:11px;">Rp.&nbsp;</td>
				<td align="right" style="font-size:11px;"><?php echo number_format($JmlKonsul,2,",",".");?>&nbsp;&nbsp;&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right" style="font-size:11px;">Rp.&nbsp;</td>
				<td align="right" style="font-size:11px;"><?php echo number_format($JmlVisite,2,",",".");?>&nbsp;&nbsp;&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right" style="border-top:1px solid; font-size:12px; font-weight:bold;">Rp.&nbsp;</td>
				<?php
					$total = $jmlJml + $JmlKonsul + $JmlVisite;
				?>
				<td style="border-top:1px solid; font-size:12px;" align="right"><b><?php echo number_format($total,2,",",".");?></b>&nbsp;&nbsp;&nbsp;</td>
			  </tr>
		</table>
		</div>
	<?php
			}
	?>	</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp; </td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td align="right">Tgl Cetak: <?=$date_now;?></td>
  </tr>
  <tr>
  	<td align="right">Yang Mencetak</td>
  </tr>
  <tr>
  	<td height="50">
	<tr id="trTombol">
        <td colspan="6" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
	
  <tr>
	<td align="right"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
</table>
</body>
<script type="text/JavaScript">
/*
try{	
formatF4();
}catch(e){
window.location='../../addon/jsprintsetup.xpi';
}*/
    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		/*try{
			mulaiPrint();
		}
		catch(e){
			window.print();
		}*/
		
		window.print();
		window.close();
        }
    }
</script>
</html>
<?php
mysql_close($konek);
?>