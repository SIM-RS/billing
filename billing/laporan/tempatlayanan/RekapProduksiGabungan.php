<?php
session_start();
include("../../sesi.php");
?>
<?php 
if($_POST['export']=='excel'){
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="Lap Buk Realisasi Produksi.xls"');
}
?>
<title>Rekapitulasi Kunjungan</title>
<?php
include("../../koneksi/konek.php");
$arrBln = array('01'=>'Januari','02'=>'Pebruari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'Nopember','12'=>'Desember');
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$jam = date("G:i");
$waktu = $_POST['cmbWaktu'];
$instansi = $_POST['cmbInstansi'];
switch ($instansi){
	case 1:
		$jdl_rpt="RS PRIMA HUSADA CIPTA MEDAN";
		break;
	case 2:
		$jdl_rpt="KLINIK KRAKATAU";
		break;
	case 3:
		$jdl_rpt="KLINIK BICT";
		break;
	default:
		$jdl_rpt="RS PRIMA HUSADA CIPTA MEDAN + KLINIK KRAKATAU + APOTEK";
		break;
}
if($waktu == 'Harian'){
	$tglAwal = explode('-',$_REQUEST['tglAwal2']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	$tglAwal3 = $tglAwal[2].'-'.($tglAwal[1]-1).'-'.$tglAwal[0];
	$waktu = " AND p.tgl = '$tglAwal2' ";
	$waktu2 = " AND p.tgl = '$tglAwal3' ";
	$waktu_ranap = " AND k.tgl = '$tglAwal2' ";
	$waktu_ranap2 = " AND k.tgl = '$tglAwal3' ";
	
	$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
}
else if($waktu == 'Bulanan'){
	$bln = $_POST['cmbBln'];
	$bln2 = $_POST['cmbBln']-1;
	$thn = $_POST['cmbThn'];
	$thn2 = $_POST['cmbThn'];
	
	if($bln==12){
		$thn2 = $_POST['cmbThn']-1;
		$bln2 = 01;
	}

	$waktu = " AND month(p.tgl) = '$bln' and year(p.tgl) = '$thn' ";
	$waktu2 = " AND p.tgl >= '$thn-01-01' and p.tgl < '$thn-$bln-01' ";
	$waktu_ranap = " AND month(p.tgl_out) = '$bln' and year(p.tgl_out) = '$thn' ";
	$waktu_ranap2 = " AND p.tgl_out >= '$thn-01-01 00:00:00' AND p.tgl_out < '$thn-$bln-01 00:00:00' ";
	$Periode = "Bulan $arrBln[$bln] Tahun $thn";
}
else{
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	//echo $arrBln[$tglAwal[1]];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	
	$waktu = " AND k.tgl between '$tglAwal2' and '$tglAkhir2' ";
	$waktu_ranap = " AND k.tgl_in between '$tglAwal2' and '$tglAkhir2' ";
	
	$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
}
	
	$sqlJnsLay = "SELECT nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsJnsLay = mysql_query($sqlJnsLay);
	$rwJnsLay = mysql_fetch_array($rsJnsLay);
	
if($_REQUEST['TmpLayanan']!=0){
	$sqlTmpLay = "SELECT nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsTmpLay = mysql_query($sqlTmpLay);
	$rwTmpLay = mysql_fetch_array($rsTmpLay);
	$fUnit = " pl.unit_id = ".$_REQUEST['TmpLayanan'];
	$tmpNama = $rwTmpLay['nama'];
}else{
	$fUnit = " pl.jenis_layanan = ".$_REQUEST['JnsLayanan'];
	$tmpNama = "SEMUA";
}

$stsPas=$_REQUEST['StatusPas'];
if($stsPas != 0) {
    $fKso = " AND k.kso_id = $stsPas ";
    $qJnsLay=mysql_query("select nama from b_ms_kso where id=".$stsPas);
    $rwJnsLay=mysql_fetch_array($qJnsLay);
}

$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
$rsPeg = mysql_query($sqlPeg);
$rwPeg = mysql_fetch_array($rsPeg);
?> 
<table width="858" height="498" border="0" cellpadding="0" cellspacing="0"  style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td height="70" valign="top" style="text-align:center; font-weight:bold; font-size:14px; text-transform:uppercase">REALISASI PRODUKSI <br>
		  <u><?php echo $jdl_rpt; ?><br /><?php echo $Periode;?></u></td>
	</tr>
	<tr>
		<td>
			<table border="1" cellpadding="0" cellspacing="0" width="100%" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; border:1px solid; border-collapse:collapse;">
				<tr style="font-size:12px; font-weight:bold; height:30">
				  <td width="5%" rowspan="2" style="text-align:center;">No</td>
					<td width="20%" rowspan="2" style=" text-align:center;">URAIAN</td>
					<td width="11%" rowspan="2" style=" text-align:center;">SATUAN</td>
					<td width="14%" rowspan="2" style="text-align:center;">ANGGARAN TAHUN <?php echo $thn; ?> </td>
					<td colspan="3" style=" text-align:center;">REALISASI</td>
					<td width="14%" rowspan="2" style="text-align:center;">DEVIASI % (7/4) </td>
				</tr>
				<tr style="font-size:12px; font-weight:bold; height:30">
				  <td width="13%" style=" text-align:center;">S.D BULAN LALU </td>
			      <td width="11%" style=" text-align:center;">BULAN INI </td>
			      <td width="12%" style=" text-align:center;">S.D BULAN INI </td>
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
			<?php   
			$no=0;
			///tambahan igd *decyber
			$visitUmum = 392;
			$visitSpe = 399;
			///tambahan igd *decyber
			//di $idKUmumRS, 45
			$idKUmumRS='0,2,45';
			$idKUmumKrakatau='0,198';
			$idKUmumBICT='0,197';
			
			$idKSpesialisRS='3,4,5,6,10,11,176,181,182';
			$idKSpesialisKrakatau='209,210,211,212,218';
			$idKSpesialisBICT='0';
			
			$idKGigiRS='156';
			$idKGigiKrakatau='193';
			$idKGigiBICT='0';
			
			$idKTerpaduRS='91';
			
			$idKRontgenRS='61';
			$idKRontgenBICT='0';
			
			$idKCtScanRs = '208';
			
			$idKLabRS='58';
			$idKLabRSPCR='232';
			$idKLabKrakatau='216';
			$idKLabBICT='0';
			
			$idRIRS='183,184,185,186,71,162,33';
			
			$idAmbulanceRS='122';
			
			$idFRS = '7';
			$idFKrakatau = '8';
			$idFBICT= '9';
			
			if($instansi=='1'){
			
				$idKUmum = $idKUmumRS;
				$idKSpesialis=$idKSpesialisRS;
				$idKGigi=$idKGigiRS;
				$idKTerpadu=$idKTerpaduRS;
				$idKRontgen=$idKRontgenRS;
				$idKLab=$idKLabRS.','.$idKLabRSPCR;
				$idF=$idFRS;
				$idRI=$idRIRS;
				$idKCtScan=$idKCtScanRs;
				$idAmbulance=$idAmbulanceRS;	
				$cabang = " AND k.cabang_id='$instansi'";			
				$idLainnya=$idKUmum.','.$idKSpesialis.','.$idKGigi.','.$idKTerpadu.','.$idKRontgen.','.$idKLab.','.$idRI.','.$idKCtScan.','.$idAmbulance;
	
			}elseif($instansi=='2'){
				$idKUmum = $idKUmumKrakatau;
				$idKSpesialis=$idKSpesialisKrakatau;
				$idKGigi=$idKGigiKrakatau;
				$idKTerpadu='0';
				$idKRontgen='0';
				$idKLab=$idKLabKrakatau;
				$idF=$idFKrakatau;
				$idRI='0';
				$idKCtScan='0';
				$idAmbulance='0';				
				$idLainnya=$idKUmum.','.$idKSpesialis.','.$idKGigi.','.$idKLab;
				$cabang = " AND k.cabang_id='$instansi'";	
			
			}elseif($instansi=='3'){
			
				$idKUmum = $idKUmumBICT;
				$idKSpesialis='0';
				$idKGigi='0';
				$idKTerpadu='0';
				$idKRontgen='0';
				$idKLab='0';
				$idF=$idFBICT;
				$idRI='0';
				$idKCtScan='0';
				$idAmbulance='0';				
				$idLainnya=$idKUmum;
				$cabang = " AND k.cabang_id='$instansi'";	
			
			}elseif($instansi=='0'){
				
				$idKUmum=$idKUmumRS.','.$idKUmumKrakatau.','.$idKUmumBICT;
				$idKSpesialis=$idKSpesialisRS.','.$idKSpesialisKrakatau;
				$idKGigi=$idKGigiRS.','.$idKGigiKrakatau;
				$idKTerpadu=$idKTerpaduRS;
				$idKRontgen=$idKRontgenRS;
				$idKCtScan=$idKCtScanRs;
				$idKLab=$idKLabRS.','.$idKLabKrakatau.','.$idKLabRSPCR;
				$idRI=$idRIRS;
				$idF=$idFRS.','.$idFKrakatau.','.$idFBICT;
				$idAmbulance=$idAmbulanceRS;
				$idLainnya=$idKUmum.','.$idKSpesialis.','.$idKGigi.','.$idKTerpadu.','.$idKRontgen.','.$idKLab.','.$idRI.','.$idKCtScan.','.$idAmbulance;
				$cabang = '';
			
			}

			$kol = Array ( 
							'1||1||'.$idKUmum => 'KLINIK UMUM', 
							'2||1||'.$idKSpesialis => 'KLINIK SPESIALIS', 
							'3||1||'.$idKGigi => 'KLINIK GIGI',
							'4||1||'.$idKTerpadu => 'KLINIK TERPADU',
							'5||1||'.$idKRontgen => 'RONTGEN',
							'6||1||'.$idKLab => 'LABORATORIUM',
							'7||2||'.$idF => 'FARMASI',
							'8||3||'.$idRI => 'RAWAT INAP',
							'9||1||'.$idKCtScan => 'CT-SCAN',
							'10||1||'.$idAmbulance => 'AMBULANCE',
							'11||4||'.$idLainnya => 'LAINNYA',
						) ;
			
			if($instansi == '0'){
				$kol += ['12||5||'.$idFKrakatau => 'APOTEK'];
			}
				//echo "idRI=$idRI, idF=$idF, idLainnya=$idLainnya".";<br>";
			  ?>
  
			  <?php
					foreach($kol as $tmp_id=>$col){

						$no++;
						echo "<tr>";
						echo "<td height='20' align='center' >".$no."</td>";
						echo "<td style='font-weight:bold;'>&nbsp;".$col." </td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						echo "<tr>";
						
						$artmp_id=explode('||',$tmp_id);
						$id=$artmp_id[2];
						
						if($artmp_id[1]=='3'){
							$sql="SELECT t.typePx, t.pas, t.satuan, SUM(t.jumlah) AS jumlah, SUM(t.jumlah2) AS jumlah2 FROM 
								(SELECT
								  p.id,
								  1 AS typePx,
								  p.tgl_in,
								  p.`tgl_out`,
								  '1. Pasien Internal'    pas,
								  'Hari'                  satuan,
								  IF(p.status_out=1,DATEDIFF(p.`tgl_out`,p.`tgl_in`),DATEDIFF(p.`tgl_out`,p.`tgl_in`)+1)    jumlah,
								  '0'                     jumlah2
								FROM b_tindakan_kamar p
									INNER JOIN b_pelayanan pel
										ON p.pelayanan_id = pel.id
									INNER JOIN b_kunjungan k
										ON pel.kunjungan_id = k.id
								WHERE p.`kso_id` IN(11,14)
									AND p.tgl_out > p.tgl_in    
									 $cabang $waktu_ranap 
								UNION 
								SELECT
								  p.id,
								  1 AS typePx,
								  p.tgl_in,
								  p.`tgl_out`,
								  '1. Pasien Internal'    pas,
								  'Hari'                  satuan,
								  '0'                     jumlah,
								  IF(p.status_out=1,DATEDIFF(p.`tgl_out`,p.`tgl_in`),DATEDIFF(p.`tgl_out`,p.`tgl_in`)+1)    jumlah2
								FROM b_tindakan_kamar p
									INNER JOIN b_pelayanan pel
										ON p.pelayanan_id = pel.id
									INNER JOIN b_kunjungan k
										ON pel.kunjungan_id = k.id
								WHERE p.`kso_id` IN(11,14)
									AND p.tgl_out > p.tgl_in
									 $cabang $waktu_ranap2
								UNION
								SELECT
								  p.id,
								  2 AS typePx,
								  p.tgl_in,
								  p.`tgl_out`,
								  '2. Pasien Eksternal'    pas,
								  'Hari'                  satuan,
								  IF(p.status_out=1,DATEDIFF(p.`tgl_out`,p.`tgl_in`),DATEDIFF(p.`tgl_out`,p.`tgl_in`)+1)    jumlah,
								  '0'                     jumlah2
								FROM b_tindakan_kamar p
									INNER JOIN b_pelayanan pel
										ON p.pelayanan_id = pel.id
									INNER JOIN b_kunjungan k
										ON pel.kunjungan_id = k.id
								WHERE p.`kso_id` NOT IN (11,14)
									AND p.tgl_out > p.tgl_in    
									 $cabang $waktu_ranap 
								UNION 
								SELECT
								  p.id,
								  2 AS typePx,
								  p.tgl_in,
								  p.`tgl_out`,
								  '2. Pasien Eksternal'    pas,
								  'Hari'                  satuan,
								  '0'                     jumlah,
								  IF(p.status_out=1,DATEDIFF(p.`tgl_out`,p.`tgl_in`),DATEDIFF(p.`tgl_out`,p.`tgl_in`)+1)    jumlah2
								FROM b_tindakan_kamar p
									INNER JOIN b_pelayanan pel
										ON p.pelayanan_id = pel.id
									INNER JOIN b_kunjungan k
										ON pel.kunjungan_id = k.id
								WHERE p.`kso_id` NOT IN (11,14)
									AND p.tgl_out > p.tgl_in
									 $cabang $waktu_ranap2) AS t 
								GROUP BY t.typePx";
						}elseif($artmp_id[1]=='2'){
							$sql="SELECT t1.typePx, t1.pas, t1.satuan, SUM(t1.jumlah) jumlah, SUM(t1.jumlah2) jumlah2 
								FROM (
								SELECT t0.typePx, t0.pas, t0.satuan, COUNT(t0.jumlah) jumlah, '0' jumlah2 
								FROM (
								SELECT 1 AS typePx, '1. Pasien Internal' pas,'Lembar' satuan, p.`NO_PENJUALAN` jumlah 
								FROM $dbapotek.`a_penjualan` p 
									INNER JOIN $dbapotek.`a_unit` k
										ON p.UNIT_ID = k.UNIT_ID
								WHERE p.`kso_id` IN (3, 13) /*AND p.UNIT_ID IN ($idF)*/ $cabang $waktu 
								GROUP BY p.no_penjualan,p.`unit_id`, p.TGL 
								UNION 
								SELECT 2 AS typePx, '2. Pasien Eksternal' pas, 'Lembar' satuan, p.`NO_PENJUALAN` jumlah 
								FROM $dbapotek.a_penjualan p 
									INNER JOIN $dbapotek.`a_unit` k
										ON p.UNIT_ID = k.UNIT_ID
								WHERE p.`kso_id` NOT IN (3, 13, 0) /*AND p.UNIT_ID IN ($idF)*/ $cabang $waktu 
								GROUP BY p.no_penjualan, p.`unit_id`, p.TGL ) t0 
								GROUP BY t0.typePx 
								UNION 
								SELECT t.typePx, t.pas, t.satuan, '0' jumlah, COUNT(t.jumlah) jumlah2 FROM (
								SELECT 1 AS typePx, '1. Pasien Internal' pas,'Lembar' satuan, p.`NO_PENJUALAN` jumlah 
								FROM $dbapotek.`a_penjualan` p 
									INNER JOIN $dbapotek.`a_unit` k
										ON p.UNIT_ID = k.UNIT_ID
								WHERE p.`kso_id` IN (3, 13) /*AND p.UNIT_ID IN ($idF)*/ $cabang $waktu2 
								GROUP BY p.no_penjualan,p.`unit_id`, p.TGL 
								UNION 
								SELECT 2 AS typePx, '2. Pasien Eksternal' pas, 'Lembar' satuan, p.`NO_PENJUALAN` jumlah 
								FROM $dbapotek.a_penjualan p 
									INNER JOIN $dbapotek.`a_unit` k
										ON p.UNIT_ID = k.UNIT_ID
								WHERE p.`kso_id` NOT IN (3, 13, 0) /*AND p.UNIT_ID IN ($idF)*/ $cabang $waktu2 
								GROUP BY p.no_penjualan, p.`unit_id`, p.TGL ) t 
								GROUP BY t.typePx) t1 
								GROUP BY t1.typePx";
						}elseif($artmp_id[1]=='4'){
							$sql="SELECT t.typePx, t.pas, t.satuan, SUM(t.jumlah) jumlah, SUM(t.jumlah2) jumlah2 
								FROM (
								SELECT 1 AS typePx, '1. Pasien Internal' pas, 'Orang' satuan, COUNT(p.id) jumlah, '0' jumlah2 
								FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
								WHERE k.`kso_id` IN (11,14) AND p.unit_id NOT IN ($id) $cabang $waktu 
								UNION 
								SELECT 2 AS typePx, '2. Pasien Eksternal' pas, 'Orang' satuan, COUNT(p.id) jumlah, '0' jumlah2 
								FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
								WHERE k.`kso_id` NOT IN (11,14) AND p.unit_id NOT IN ($id) $cabang $waktu 
								UNION 
								SELECT 1 AS typePx, '1. Pasien Internal' pas, 'Orang' satuan, '0' jumlah, COUNT(p.id) jumlah2 
								FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
								WHERE k.`kso_id` IN (11,14) AND p.unit_id NOT IN ($id) $cabang $waktu2 
								UNION 
								SELECT 2 AS typePx, '2. Pasien Eksternal' pas, 'Orang' satuan, '0' jumlah,COUNT(p.id) jumlah2 
								FROM b_kunjungan k  INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
								WHERE k.`kso_id` NOT IN (11,14) AND p.unit_id NOT IN ($id) $cabang $waktu2 ) t 
								GROUP BY t.typePx";
						}elseif($artmp_id[1]=='5'){
							$sql="SELECT t1.typePx, t1.pas, t1.satuan, SUM(t1.jumlah) jumlah, SUM(t1.jumlah2) jumlah2 
								FROM (
								SELECT t0.typePx, t0.pas, t0.satuan, COUNT(t0.jumlah) jumlah, '0' jumlah2 
								FROM (
								SELECT 1 AS typePx, '1. Pasien Internal' pas,'Lembar' satuan, p.`NO_PENJUALAN` jumlah 
								FROM apotek_phcm.`a_penjualan` p 
									INNER JOIN apotek_phcm.`a_unit` k
										ON p.UNIT_ID = k.UNIT_ID
								WHERE p.`kso_id` IN (3, 13) /*AND p.UNIT_ID IN ($idF)*/ $cabang $waktu 
								GROUP BY p.no_penjualan,p.`unit_id`, p.TGL 
								UNION 
								SELECT 2 AS typePx, '2. Pasien Eksternal' pas, 'Lembar' satuan, p.`NO_PENJUALAN` jumlah 
								FROM apotek_phcm.a_penjualan p 
									INNER JOIN apotek_phcm.`a_unit` k
										ON p.UNIT_ID = k.UNIT_ID
								WHERE p.`kso_id` NOT IN (3, 13, 0) /*AND p.UNIT_ID IN ($idF)*/ $cabang $waktu 
								GROUP BY p.no_penjualan, p.`unit_id`, p.TGL ) t0 
								GROUP BY t0.typePx 
								UNION 
								SELECT t.typePx, t.pas, t.satuan, '0' jumlah, COUNT(t.jumlah) jumlah2 FROM (
								SELECT 1 AS typePx, '1. Pasien Internal' pas,'Lembar' satuan, p.`NO_PENJUALAN` jumlah 
								FROM apotek_phcm.`a_penjualan` p 
									INNER JOIN apotek_phcm.`a_unit` k
										ON p.UNIT_ID = k.UNIT_ID
								WHERE p.`kso_id` IN (3, 13) /*AND p.UNIT_ID IN ($idF)*/ $cabang $waktu2 
								GROUP BY p.no_penjualan,p.`unit_id`, p.TGL 
								UNION 
								SELECT 2 AS typePx, '2. Pasien Eksternal' pas, 'Lembar' satuan, p.`NO_PENJUALAN` jumlah 
								FROM apotek_phcm.a_penjualan p 
									INNER JOIN apotek_phcm.`a_unit` k
										ON p.UNIT_ID = k.UNIT_ID
								WHERE p.`kso_id` NOT IN (3, 13, 0) /*AND p.UNIT_ID IN ($idF)*/ $cabang $waktu2 
								GROUP BY p.no_penjualan, p.`unit_id`, p.TGL ) t 
								GROUP BY t.typePx) t1 
								GROUP BY t1.typePx";
						}else{
							$sql="SELECT t.typePx, t.pas, t.satuan, SUM(t.jumlah) jumlah, SUM(t.jumlah2) jumlah2 
							FROM (
							SELECT 1 AS typePx, '1. Pasien Internal' pas, 'Orang' satuan, COUNT(p.id) jumlah, '0' jumlah2 
							FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
							WHERE k.`kso_id` IN (11,14) AND p.unit_id IN ($id) /*ini tambahan*/ /*OR p.jenis_kunjungan = $igd */ /*decyber*/ $cabang $waktu 
							UNION 
							SELECT 2 AS typePx, '2. Pasien Eksternal' pas, 'Orang' satuan, COUNT(p.id) jumlah, '0' jumlah2 
							FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
							WHERE k.`kso_id` NOT IN (11,14) AND p.unit_id IN ($id)  /*OR p.jenis_kunjungan = $igd */ /*decyber*/ $cabang $waktu 
							UNION 
							SELECT 1 AS typePx, '1. Pasien Internal' pas, 'Orang' satuan, '0' jumlah, COUNT(p.id) jumlah2 
							FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id 
							WHERE k.`kso_id` IN (11,14) AND p.unit_id IN ($id) $cabang $waktu2 
							UNION 
							SELECT 2 AS typePx, '2. Pasien Eksternal' pas, 'Orang' satuan, '0' jumlah,COUNT(p.id) jumlah2 
							FROM b_kunjungan k  INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
							WHERE k.`kso_id` NOT IN (11,14) AND p.unit_id IN ($id) $cabang $waktu2 ) t 
							GROUP BY t.typePx ";
						 }
						
						//echo "id=$id, artmp_id=$artmp_id[1]".";<br>";
						// echo $sql.";<br>";
						 
						$sql1 = mysql_query($sql);
						$subtotal =0;
						$subtotal2 =0;
						// if($sql1 == FALSE){
						// 	echo mysql_error();
						// }
						while($sql2 = mysql_fetch_array($sql1)){
							$pas = $sql2['pas'];
							$jumlah = $sql2['jumlah'];
							$jumlah2 = $sql2['jumlah2'];
							$satuan = $sql2['satuan'];
							
							echo "<tr>";
							echo "<td height='20' align='center' ></td>";
							echo "<td >&nbsp;&nbsp;".$pas."</td>";
							echo "<td align='center'>".$satuan."</td>";
							echo "<td align='center'>".'-'."</td>";
							if($col == 'KLINIK UMUM' OR $col == 'KLINIK SPESIALIS' ){
								if($col == 'KLINIK UMUM'){
									if($pas == '1. Pasien Internal'){
									$sqlVisitU = "SELECT t.typePx, SUM(t.jumlah) jumlah, SUM(t.jumlah2) jumlah2 
									FROM (
									SELECT 1 AS typePx, COUNT(p.id) jumlah, '0' jumlah2 
									FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
									WHERE k.`kso_id` IN (11,14) AND p.ms_tindakan_kelas_id IN (SELECT id FROM b_ms_tindakan_kelas WHERE ms_tindakan_id = 342) /*decyber*/ $cabang $waktu 
									UNION 
									SELECT 1 AS typePx, '0' jumlah, COUNT(p.id) jumlah2 
									FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
									WHERE k.`kso_id` IN (11,14) AND p.ms_tindakan_kelas_id IN (SELECT id FROM b_ms_tindakan_kelas WHERE ms_tindakan_id = 342) $cabang $waktu2 /*decyber*/ 
									)/*decyber*/  t 
									GROUP BY t.typePx";
									}else if($pas == '2. Pasien Eksternal'){
										$sqlVisitU = "SELECT t.typePx, SUM(t.jumlah) jumlah, SUM(t.jumlah2) jumlah2 
									FROM (
									SELECT 2 AS typePx, COUNT(p.id) jumlah, '0' jumlah2 
									FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
									WHERE k.`kso_id` NOT IN (11,14) AND p.ms_tindakan_kelas_id IN (SELECT id FROM b_ms_tindakan_kelas WHERE ms_tindakan_id = 342)  /*decyber*/ $cabang $waktu 
									UNION 
									SELECT 2 AS typePx, '0' jumlah,COUNT(p.id) jumlah2 
									FROM b_kunjungan k  INNER JOIN b_tindakan p ON k.id=p.kunjungan_id
									WHERE k.`kso_id` NOT IN (11,14) AND p.ms_tindakan_kelas_id IN (SELECT id FROM b_ms_tindakan_kelas WHERE ms_tindakan_id = 342) $cabang $waktu2 )/*decyber*/  t 
									GROUP BY t.typePx";
									}
									$sqlVisitU1 = mysql_query($sqlVisitU);
									// if($sqlVisitU1 == FALSE){
									// 	echo mysql_error();
									// }
									$sqlVisitU2 = mysql_fetch_array($sqlVisitU1);
									$jmlUmum = $sqlVisitU2['jumlah'];
									$jmlUmum2 = $sqlVisitU2['jumlah2'];
									$jumlah2 += $jmlUmum2;
									$jumlah += $jmlUmum;
								echo "<td align='center'>".number_format($jumlah2,0,",",".")."</td>";
								echo "<td align='center'>".number_format($jumlah,0,",",".")."</td>";
								echo "<td align='center'>".number_format($jumlah2 + $jumlah,0,",",".")."</td>";
								}elseif($col == 'KLINIK SPESIALIS'){
									if($pas == '1. Pasien Internal'){
									$sqlVisitS = "SELECT t.typePx, SUM(t.jumlah) jumlah, SUM(t.jumlah2) jumlah2 
									FROM (
									SELECT 1 AS typePx, COUNT(p.id) jumlah, '0' jumlah2 
									FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
									WHERE k.`kso_id` IN (11,14) AND p.ms_tindakan_kelas_id IN (SELECT id FROM b_ms_tindakan_kelas WHERE ms_tindakan_id = 343) /*decyber*/ $cabang $waktu 
									UNION 
									SELECT 1 AS typePx, '0' jumlah, COUNT(p.id) jumlah2 
									FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
									WHERE k.`kso_id` IN (11,14) AND p.ms_tindakan_kelas_id IN (SELECT id FROM b_ms_tindakan_kelas WHERE ms_tindakan_id = 343) $cabang $waktu2 /*decyber*/ 
									)/*decyber*/  t 
									GROUP BY t.typePx";
									}else if($pas == '2. Pasien Eksternal'){
										$sqlVisitS = "SELECT t.typePx, SUM(t.jumlah) jumlah, SUM(t.jumlah2) jumlah2 
										FROM (
										SELECT 2 AS typePx, COUNT(p.id) jumlah, '0' jumlah2 
										FROM b_kunjungan k INNER JOIN b_tindakan p ON k.id=p.kunjungan_id 
										WHERE k.`kso_id` NOT IN (11,14) AND p.ms_tindakan_kelas_id IN (SELECT id FROM b_ms_tindakan_kelas WHERE ms_tindakan_id = 343)  /*decyber*/ $cabang $waktu 
										UNION 
										SELECT 2 AS typePx, '0' jumlah,COUNT(p.id) jumlah2 
										FROM b_kunjungan k  INNER JOIN b_tindakan p ON k.id=p.kunjungan_id
										WHERE k.`kso_id` NOT IN (11,14) AND p.ms_tindakan_kelas_id IN (SELECT id FROM b_ms_tindakan_kelas WHERE ms_tindakan_id = 343) $cabang $waktu2 )/*decyber*/  t 
										GROUP BY t.typePx";
									}
									// echo $sqlVisitS . '<br>';
									$sqlVisitS1 = mysql_query($sqlVisitS);
									// if($sqlVisitS1 == FALSE){
									// 	echo mysql_error();
									// }
									
									$sqlVisitS2 = mysql_fetch_array($sqlVisitS1);
									$jmlSpe = $sqlVisitS2['jumlah'];
									$jmlSpe2 = $sqlVisitS2['jumlah2'];
									$jumlah2 += $jmlSpe2;
									$jumlah += $jmlSpe;

								echo "<td align='center'>".number_format($jumlah2,0,",",".")."</td>";
								echo "<td align='center'>".number_format($jumlah,0,",",".")."</td>";
								echo "<td align='center'>".number_format($jumlah + $jumlah2,0,",",".")."</td>";
								}
							
							}else{
								echo "<td align='center'>".number_format($jumlah2,0,",",".")."</td>";
							echo "<td align='center'>".number_format($jumlah,0,",",".")."</td>";
							echo "<td align='center'>".number_format($jumlah2 + $jumlah,0,",",".")."</td>";
							}
							
							echo "<td>&nbsp;</td>";
							echo "<tr>";
							
							$subtotal +=$jumlah;
							$subtotal2 +=$jumlah2;
							
							$total +=$jumlah;
							$total2 +=$jumlah2;
						}
						
						echo "<tr>";
						echo "<td height='20' align='center' ></td>";
						echo "<td align='right'>Jumlah  &nbsp;&nbsp;</td>";
						echo "<td align='center'></td>";
						echo "<td align='center'></td>";
						echo "<td align='center'>".number_format($subtotal2,0,",",".")."</td>";
						echo "<td align='center'>".number_format($subtotal,0,",",".")."</td>";
						echo "<td align='center'>".number_format($subtotal+$subtotal2,0,",",".")."</td>";
						echo "<td>&nbsp;</td>";
						echo "<tr>";
					
					}
				?>
			<tr>
				  <td height="20" align="center"><?php echo $no+1; ?></td>
				  <td style='font-weight:bold;'>&nbsp; TOTAL PRODUKSI</td>
				  <td></td>
				  <td></td>
				 <td align="center"><?php echo number_format($total2,0,",","."); ?></td>
				  <td align="center"><?php echo number_format($total,0,",","."); ?></td>
				  <td align="center"><?php echo number_format($total+$total2,0,",","."); ?></td>
				  <td>&nbsp;</td>
			  </tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">Tgl Cetak: <?php echo $date_now;?>&nbsp;Jam: <?php echo $jam;?></td>
	</tr>
	<tr>
		<td align="right">Yang Mencetak,&nbsp;</td>
	</tr>
	<tr>
		<td height="50">&nbsp;</td>
	</tr>
	<tr>
		<td style="text-align:right; text-transform:uppercase;"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><tr id="trTombol">
        <td class="noline" align="center">
        <?php 
            if($_POST['export']!='excel'){
         ?>
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
         <?php 
            }
         ?>
        </td>
    </tr></td>
	</tr>
</table>
<script type="text/JavaScript">

/* try{	
formatF4();
}catch(e){
window.location='../../addon/jsprintsetup.xpi';
} */
    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		/* try{
			mulaiPrint();
		}
		catch(e){
			window.print();
		} */
		window.print();
		window.close();
        }
    }
</script>