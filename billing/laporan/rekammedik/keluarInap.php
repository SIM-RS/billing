<?php
include("../../sesi.php");

if($_POST['isExcel']=='yes'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="keluarInap.xls"');
}
?>
<title>.: Data Pasien Keluar :.</title>
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//$waktu = " AND DATE(b_tindakan_kamar.tgl_out) = '$tglAwal2' ";
		$waktu = " AND (DATE(b_pelayanan.tgl_krs) = '$tglAwal2' OR DATE(b_tindakan_kamar.tgl_out) = '$tglAwal2')";
		$waktuIn = " AND DATE(b_tindakan_kamar.tgl_in) = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		//$waktu = " and month(b_tindakan_kamar.tgl_out) = '$bln' and year(b_tindakan_kamar.tgl_out) = '$thn' ";
		$waktu = " and ((month(b_pelayanan.tgl_krs) = '$bln' and year(b_pelayanan.tgl_krs) = '$thn') or (month(b_tindakan_kamar.tgl_out) = '$bln' and year(b_tindakan_kamar.tgl_out) = '$thn'))";
		$waktuIn = " and month(b_tindakan_kamar.tgl_in) = '$bln' and year(b_tindakan_kamar.tgl_in) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		//$waktu = " and DATE(b_tindakan_kamar.tgl_out) between '$tglAwal2' and '$tglAkhir2' ";
		$waktu = " and ((DATE(b_pelayanan.tgl_krs) between '$tglAwal2' and '$tglAkhir2') or (DATE(b_tindakan_kamar.tgl_out) between '$tglAwal2' and '$tglAkhir2') )";
		$waktuIn = " and DATE(b_tindakan_kamar.tgl_in) between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$jnsLayanan = $_REQUEST['cmbJenisLayananM'];
	$tmpLayanan = $_REQUEST['cmbTempatLayananM'];
	$stsKunj = $_REQUEST['cmbKunj2'];
	$stsPas = $_REQUEST['StatusPas'];
		
	if($stsPas!=0){
		$fKso = "AND b_pelayanan.kso_id = '".$stsPas."'";
	}
	
	if($tmpLayanan==0){
		$fUnit = " b_pelayanan.jenis_kunjungan=3 ";
		$fUnit2 = " 0=0 ";
	}
	else{
		$fUnit = " b_pelayanan.unit_id = ".$tmpLayanan;
		$fUnit2 = " b_tindakan_kamar.unit_id_asal = ".$tmpLayanan;
	}
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$jnsLayanan."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
	if($tmpLayanan==0){
		$txtUnit = "SEMUA";
	}
	else{
		$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$tmpLayanan."'";
		$rsUnit2 = mysql_query($sqlUnit2);
		$rwUnit2 = mysql_fetch_array($rsUnit2);
		$txtUnit = $rwUnit2['nama'];
	}
	
	$qKso = "SELECT id, nama FROM b_ms_kso WHERE id = '".$stsPas."'";
	$rsKso = mysql_query($qKso);
	$rwKso = mysql_fetch_array($rsKso);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
?>
<table width="1300" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td height="70" valign="top" style="font-size:14px; font-weight:bold; text-align:center; text-transform:uppercase;">rekapitulasi data pasien keluar - rawat inap<br>tempat layanan - <?php echo $txtUnit;?><br><?php echo $Periode; ?></td>
	</tr>
	<tr>
		<td style="font-weight:bold;">&nbsp;Status Kunjungan : <?php echo $stsKunj; ?></td>
	</tr>
     <?php
	if($stsKunj!='DIPINDAHKAN') {
		if($_REQUEST['cmbKeadaanKeluar']!='0')
			$keadaanKeluar=$_REQUEST['cmbKeadaanKeluar'];
	?>
    <tr>
		<td style="font-weight:bold;">&nbsp;Keadaan Keluar : <?php if($_REQUEST['cmbKeadaanKeluar']!='0') echo $keadaanKeluar; else echo "SEMUA"; ?></td>
	</tr>
    <?php
	}
	?>
	<tr>
		<td>
			<?php if($stsKunj!='DIPINDAHKAN') {?>
				<div id="lama">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
						<tr style="font-weight:bold; text-align:center">
							<td height="30" width="3%" style="border-top:1px solid; border-bottom:1px solid;">No</td>
							<td width="90" style="border-top:1px solid; border-bottom:1px solid;">No RM</td>
							<td width="130" style="border-top:1px solid; border-bottom:1px solid;">Nama Pasien</td>
							<td style="border-top:1px solid; border-bottom:1px solid;">Alamat</td>
                            <td width="120" style="border-top:1px solid; border-bottom:1px solid;">Kecamatan</td>
							<td width="90" style="border-top:1px solid; border-bottom:1px solid;">Umur</td>
							<td width="30" style="border-top:1px solid; border-bottom:1px solid;">L/P</td>
							<td width="130" style="border-top:1px solid; border-bottom:1px solid;">Unit Pelayanan</td>
                            <td width="90" style="border-top:1px solid; border-bottom:1px solid;">Kelas</td>
							<td width="90" style="border-top:1px solid; border-bottom:1px solid;">Tgl MRS</td>
							<td width="130" style="border-top:1px solid; border-bottom:1px solid;">Cara Keluar</td>
							<td width="200" style="border-top:1px solid; border-bottom:1px solid;">Diagnosa
								<br />
								<table style="width:100%; border-collapse:collapse; border:0px; font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:bold; text-align:center;">
									<tr>
										<td style="border-top:1px solid #000; border-right:1px solid #000;">Ket</td>
										<td style="border-top:1px solid #000; border-right:1px solid #000;" width="50px">Kasus</td>
                                        <td style="border-top:1px solid #000;" width="50px">Prioritas</td>
									</tr>
								</table>
							</td>
                            <td width="130" style="border-top:1px solid; border-bottom:1px solid;">Dokter</td>
							<!--td width="6%" style="border-top:1px solid; border-bottom:1px solid;">Verifikasi</td>
							<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">Verifikator</td-->
						</tr>
						<?php
								if($stsKunj!='SEMUA')
									$fCara = "AND b_pasien_keluar.cara_keluar = '".$stsKunj."'";
								
								if($_REQUEST['cmbKeadaanKeluar']!='0')
									$fKeadaanKeluar = "AND b_pasien_keluar.keadaan_keluar = '".$_REQUEST['cmbKeadaanKeluar']."'";
								
								$qK = "SELECT b_ms_kso.id, b_ms_kso.nama, b_tindakan_kamar.tgl_out 
								FROM b_kunjungan  
								INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id 
								INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
								INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id 
								LEFT JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id = b_pelayanan.id 
								WHERE $fUnit $waktu $fCara $fKeadaanKeluar $fKso 
								AND b_pelayanan.batal=0
								GROUP BY b_ms_kso.id 
								ORDER BY b_ms_kso.nama";
								$rsK = mysql_query($qK);
								while($rwK = mysql_fetch_array($rsK))
								{
						?>
						<tr>
							<td colspan="12" style="font-weight:bold; text-decoration:underline; text-transform:uppercase; padding-left:20px;" height="30" valign="bottom"><?php echo $rwK['nama'];?></td>
						</tr>
						<?php
								$sql = "SELECT b_ms_pasien.id AS pasien_id, b_pelayanan.id AS pelayanan_id, b_ms_pasien.no_rm, b_ms_pasien.nama, b_ms_pasien.alamat, (SELECT nama FROM b_ms_wilayah WHERE id=b_kunjungan.kec_id) kec,
								b_kunjungan.umur_hr, b_kunjungan.umur_bln, b_kunjungan.umur_thn, 
								IF(b_kunjungan.umur_thn=0 AND b_kunjungan.umur_bln=0,
  								CONCAT(b_kunjungan.umur_thn,'thn ',b_kunjungan.umur_bln,' bln ',DATEDIFF(b_kunjungan.tgl,b_ms_pasien.tgl_lahir),' hr'),
  								CONCAT(b_kunjungan.umur_thn,'thn ',b_kunjungan.umur_bln,' bln ',b_kunjungan.umur_hr,' hr')
  								) AS usia,
								b_ms_pasien.sex, b_ms_kelas.nama AS kelas, DATE_FORMAT(b_tindakan_kamar.tgl_in,'%d-%m-%Y') AS mrs, b_pasien_keluar.cara_keluar, b_pasien_keluar.keadaan_keluar, IF(b_tindakan_kamar.verifikasi=1,'SUDAH','BELUM') AS verifikasi, IF(b_pelayanan.verifikator='','-',b_ms_pegawai.nama) AS verifikator,
								mu.nama as unit 
								FROM b_kunjungan 
								INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id 
								INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
								INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_kunjungan.pasien_id 
								INNER JOIN b_ms_kelas ON b_ms_kelas.id = b_tindakan_kamar.kelas_id 
								INNER JOIN b_ms_unit ON b_ms_unit.id = b_tindakan_kamar.unit_id_asal
								INNER JOIN b_ms_unit mu ON mu.id = b_pelayanan.unit_id 
								LEFT JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id = b_pelayanan.id 
								LEFT JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id = b_pelayanan.id 
								LEFT JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id 
								LEFT JOIN b_ms_pegawai ON b_ms_pegawai.id = b_pelayanan.verifikator 
								WHERE $fUnit AND b_pelayanan.kso_id = '".$rwK['id']."' $fCara $fKeadaanKeluar $fKso $waktu 
								AND b_pelayanan.batal=0
								GROUP BY b_pelayanan.id ";
								//echo $sql."<br><br>";
								$rs = mysql_query($sql);
								$no = 1;
								while($rw = mysql_fetch_array($rs))
								{
									/*$sDiag="SELECT 
											  md.kode,
											  md.nama,
											  d.primer 
											FROM
											  b_ms_diagnosa md 
											  INNER JOIN b_diagnosa_rm d 
												ON d.ms_diagnosa_id = md.id 
											WHERE d.pelayanan_id = '".$rw['pelayanan_id']."' 
											ORDER BY d.primer DESC,
											  md.kode";
									$qDiag = mysql_query($sDiag);*/
									$dokter="";
									$sql="SELECT DISTINCT peg.nama AS dokter FROM b_tindakan t INNER JOIN b_ms_pegawai peg ON t.user_id=peg.id WHERE t.pelayanan_id='".$rw["pelayanan_id"]."' AND peg.spesialisasi_id>0";
									$rs1=mysql_query($sql);
									while ($rw1=mysql_fetch_array($rs1)){
										$dokter .=$rw1["dokter"]."<br>";
									}
									if ($dokter!="") $dokter=substr($dokter,0,strlen($dokter)-4);
									
									$sql="SELECT IF(d.ms_diagnosa_id=0,d.diagnosa_manual,md.nama) diagnosa,
		IFNULL(mdrm.kode,'') icd10,
		IF(drm.kasus_baru=0,'Lama',IF(drm.kasus_baru=1,'Baru','-')) kasus,
		IF(d.primer = 1,'Diagnosa Utama','Diagnosa Sekunder') prioritas  
		FROM b_diagnosa d LEFT JOIN b_ms_diagnosa md ON d.ms_diagnosa_id=md.id 
		LEFT JOIN b_diagnosa_rm drm ON d.diagnosa_id=drm.diagnosa_id
		LEFT JOIN b_ms_diagnosa mdrm ON drm.ms_diagnosa_id=mdrm.id
		WHERE d.pelayanan_id='".$rw["pelayanan_id"]."'
		UNION
		SELECT IFNULL(IF(d.ms_diagnosa_id = 0,d.diagnosa_manual,md.nama), mdrm.nama) AS diagnosa,
  		IFNULL(mdrm.kode, '') icd10, IF(drm.kasus_baru = 0,'Lama',IF(drm.kasus_baru = 1, 'Baru', '-')) kasus,
		IF(d.primer = 1,'Diagnosa Utama','Diagnosa Sekunder') prioritas  
		FROM b_diagnosa_rm drm LEFT JOIN b_diagnosa d ON drm.diagnosa_id = d.diagnosa_id
		LEFT JOIN b_ms_diagnosa md ON d.ms_diagnosa_id = md.id 
		LEFT JOIN b_ms_diagnosa mdrm ON drm.ms_diagnosa_id = mdrm.id 
		WHERE drm.pelayanan_id = '".$rw["pelayanan_id"]."' AND drm.ms_diagnosa_id <> 0";
									//echo $sql."<br /><br />";
									$rs1=mysql_query($sql);
									$diagnosa="";
									while ($rw1=mysql_fetch_array($rs1)){
										$icd10="";
										if ($rw1["icd10"]!=""){
											$icd10="[".$rw1["icd10"]."] ";
										}
										$diagnosa .="<tr>
											<td>".$icd10.$rw1["diagnosa"]."</td>
											<td width='50px' style='text-align:center;'>".$rw1["kasus"]."</td>
											<td width='50px' style='text-align:center;'>".$rw1["prioritas"]."</td>
										</tr>";
									}
									//if ($diagnosa!="") $diagnosa=substr($diagnosa,0,strlen($diagnosa)-4);
						?>
						<tr valign="top">
							<td style="text-align:center"><?php echo $no;?></td>
							<td style="text-align:center"><?php echo $rw['no_rm'];?></td>
							<td style="padding-left:5px; text-transform:uppercase;"><?php echo $rw['nama'];?></td>
							<td style="padding-left:5px; text-transform:uppercase;"><?php echo $rw['alamat'];?></td>
                            <td style="padding-left:5px; text-transform:uppercase;"><?php echo $rw['kec'];?></td>
							<td style="text-align:center"><?php echo $rw['usia'];?></td>
							<td style="text-align:center"><?php echo $rw['sex'];?></td>
                            <td style="text-align:center"><?php echo $rw['unit'];?></td>
							<td style="text-align:center"><?php echo $rw['kelas'];?></td>
							<td style="text-align:center"><?php echo $rw['mrs'];?></td>
							<td style="text-align:center"><?php echo $rw['cara_keluar']."/".$rw['keadaan_keluar'];  $rw['keadaan_keluar']; ?></td>
							<td style="padding-left:5px; text-transform:uppercase;">
								<table style="width:100%; border-collapse:collapse; border:0px; font-family:Arial, Helvetica, sans-serif; font-size:11px;">
									<?php echo $diagnosa; ?>
								</table>
							<?php 
							/*while($rDiag=mysql_fetch_array($qDiag)){
								if($rDiag['primer']==1){
									echo "- <b>".$rDiag['kode']." ".$rDiag['nama']."</b><br>";
								}
								else{
									echo "- ".$rDiag['kode']." ".$rDiag['nama']."<br>";
								}
							}*/
							//echo $diagnosa;
							?></td>
                            <td style="text-align:left"><?php echo $dokter;?></td>
							<!--td style="text-align:center; text-transform:uppercase;"><?php echo $rw['verifikasi'];?></td>
							<td style="text-align:center; text-transform:uppercase;"><?php echo $rw['verifikator'];?></td-->
						</tr>
						<?php
								$no++;
								}
								}
						?>
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
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<!--td>&nbsp;</td>
							<td>&nbsp;</td-->
						</tr>
					</table>
				</div>
			<?php }
				else {
			?>
				<div id="pindahan">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
						<tr style="font-weight:bold; text-align:center">
							<td height="30" width="3%" style="border-top:1px solid; border-bottom:1px solid;">No</td>
							<td width="5%" style="border-top:1px solid; border-bottom:1px solid;">No RM</td>
							<td width="13%" style="border-top:1px solid; border-bottom:1px solid;">Nama Pasien</td>
							<td width="13%" style="border-top:1px solid; border-bottom:1px solid;">Alamat</td>
                            <td width="150" style="border-top:1px solid; border-bottom:1px solid;">Kecamatan</td>
							<td width="5%" style="border-top:1px solid; border-bottom:1px solid;">Umur</td>
							<td width="3%" style="border-top:1px solid; border-bottom:1px solid;">L/P</td>
                            <td width="130" style="border-top:1px solid; border-bottom:1px solid;">Unit Pelayanan</td>
							<td width="7%" style="border-top:1px solid; border-bottom:1px solid;">Kelas</td>
							<td width="8%" style="border-top:1px solid; border-bottom:1px solid;">Tgl MRS</td>
                            <td width="9%" style="border-top:1px solid; border-bottom:1px solid;">Tgl Pindah</td>
							<td width="12%" style="border-top:1px solid; border-bottom:1px solid;">Ke Ruang</td>
							<!--td width="9%" style="border-top:1px solid; border-bottom:1px solid;">Verifikasi</td>
							<td width="13%" style="border-top:1px solid; border-bottom:1px solid;">Verifikator</td-->
						</tr>
						<?php
								$qK = "SELECT b_ms_kso.id, b_ms_kso.nama 
								FROM b_kunjungan 
								INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id 
								INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
								INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id 
								WHERE $fUnit2 $fKso $waktuIn 
								AND b_pelayanan.batal=0 
								GROUP BY b_ms_kso.id 
								ORDER BY b_ms_kso.nama";
								$rsK = mysql_query($qK);
								while($rwK = mysql_fetch_array($rsK))
								{
						?>
						<tr>
							<td colspan="12" style="font-weight:bold; text-decoration:underline; text-transform:uppercase; padding-left:20px;" height="30" valign="bottom"><?php echo $rwK['nama'];?></td>
						</tr>
						<?php
								$sql = "SELECT b_kunjungan.id as kunjungan_id,b_ms_pasien.id AS pasien_id, b_pelayanan.id AS pelayanan_id, b_ms_pasien.no_rm, b_ms_pasien.nama, b_ms_pasien.alamat, (SELECT nama FROM b_ms_wilayah WHERE id=b_kunjungan.kec_id) kec,
								b_kunjungan.umur_hr, b_kunjungan.umur_bln, b_kunjungan.umur_thn, 
								IF(b_kunjungan.umur_thn=0 AND b_kunjungan.umur_bln=0,
  								CONCAT(b_kunjungan.umur_thn,'thn ',b_kunjungan.umur_bln,' bln ',DATEDIFF(b_kunjungan.tgl,b_ms_pasien.tgl_lahir),' hr'),
  								CONCAT(b_kunjungan.umur_thn,'thn ',b_kunjungan.umur_bln,' bln ',b_kunjungan.umur_hr,' hr')
  								) AS usia,
								b_ms_pasien.sex, b_ms_kelas.nama AS kelas, DATE_FORMAT(b_tindakan_kamar.tgl_in,'%d-%m-%Y') AS tgl_pindah, 
								/* u.nama */ b_ms_unit.nama AS unit, b_ms_kamar.nama AS pindah, 
								IF(b_tindakan_kamar.verifikasi=1,'SUDAH','BELUM') AS verifikasi, 
								IF(b_pelayanan.verifikator='','-',b_ms_pegawai.nama) AS verifikator 
								FROM b_kunjungan INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id 
								INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
								INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_kunjungan.pasien_id 
								INNER JOIN b_ms_kelas ON b_ms_kelas.id = b_tindakan_kamar.kelas_id 
								INNER JOIN b_ms_unit ON b_ms_unit.id = b_tindakan_kamar.unit_id_asal 
								INNER JOIN b_ms_unit u ON u.id = b_pelayanan.unit_id 
								INNER JOIN b_ms_kamar ON b_ms_kamar.id = b_tindakan_kamar.kamar_id 
								LEFT JOIN b_ms_pegawai ON b_ms_pegawai.id = b_pelayanan.verifikator 
								WHERE $fUnit2 
								AND b_pelayanan.kso_id = '".$rwK['id']."' $waktuIn 
								AND b_pelayanan.batal=0 
								GROUP BY b_pelayanan.id";
								$rs = mysql_query($sql);
								$no = 1;
								while($rw = mysql_fetch_array($rs))
								{
						?>
						<tr valign="top">
					    <td style="text-align:center"><?php echo $no;?></td>
							<td style="text-align:center"><?php echo $rw['no_rm'];?></td>
							<td style="padding-left:5px; text-transform:uppercase;"><?php echo $rw['nama'];?></td>
							<td style="padding-left:5px; text-transform:uppercase;"><?php echo $rw['alamat'];?></td>
                            <td style="padding-left:5px; text-transform:uppercase;"><?php echo $rw['kec'];?></td>
							<td style="text-align:center"><?php echo $rw['usia'];?></td>
							<td style="text-align:center"><?php echo $rw['sex'];?></td>
							<td style="text-align:left"><?php echo $rw['unit'];?></td>
							<td style="text-align:center"><?php echo $rw['kelas'];?></td>
                            <?php
							$sMRS="SELECT DATE_FORMAT(tgl,'%d-%m-%Y') mrs 
							FROM b_pelayanan WHERE kunjungan_id='".$rw['kunjungan_id']."' 
							AND jenis_kunjungan=3 
							AND b_pelayanan.batal=0 
							ORDER BY tgl ASC LIMIT 1";
							$qMRS=mysql_query($sMRS);
							$rwMRS=mysql_fetch_array($qMRS);
							?>
							<td style="text-align:center"><?php echo $rwMRS['mrs'];?></td>
                            <td style="text-align:center"><?php echo $rw['tgl_pindah'];?></td>
							<td style="padding-left:5px; text-transform:uppercase;"><?php echo $rw['pindah'];?></td>
							<!--td style="text-align:center; text-transform:uppercase;"><?php echo $rw['verifikasi'];?></td>
							<td style="text-align:center; text-transform:uppercase;"><?php echo $rw['verifikator'];?></td-->
						</tr>
						<?php
								$no++;
								}
								}
						?>
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
							<td>&nbsp;</td>
							<!--td>&nbsp;</td>
							<td>&nbsp;</td-->
						</tr>
					</table>
				</div>
			<?php
					}
			?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="border-top:1px solid #000; padding-top:5px; font-size:12px;" align="right">
			Printed By : <?php echo $rwPeg['nama']; ?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>