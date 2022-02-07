<?php
	include("../../koneksi/konek.php");
	$date_now = gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	function currency($number){
		$data = number_format($number,0,",",".");
		return $data;
	}
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglHarian']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = "((b_pelayanan.jenis_kunjungan='3' and DATE(b_kunjungan.tgl_pulang) =  '$tglAwal2' and b_kunjungan.pulang='1') or (b_pelayanan.jenis_kunjungan != 3 and DATE(b_pelayanan.tgl_krs) = '$tglAwal2' AND b_pelayanan.sudah_krs=1))";
		$waktuBayar = "AND b.tgl = '{$tglAwal2}'";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " ((b_pelayanan.jenis_kunjungan='3' and month(b_kunjungan.tgl_pulang) = '$bln' and year(b_kunjungan.tgl_pulang) = '$thn' and b_kunjungan.pulang='1') or (b_pelayanan.jenis_kunjungan != 3 and month(b_pelayanan.tgl_krs) = '$bln' and year(b_pelayanan.tgl_krs) = '$thn' AND b_pelayanan.sudah_krs=1))";
		$waktuBayar = "AND MONTH(b.tgl) = '{$bln}' AND YEAR(b.tgl) = '{$thn}'";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = "((b_pelayanan.jenis_kunjungan='3' and DATE(b_kunjungan.tgl_pulang) between '$tglAwal2' and '$tglAkhir2' and b_kunjungan.pulang='1') or (b_pelayanan.jenis_kunjungan<>3 and DATE(b_pelayanan.tgl_krs) between '$tglAwal2' and '$tglAkhir2' and b_pelayanan.sudah_krs='1'))";
		$waktuBayar = "AND b.tgl BETWEEN '{$tglAwal2}' AND '{$tglAkhir2}'";
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	
	$qKso = "SELECT id, nama FROM b_ms_kso WHERE id = '".$_REQUEST['StatusPasNonUmum']."'";
	$rsKso = mysql_query($qKso);
	$rwKso = mysql_fetch_array($rsKso);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
	
	//echo "asdadsd=".$_REQUEST['StatusPas']."<br>";
	
	$labelPenjamin = ($rwKso['nama'] == '') ? "Semua" : $rwKso['nama'];
	$fKso = ($_REQUEST['StatusPasNonUmum'] == 0) ? "" : "AND b_tindakan.kso_id = '".$_REQUEST['StatusPasNonUmum']."'";
	$unit = ($_REQUEST['TmpLayanan'] == 0) ? "AND b_ms_unit.parent_id = '".$_REQUEST['JnsLayanan']."'" : "AND b_ms_unit.id = '".$_REQUEST['TmpLayanan']."'";
	
	//echo "asdasdsa=".$fKso;
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta http-equiv="Content-Type" content="text/html;" charset="utf-8" />
	<style type="text/css">
	<!--
		body { font-family: Arial, Helvetica, Sans-Serif; font-size: 12px; }
		.container { width: 1200px; }
		.kop { font-size: 11px; font-weight: bold; }
		.header { font-size: 14px; font-weight: bold; text-align: center; text-transform: uppercase; padding-bottom: 10px; }
		.table-head { border-top: 1px solid black; border-bottom: 1px solid black; }
		table { border-collapse: collapse; }
	-->
	</style>
	<script type="text/javascript">
		function cetak(){
			document.getElementById('divCetak').style.display = "none";
			if(!window.print()){
				document.getElementById('divCetak').style.display = "block";
			}
		}
	</script>
	<title>Laporan Iur Bayar</title>
</head>
<body>
	<div class="container">
		<div class="kop">
			Rumah Sakit Umum Daerah Kabupaten Sidoarjo <br />
			Jl. Mojopahit 667 Sidoarjo <br />
			Telepon (031) 8961649 <br />
			Sidoarjo
		</div>
		<div class="header">
			Laporan Penerimaan Iur Bayar Pasien Pulang <br />
			<?php echo $Periode; ?>
		</div>
		<div>
			&nbsp;
			<div style="float: right; font-weight: bold;">
				Yang Mencetak : <?php echo $rwPeg['nama'];?>
			</div>
		</div>
		<div style="font-weight: bold;">
			Penjamin Pasien : <?php echo $labelPenjamin; ?>
			<div style="float: right;">
				Tgl Cetak <?php echo $date_now; ?> Jam <?php echo $jam; ?>
			</div>
		</div>
		<table>
			<tr height="30" style="font-weight: bold;">
				<td width="120" class="table-head">Penjamin</td>
				<td width="120" align="center" class="table-head">Tgl. Kunjungan</td>
				<td width="120" align="center" class="table-head">No. RM</td>
				<td width="250" class="table-head">Nama Pasien</td>
				<td width="150" align="right" class="table-head">Tarif</td>
				<td width="150" align="right" class="table-head">Nilai Jaminan</td>
				<td width="150" align="right" class="table-head">Iur Dibayar</td>
				<td width="150" align="right" class="table-head">Kurang Bayar</td>
                <td width="150" align="right" class="table-head">Lebih Bayar</td>
			</tr>
		<?php
			$fUnit="";
			if($_REQUEST['TmpLayanan']==0){
				$fUnit="AND b_ms_unit.parent_id=".$_REQUEST['JnsLayanan'];	
			}
			else{
				$fUnit="AND b_ms_unit.id=".$_REQUEST['TmpLayanan'];
			}
			
			$fSts="";
			if($_REQUEST['StatusPasNonUmum']==0){
				$fSts="AND b_ms_kso.id<>1";
			}
			else{
				$fSts="AND b_ms_kso.id=".$_REQUEST['StatusPasNonUmum'];
			}
		
			
			$sqlKunj = "SELECT
						b_ms_kso.id,
						b_ms_kso.nama
						FROM b_bayar
						INNER JOIN b_kunjungan ON b_kunjungan.id=b_bayar.kunjungan_id
						INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
						INNER JOIN b_ms_unit ON b_ms_unit.id=b_bayar.unit_id
						INNER JOIN b_ms_kso ON b_ms_kso.id=b_bayar.kso_id
						WHERE
						$waktu
						$fUnit
						$fSts
						GROUP BY
						b_ms_kso.id";
			//echo $sqlKunj."<br>";
			$rsKunj = mysql_query($sqlKunj);			
			$totTagihan = 0;
			$totJaminan = 0;
			$totIur = 0;
			$totKurang = 0;
			$totLebih = 0;
			while($rwKunj = mysql_fetch_array($rsKunj)) {
		?>
			<tr height="25">
				<td colspan="8" style="font-weight: bold;"><?php echo $rwKunj['nama']; ?></td>
			</tr>
		<?php 
				$sqlUnit = "SELECT
							b_ms_unit.id,
							b_ms_unit.nama
							FROM b_bayar
							INNER JOIN b_kunjungan ON b_kunjungan.id=b_bayar.kunjungan_id
							INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
							INNER JOIN b_ms_unit ON b_ms_unit.id=b_bayar.unit_id
							INNER JOIN b_ms_kso ON b_ms_kso.id=b_bayar.kso_id
							WHERE
							$waktu
							$fUnit
							AND b_ms_kso.id='".$rwKunj['id']."'
							GROUP BY
							b_ms_unit.id";
				$queryUnit = mysql_query($sqlUnit);
				$subTagihan = 0;//echo $sqlUnit;
				$subJaminan = 0;
				$subIur = 0;
				$subKurang = 0;
				$subLebih = 0;
				$i = 1;
				while($rowsUnit = mysql_fetch_array($queryUnit)) {
					echo '<tr>
							<td colspan="7" style="padding-left:20px;">'.$rowsUnit['nama'].'</td>
						  ';
						  
					$sql = "SELECT
							b_kunjungan.id,
							b_bayar.jenis_kunjungan,
							b_ms_pasien.no_rm,
							b_ms_pasien.nama
							FROM b_bayar
							INNER JOIN b_kunjungan ON b_kunjungan.id=b_bayar.kunjungan_id
							INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
							INNER JOIN b_ms_pasien ON b_ms_pasien.id=b_kunjungan.pasien_id
							WHERE
							$waktu
							AND b_bayar.kso_id='".$rwKunj['id']."'
							AND b_bayar.unit_id='".$rowsUnit['id']."'
							GROUP BY
							b_kunjungan.id,
							b_bayar.jenis_kunjungan,
							b_bayar.kso_id";
					//echo $sql."<br><br>";
					$query = mysql_query($sql);
					while($rows = mysql_fetch_array($query)){
						if($rows['jenis_kunjungan']=='3'){
							$sTgl="SELECT 
									DATE_FORMAT(tk.tgl_in,'%d-%m-%Y') AS tgl
									FROM b_pelayanan p
									INNER JOIN b_tindakan_kamar tk ON tk.pelayanan_id=p.id
									WHERE p.kunjungan_id='".$rows['id']."'
									ORDER BY p.id,tk.id LIMIT 1";
							$qTgl=mysql_query($sTgl);
							$rwTgl=mysql_fetch_array($qTgl);
							$tgl=$rwTgl['tgl'];
						}
						else{
							$sTglUnit="SELECT 
										DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,
										u.id,
										u.nama
										FROM b_kunjungan k
										INNER JOIN b_ms_unit u ON u.id=k.unit_id
										WHERE k.id='".$rows['id']."'";
							$qTglUnit=mysql_query($sTglUnit);
							$rwTglUnit=mysql_fetch_array($qTglUnit);
							$tgl=$rwTglUnit['tgl'];
						}
						
						$nilai_tarip=0;
						$nilai_jaminan=0;
						$idKunj=$rows['id'];
						
						if($rwKunj['id']=='72'){ // BPJS
							$fJenisKunjungan="AND p.jenis_kunjungan=".$rows['jenis_kunjungan'];
							
							$isNaikKelas=0;
							$isVIP_UMUM=0;
							$isVIP=0;
							
							$sHakKelas="SELECT id,level,nama FROM (
										SELECT  
										mk.id,
										mk.nama,
										mk.level
										FROM b_pelayanan p
										INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
										INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
										INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
										inner join b_ms_kelas mk ON mk.id=t.kso_kelas_id
										WHERE p.kunjungan_id='$idKunj' $fJenisKunjungan
										AND kso.id=72
										AND mk.tipe=0
										UNION
										SELECT  
										mk.id,
										mk.nama,
										mk.level
										FROM b_pelayanan p
										INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
										INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
										inner join b_ms_kelas mk ON mk.id=tk.kso_kelas_id
										WHERE p.kunjungan_id='$idKunj' $fJenisKunjungan
										AND kso.id=72
										AND mk.tipe=0) AS tblhakkelas ORDER BY level DESC LIMIT 1";
							$qHakKelas=mysql_query($sHakKelas);
							$rwHakKelas=mysql_fetch_array($qHakKelas);
							
							$sKelasTertinggi="SELECT id,level,nama FROM (
										SELECT  
										mk.id,
										mk.nama,
										mk.level
										FROM b_pelayanan p
										INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
										INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
										INNER JOIN b_ms_tindakan_kelas mtk ON mtk.id=t.ms_tindakan_kelas_id
										INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
										inner join b_ms_kelas mk ON mk.id=t.kelas_id
										WHERE p.kunjungan_id='$idKunj' $fJenisKunjungan 
										AND kso.id=72
										AND mk.tipe=0
										UNION
										SELECT  
										mk.id,
										mk.nama,
										mk.level
										FROM b_pelayanan p
										INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
										INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
										inner join b_ms_kelas mk ON mk.id=tk.kelas_id
										WHERE p.kunjungan_id='$idKunj' $fJenisKunjungan
										AND kso.id=72
										AND mk.tipe=0) AS tbl ORDER BY level DESC LIMIT 1";
							$qKelasTertinggi=mysql_query($sKelasTertinggi);
							$rwKelasTertinggi=mysql_fetch_array($qKelasTertinggi);
							
							if($rwKelasTertinggi['level'] > $rwHakKelas['level']){
								$isNaikKelas=1;
							}
							
							$sVIP="SELECT * FROM (
										SELECT  
										p.id
										FROM b_pelayanan p
										INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
										INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
										INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
										INNER JOIN b_ms_kelas mk ON mk.id=t.kelas_id
										WHERE p.kunjungan_id='$idKunj' 
										AND kso.id=72
										AND mk.tipe=2
										$fJenisKunjungan
										UNION
										SELECT  
										p.id
										FROM b_pelayanan p
										INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
										INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
										INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
										INNER JOIN b_ms_kelas mk ON mk.id=tk.kelas_id
										WHERE p.kunjungan_id='$idKunj'
										AND mk.tipe=2
										AND kso.id=72
										$fJenisKunjungan) AS tblhakkelas LIMIT 1";
							$qVIP=mysql_query($sVIP);
							
							if(mysql_num_rows($qVIP)>0){
								$isNaikKelas=1;
								$isVIP=1;
							}
							
							if($isVIP==1){
								$sTipeBayar="select bpjs_tipe_bayar from b_kunjungan where id = '".$idKunj."'";
								$qTipeBayar=mysql_query($sTipeBayar);
								$rwTipeBayar=mysql_fetch_array($qTipeBayar);
								if($rwTipeBayar['bpjs_tipe_bayar']=='1'){
									$isVIP_UMUM=1;
								}
							}
							
							if($isVIP_UMUM==1){
								$sKelasTertinggi="SELECT id,level,nama FROM (
											SELECT  
											mk.id,
											mk.nama,
											mk.level
											FROM b_pelayanan p
											INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
											INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
											INNER JOIN b_ms_tindakan_kelas mtk ON mtk.id=t.ms_tindakan_kelas_id
											INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
											inner join b_ms_kelas mk ON mk.id=t.kelas_id
											WHERE p.kunjungan_id='$idKunj'
											AND mu.parent_id NOT IN (50,132)											
											AND kso.id=72
											AND mk.tipe=0
											UNION
											SELECT  
											mk.id,
											mk.nama,
											mk.level
											FROM b_pelayanan p
											INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
											INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
											INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
											inner join b_ms_kelas mk ON mk.id=tk.kelas_id
											WHERE p.kunjungan_id='$idKunj'
											AND mu.parent_id NOT IN (50,132)
											AND kso.id=72
											AND mk.tipe=0) AS tbl ORDER BY level DESC LIMIT 1";
								$qKelasTertinggi=mysql_query($sKelasTertinggi);
								$rwKelasTertinggi=mysql_fetch_array($qKelasTertinggi);
							}
							
							$BPJS_iurbayar=0;
							$BPJS_jaminan=0;
							$BPJS_biayanaikkelas=0;
							
							$sJaminan="SELECT * FROM b_inacbg_grouper WHERE kunjungan_id_group='".$idKunj."'";
							$qJaminan=mysql_query($sJaminan);
							if (mysql_num_rows($qJaminan)>0){
								$rwJaminan=mysql_fetch_array($qJaminan);
								
								$BPJS_jaminan=$rwJaminan["biaya_kso"];
								$BPJS_iurbayar=$rwJaminan["biaya_px"];
								$BPJS_biayanaikkelas=$BPJS_jaminan+$BPJS_iurbayar;
								if($rows['jenis_kunjungan']<>'3') $BPJS_biayanaikkelas=$BPJS_jaminan;
								$blmEntryKodeGrouper=0;
							}elseif ($isNaikKelas==1){
								$blmEntryKodeGrouper=1;
							}
							
							
							$totBiayaPaviliun_BPJS=0;
							$totBiayaPaviliun_BPJS_UMUM=0;
							if ($isVIP==1){
								if ($isVIP_UMUM==1){
									$plusRJRD=0;
									
									$fJenisKunjungan="AND b_pelayanan.jenis_kunjungan=".$rows['jenis_kunjungan'];
									
									$sPavU="SELECT 
											  SUM(nilai) AS total 
											FROM
											  (SELECT
												1,  
												SUM(tbl_tindakan.biaya) AS nilai 
											  FROM
												(SELECT 
												(b_tindakan.qty*b_tindakan.biaya) AS biaya 
												FROM
												  b_pelayanan  
												  INNER JOIN b_tindakan 
													ON b_tindakan.pelayanan_id = b_pelayanan.id
												  INNER JOIN b_ms_unit 
													ON b_ms_unit.id = b_pelayanan.unit_id
												  INNER JOIN b_ms_unit b_ms_unit_asal 
													ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
												  INNER JOIN b_ms_kelas mk 
													ON mk.id = b_pelayanan.kelas_id
												WHERE 
												b_pelayanan.kunjungan_id = '$idKunj'
												AND b_tindakan.kso_id = 72
												$fJenisKunjungan 
												AND mk.tipe = 2
												) AS tbl_tindakan 
											  UNION
											  SELECT
												2,  
												SUM(kmr.biaya) AS nilai 
											  FROM
												(SELECT
												  IF(b_tindakan_kamar.status_out = 0, 
												  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 1, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.tarip), 
												  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 0, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.tarip)) biaya 
												FROM
												  b_tindakan_kamar 
												  INNER JOIN b_pelayanan 
													ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
												  INNER JOIN b_ms_unit 
													ON b_ms_unit.id = b_pelayanan.unit_id
												  INNER JOIN b_ms_unit b_ms_unit_asal 
													ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
												  INNER JOIN b_ms_kelas mk 
													ON mk.id = b_pelayanan.kelas_id 
												WHERE 
												b_pelayanan.kunjungan_id = '$idKunj'
												AND b_tindakan_kamar.kso_id = 72 
												AND b_tindakan_kamar.aktif = 1
												$fJenisKunjungan
												AND mk.tipe = 2 
												) AS kmr) AS gab";
									//echo $sPavU."<br></br>";
									$qPavU=mysql_query($sPavU);
									$rwPavU=mysql_fetch_array($qPavU);
									$totBiayaPaviliun_BPJS_UMUM+=$rwPavU['total'];
									
									
									$sPavObatU="SELECT
											  SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL 
											FROM
											  $dbapotek.a_penjualan ap 
											  INNER JOIN b_pelayanan 
												ON ap.NO_KUNJUNGAN = b_pelayanan.id
											  INNER JOIN b_ms_unit 
												ON b_ms_unit.id = b_pelayanan.unit_id
											  INNER JOIN b_ms_unit b_ms_unit_asal 
												ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
											  INNER JOIN $dbapotek.a_mitra am 
												ON am.IDMITRA=ap.KSO_ID
											  INNER JOIN b_ms_kso kso 
												ON kso.id=b_pelayanan.kso_id
											  INNER JOIN b_kunjungan
												ON b_kunjungan.id = b_pelayanan.kunjungan_id
											  INNER JOIN b_ms_kelas k 
												ON k.id=b_pelayanan.kelas_id
											WHERE 
											b_pelayanan.kunjungan_id = '$idKunj'
											$fJenisKunjungan
											AND kso.id = 72
											AND ap.CARA_BAYAR=2
											AND ap.KRONIS<>2
											AND k.tipe=2";
									//echo $sPavObatU;
									$qPavObatU=mysql_query($sPavObatU);
									$rwPavObatU=mysql_fetch_array($qPavObatU);
									$totBiayaPaviliun_BPJS_UMUM+=$rwPavObatU['SUBTOTAL'];			
								}
								else{
									
									$fJK="";
									if($rows['jenis_kunjungan']!='3'){
										$fJK="AND b_pelayanan.jenis_kunjungan=".$rows['jenis_kunjungan'];	
									}
									
									$sPav="SELECT 
											  SUM(nilai) AS total 
											FROM
											  (SELECT
												1,  
												SUM(tbl_tindakan.biaya) AS nilai 
											  FROM
												(SELECT 
												(b_tindakan.qty*b_tindakan.biaya) AS biaya 
												FROM
												  b_pelayanan  
												  INNER JOIN b_tindakan 
													ON b_tindakan.pelayanan_id = b_pelayanan.id
												  INNER JOIN b_ms_unit 
													ON b_ms_unit.id = b_pelayanan.unit_id
												  INNER JOIN b_ms_unit b_ms_unit_asal 
													ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
												  LEFT JOIN b_ms_kelas mk 
													ON mk.id = b_tindakan.kelas_id
												WHERE 
												b_pelayanan.kunjungan_id = '$idKunj'
												AND b_tindakan.kso_id = 72
												$fJK
												) AS tbl_tindakan 
											  UNION
											  SELECT
												2,  
												SUM(kmr.biaya) AS nilai 
											  FROM
												(SELECT
												  IF(b_tindakan_kamar.status_out = 0, 
												  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 1, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.tarip), 
												  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 0, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.tarip)) biaya 
												FROM
												  b_tindakan_kamar 
												  INNER JOIN b_pelayanan 
													ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
												  INNER JOIN b_ms_unit 
													ON b_ms_unit.id = b_pelayanan.unit_id
												  INNER JOIN b_ms_unit b_ms_unit_asal 
													ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
												  INNER JOIN b_ms_kelas mk 
													ON mk.id = b_tindakan_kamar.kelas_id  
												WHERE 
												b_pelayanan.kunjungan_id = '$idKunj'
												AND b_tindakan_kamar.kso_id = 72 
												AND b_tindakan_kamar.aktif = 1
												$fJK
												) AS kmr) AS gab";
									//echo $sPav."<br></br>";
									$qPav=mysql_query($sPav);
									$rwPav=mysql_fetch_array($qPav);
									$totBiayaPaviliun_BPJS+=$rwPav['total'];
									
									$sPavObat="SELECT
											  SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL 
											FROM
											  $dbapotek.a_penjualan ap 
											  INNER JOIN b_pelayanan 
												ON ap.NO_KUNJUNGAN = b_pelayanan.id
											  INNER JOIN b_ms_unit 
												ON b_ms_unit.id = b_pelayanan.unit_id
											  INNER JOIN b_ms_unit b_ms_unit_asal 
												ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
											  INNER JOIN $dbapotek.a_mitra am 
												ON am.IDMITRA=ap.KSO_ID
											  INNER JOIN b_ms_kso kso 
												ON kso.id=b_pelayanan.kso_id
											  INNER JOIN b_kunjungan
												ON b_kunjungan.id = b_pelayanan.kunjungan_id
											  LEFT JOIN b_ms_kelas k 
												ON k.id=b_pelayanan.kelas_id 
											WHERE 
											b_pelayanan.kunjungan_id = '$idKunj'
											$fJK
											AND kso.id = 72
											AND ap.CARA_BAYAR=2
											AND ap.KRONIS<>2";
									//echo $sPavObat;
									$qPavObat=mysql_query($sPavObat);
									$rwPavObat=mysql_fetch_array($qPavObat);
									$totBiayaPaviliun_BPJS+=$rwPavObat['SUBTOTAL'];
									
									$BPJS_biayanaikkelas=$totBiayaPaviliun_BPJS;
									if($totBiayaPaviliun_BPJS>$BPJS_jaminan)
										$BPJS_iurbayar=$BPJS_biayanaikkelas - $BPJS_jaminan;
											
								}
							}
							$nilai_tarip=$BPJS_biayanaikkelas;
							$nilai_jaminan=$BPJS_jaminan;
						}
						else{
							$totBiayaKSO=0;
							$totNilaiJaminan=0;
							$fJenisKunjungan="AND b_pelayanan.jenis_kunjungan=".$rows['jenis_kunjungan'];
							
							$sKSO="SELECT 
									  SUM(nilai) AS total,
									  SUM(jaminan) AS total_jaminan 
									FROM
									  (SELECT
										1,  
										SUM(tbl_tindakan.biaya) AS nilai,
										SUM(tbl_tindakan.biaya_kso) AS jaminan 
									  FROM
										(SELECT 
										(b_tindakan.qty*b_tindakan.biaya) AS biaya,
										(b_tindakan.qty*b_tindakan.biaya_kso) AS biaya_kso 
										FROM
										  b_pelayanan  
										  INNER JOIN b_tindakan 
											ON b_tindakan.pelayanan_id = b_pelayanan.id
										WHERE 
										b_pelayanan.kunjungan_id = '$idKunj'
										AND b_tindakan.kso_id = '".$rwKunj['id']."'
										$fJenisKunjungan
										) AS tbl_tindakan 
									  UNION
									  SELECT
										2,  
										SUM(kmr.biaya) AS nilai,
										SUM(kmr.jaminan) AS jaminan 
									  FROM
										(SELECT
										  IF(b_tindakan_kamar.status_out = 0, 
										  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 1, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.tarip), 
										  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 0, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.tarip)) biaya,
										  
										  IF(b_tindakan_kamar.status_out = 0, 
										  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 1, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.beban_kso), 
										  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 0, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.beban_kso)) jaminan 
										FROM
										  b_tindakan_kamar 
										  INNER JOIN b_pelayanan 
											ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id  
										WHERE 
										b_pelayanan.kunjungan_id = '$idKunj'
										AND b_tindakan_kamar.kso_id = '".$rwKunj['id']."' 
										AND b_tindakan_kamar.aktif = 1
										$fJenisKunjungan
										) AS kmr) AS gab";
							//echo $sKSO."<br></br>";
							$qKSO=mysql_query($sKSO);
							$rwKSO=mysql_fetch_array($qKSO);
							$totBiayaKSO+=$rwKSO['total'];
							$totNilaiJaminan+=$rwKSO['total_jaminan'];
							
							$sKSOObat="SELECT
									  SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL 
									FROM
									  $dbapotek.a_penjualan ap 
									  INNER JOIN b_pelayanan 
										ON ap.NO_KUNJUNGAN = b_pelayanan.id
									  INNER JOIN $dbapotek.a_mitra am 
										ON am.IDMITRA=ap.KSO_ID
									  INNER JOIN b_ms_kso kso 
										ON kso.id=b_pelayanan.kso_id
									  INNER JOIN b_kunjungan
										ON b_kunjungan.id = b_pelayanan.kunjungan_id 
									WHERE 
									b_pelayanan.kunjungan_id = '$idKunj'
									$fJenisKunjungan
									AND kso.id = '".$rwKunj['id']."'
									AND ap.CARA_BAYAR=2
									AND ap.KRONIS<>2";
							//echo $sPavObat;
							$qKSOObat=mysql_query($sKSOObat);
							$rwKSOObat=mysql_fetch_array($qKSOObat);
							$totBiayaKSO+=$rwKSOObat['SUBTOTAL'];
							$totNilaiJaminan+=$rwKSOObat['SUBTOTAL'];
							
							$nilai_tarip=$totBiayaKSO;
							$nilai_jaminan=$totNilaiJaminan;	
						}
						
						$jenisKunj="AND jenis_kunjungan=".$rows['jenis_kunjungan'];
						$sPembayaran="SELECT SUM(nominal) as bayar FROM
										(select
										b.id, 
										if(b.tipe=1,b.titipan,b.nilai) as nominal
										from 
										(select * from b_bayar where 0=0 $jenisKunj) b 
										where b.kunjungan_id='$idKunj' AND b.kso_id='".$rwKunj['id']."'
										UNION
										select
										aku.ID,
										aku.TOTAL_HARGA as nominal
										from
										dbapotek.a_kredit_utang aku
										INNER JOIN b_pelayanan p ON p.id=aku.NO_PELAYANAN
										where p.kunjungan_id='$idKunj' AND p.kso_id='".$rwKunj['id']."'
										and aku.CARA_BAYAR=2 $jenisKunj) as tbl";
						//echo $sPembayaran."<br>";
						$qPembayaran=mysql_query($sPembayaran);
						$rwPembayaran=mysql_fetch_array($qPembayaran);
		?>
					<tr>
						<td width="120" align="right"><?php echo $i; ?>.</td>
						<td width="120" align="center"><?php echo $tgl; ?></td>
						<td width="120" align="center"><?php echo $rows['no_rm']; ?></td>
						<td width="250"><?php echo $rows['nama']; ?></td>
						<td width="150" align="right"><?php echo currency($nilai_tarip); ?></td>
						<td width="150" align="right"><?php echo currency($nilai_jaminan); ?></td>
						<td width="150" align="right"><?php echo currency($rwPembayaran['bayar']); ?></td>
                        <?php
						$sisa=$nilai_tarip-$nilai_jaminan-$rwPembayaran['bayar'];
						$lebih_bayar=0;
						$kurang_bayar=0;
						
						if($sisa<0){
							$lebih_bayar=abs($sisa);	
						}
						else{
							$kurang_bayar=$sisa;
						}
						?>
						<td width="150" align="right"><?php echo currency($kurang_bayar); ?></td>
                        <td width="150" align="right"><?php echo currency($lebih_bayar); ?></td>
					</tr>
		<?php
						$i++;
					}
						$subTagihan += $nilai_tarip;
						$subJaminan += $nilai_jaminan;
						$subIur += $rwPembayaran['bayar'];
						$subKurang += $kurang_bayar;
						$subLebih += $lebih_bayar;
				}
		?>
					<tr height="25" style="font-weight: bold;">
						<td colspan="3"></td>
						<td align="right" style="border-top: 1px solid #000;">Sub Total</td>
						<td align="right" style="border-top: 1px solid #000;"><?php echo currency($subTagihan); ?></td>
						<td align="right" style="border-top: 1px solid #000;"><?php echo currency($subJaminan); ?></td>
						<td align="right" style="border-top: 1px solid #000;"><?php echo currency($subIur); ?></td>
						<td align="right" style="border-top: 1px solid #000;"><?php echo currency($subKurang); ?></td>
                        <td align="right" style="border-top: 1px solid #000;"><?php echo currency($subLebih); ?></td>
					</tr>
		<?php
				$totTagihan += $subTagihan;
				$totJaminan += $subJaminan;
				$totIur += $subIur;
				$totKurang += $subKurang;
				$totLebih += $subLebih;
			}
		?>
				<tr height="25" style="font-weight:bold;">
					<td colspan="4" align="right" style="border-top: 1px solid #000; border-bottom: 1px solid #000;">Total</td>
					<td align="right" style="border-top: 1px solid #000; border-bottom: 1px solid #000;"><?php echo currency($totTagihan); ?></td>
					<td align="right" style="border-top: 1px solid #000; border-bottom: 1px solid #000;"><?php echo currency($totJaminan); ?></td>
					<td align="right" style="border-top: 1px solid #000; border-bottom: 1px solid #000;"><?php echo currency($totIur); ?></td>
					<td align="right" style="border-top: 1px solid #000; border-bottom: 1px solid #000;"><?php echo currency($totKurang); ?></td>
                    <td align="right" style="border-top: 1px solid #000; border-bottom: 1px solid #000;"><?php echo currency($totLebih); ?></td>
				</tr>
		</table>
		<div id="divCetak" style="text-align: center; padding-top: 10px;">
			<button onClick="cetak();" style="cursor:pointer;">
				<img src="../../icon/printButton.jpg" width="20" height="20" alt="" />
				<span style="vertical-align:top;">Cetak</span>
			</button>
			<button onClick="window.close();" style="cursor:pointer;">
				<img src="../../icon/erase.png" width="20" height="20" alt="" />
				<span style="vertical-align:top;">Tutup</span>
			</button>
		</div>
	</div>
</body>
</html>