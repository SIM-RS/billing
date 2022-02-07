<?php
session_start();
include("../../sesi.php");

if($_POST['isExcel']=='yes'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="keluarJalan.xls"');
}

?>
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " AND DATE(b_pelayanan.tgl_krs) = '$tglAwal2' ";
		$waktuIn = " AND DATE(b_pelayanan.tgl) = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(b_pelayanan.tgl_krs) = '$bln' and year(b_pelayanan.tgl_krs) = '$thn' ";
		$waktuIn = " and month(b_pelayanan.tgl) = '$bln' and year(b_pelayanan.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and DATE(b_pelayanan.tgl_krs) between '$tglAwal2' and '$tglAkhir2' ";
		$waktuIn = " and DATE(b_pelayanan.tgl) between '$tglAwal2' and '$tglAkhir2' ";
		
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
		$fUnit = " b_pelayanan.jenis_kunjungan = ".$jnsLayanan;
		if($jnsLayanan==1){
		$fUnit2 = " b_pelayanan.unit_id_asal IN 
					  (SELECT 
					  id
					FROM
					  b_ms_unit 
					WHERE b_ms_unit.inap = 0 
					  AND b_ms_unit.penunjang = 0 
					  AND b_ms_unit.aktif = 1 
					  AND b_ms_unit.level = 2 
					  AND b_ms_unit.kategori = 2)";
		}
		else if($jnsLayanan==2){
		$fUnit2 = " b_pelayanan.unit_id_asal IN 
					  (SELECT 
					  id 
					FROM
					  b_ms_unit 
					WHERE aktif = 1 
					  AND parent_id = 44)";
		
		}
	}
	else{
		$fUnit = " b_pelayanan.unit_id = ".$tmpLayanan;
		$fUnit2 = " b_pelayanan.unit_id_asal = ".$tmpLayanan;
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
<title>.: Data Pasien Keluar :.</title>
<table width="1000" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td height="70" valign="top" style="font-size:14px; font-weight:bold; text-align:center; text-transform:uppercase;">rekapitulasi data pasien keluar - <?php if($jnsLayanan=='1') echo "RAWAT JALAN"; else echo "RAWAT DARURAT"; ?><br>tempat layanan - <?php echo $txtUnit;?><br><?php echo $Periode;?></td>
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
							<td width="6%" style="border-top:1px solid; border-bottom:1px solid;">No RM</td>
							<td width="15%" style="border-top:1px solid; border-bottom:1px solid;">Nama Pasien</td>
							<td width="15%" style="border-top:1px solid; border-bottom:1px solid;">Alamat</td>
							<td width="6%" style="border-top:1px solid; border-bottom:1px solid;">Umur</td>
							<td width="3%" style="border-top:1px solid; border-bottom:1px solid;">L/P</td>
							
							<td width="6%" style="border-top:1px solid; border-bottom:1px solid;">Tgl</td>
							<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">Cara Keluar</td>
							<td width="17%" style="border-top:1px solid; border-bottom:1px solid;">Diagnosa</td>
							<td width="6%" style="border-top:1px solid; border-bottom:1px solid;">Verifikasi</td>
							<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">Verifikator</td>
						</tr>
						<?php
								
								if($stsKunj!='SEMUA')
									$fCara = "AND b_pasien_keluar.cara_keluar = '".$stsKunj."'";					
								
								if($_REQUEST['cmbKeadaanKeluar']!='0')
									$fKeadaanKeluar = "AND b_pasien_keluar.keadaan_keluar = '".$_REQUEST['cmbKeadaanKeluar']."'";
								/*
								$qK = "SELECT b_ms_kso.id, b_ms_kso.nama, b_tindakan_kamar.tgl_out FROM b_kunjungan  INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id = b_pelayanan.id WHERE $fUnit $waktu $fCara $fKso
GROUP BY b_ms_kso.id ORDER BY b_ms_kso.nama";
								*/

								$qK = "SELECT DISTINCT 
									  b_ms_kso.id,
									  b_ms_kso.nama 
									FROM
									  b_kunjungan 
									  INNER JOIN b_pelayanan 
										ON b_kunjungan.id = b_pelayanan.kunjungan_id 
									  INNER JOIN b_pasien_keluar 
										ON b_pelayanan.id = b_pasien_keluar.pelayanan_id 
									  INNER JOIN b_ms_pasien 
										ON b_ms_pasien.id = b_pelayanan.pasien_id 
									  INNER JOIN b_ms_kso 
										ON b_ms_kso.id = b_pelayanan.kso_id 
									WHERE 
									  $fUnit
									  $waktu 
									  $fCara
									  $fKeadaanKeluar
									  $fKso 
									ORDER BY b_ms_kso.nama";
								$rsK = mysql_query($qK);
								while($rwK = mysql_fetch_array($rsK))
								{
						?>
						<tr>
							<td colspan="12" style="font-weight:bold; text-decoration:underline; text-transform:uppercase; padding-left:20px;" height="30" valign="bottom"><?php echo $rwK['nama'];?></td>
						</tr>
						<?php
								/*
								$sql = "SELECT b_ms_pasien.id AS pasien_id, b_pelayanan.id AS pelayanan_id, b_ms_pasien.no_rm, b_ms_pasien.nama, b_ms_pasien.alamat, b_kunjungan.umur_bln, b_kunjungan.umur_thn, b_ms_pasien.sex, b_ms_kelas.nama AS kelas, DATE_FORMAT(b_tindakan_kamar.tgl_in,'%d-%m-%Y') AS mrs, b_pasien_keluar.cara_keluar, GROUP_CONCAT(DISTINCT CONCAT('- ',b_ms_diagnosa.kode,' ',b_ms_diagnosa.nama) SEPARATOR '<br>') AS diagnosa, IF(b_tindakan_kamar.verifikasi=1,'SUDAH','BELUM') AS verifikasi, IF(b_pelayanan.verifikator='','-',b_ms_pegawai.nama) AS verifikator FROM b_kunjungan INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_kunjungan.pasien_id INNER JOIN b_ms_kelas ON b_ms_kelas.id = b_tindakan_kamar.kelas_id INNER JOIN b_ms_unit ON b_ms_unit.id = b_tindakan_kamar.unit_id_asal INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id = b_pelayanan.id LEFT JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id = b_pelayanan.id LEFT JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id LEFT JOIN b_ms_pegawai ON b_ms_pegawai.id = b_pelayanan.verifikator WHERE $fUnit AND b_pelayanan.kso_id = '".$rwK['id']."' $fCara $fKso $waktu GROUP BY b_pelayanan.id ";
								*/
								//echo $sql."<br><br>";
								$sql="SELECT DISTINCT
									  b_pelayanan.id AS id_pelayanan, 
									  b_ms_pasien.no_rm,
									  b_ms_pasien.nama,
									  b_ms_pasien.alamat,
									  b_kunjungan.umur_thn,
									  b_kunjungan.umur_bln,
									  b_ms_pasien.sex,
									  DATE_FORMAT(b_pelayanan.tgl, '%d-%m-%Y') AS tgl,
									  b_pasien_keluar.cara_keluar,
									  b_pasien_keluar.keadaan_keluar,
									  IF(
										b_pelayanan.verifikasi = 1,
										'SUDAH',
										'BELUM'
									  ) AS verifikasi,
									  IF(
										b_pelayanan.verifikator = '',
										'-',
										b_ms_pegawai.nama
									  ) AS verifikator 
									FROM
									  b_kunjungan 
									  INNER JOIN b_pelayanan 
										ON b_kunjungan.id = b_pelayanan.kunjungan_id 
									  INNER JOIN b_pasien_keluar 
										ON b_pelayanan.id = b_pasien_keluar.pelayanan_id 
									  INNER JOIN b_ms_pasien 
										ON b_ms_pasien.id = b_pelayanan.pasien_id 
									  INNER JOIN b_ms_kso 
										ON b_ms_kso.id = b_pelayanan.kso_id 
									  LEFT JOIN b_diagnosa_rm 
										ON b_diagnosa_rm.pelayanan_id = b_pelayanan.id 
									  LEFT JOIN b_ms_diagnosa 
										ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id 
									  LEFT JOIN b_ms_pegawai 
										ON b_ms_pegawai.id = b_pelayanan.verifikator 
									WHERE 
									  $fUnit
									  $waktu 
									  $fCara
									  $fKeadaanKeluar
									  AND b_pelayanan.kso_id = '".$rwK['id']."'
									GROUP BY b_pelayanan.id 
									ORDER BY b_ms_pasien.no_rm";
								$rs = mysql_query($sql);
								$no = 1;
								while($rw = mysql_fetch_array($rs))
								{
									$sDiag="SELECT 
											  md.kode,
											  md.nama,
											  d.primer 
											FROM
											  b_ms_diagnosa md 
											  INNER JOIN b_diagnosa_rm d 
												ON d.ms_diagnosa_id = md.id 
											WHERE d.pelayanan_id = '".$rw['id_pelayanan']."' 
											ORDER BY d.primer DESC,
											  md.kode";
									$qDiag = mysql_query($sDiag);
						?>
						<tr valign="top">
							<td style="text-align:center"><?php echo $no;?></td>
							<td style="text-align:center"><?php echo $rw['no_rm'];?></td>
							<td style="padding-left:5px; text-transform:uppercase;"><?php echo $rw['nama'];?></td>
							<td style="padding-left:5px; text-transform:uppercase;"><?php echo $rw['alamat'];?></td>
							<td style="text-align:center"><?php echo $rw['umur_thn'].'thn '.$rw['umur_bln'].'bln';?></td>
							<td style="text-align:center"><?php echo $rw['sex'];?></td>
							
							<td style="text-align:center"><?php echo $rw['tgl'];?></td>
							<td style="text-align:center"><?php echo $rw['cara_keluar']."/".$rw['keadaan_keluar'];?></td>
							<td style="padding-left:5px; text-transform:uppercase;"><?php 
							while($rDiag=mysql_fetch_array($qDiag)){
								if($rDiag['primer']==1){
									echo "- <b>".$rDiag['kode']." ".$rDiag['nama']."</b><br>";
								}
								else{
									echo "- ".$rDiag['kode']." ".$rDiag['nama']."<br>";
								}
							}
							?></td>
							<td style="text-align:center; text-transform:uppercase;"><?php echo $rw['verifikasi'];?></td>
							<td style="text-align:center; text-transform:uppercase;"><?php echo $rw['verifikator'];?></td>
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
						</tr>
					</table>
				</div>
			<?php }
				else {
			?>
				<div id="pindahan">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
						<tr style="font-weight:bold; text-align:center">
							<td height="30" width="4%" style="border-top:1px solid; border-bottom:1px solid;">No</td>
							<td width="6%" style="border-top:1px solid; border-bottom:1px solid;">No RM</td>
							<td width="15%" style="border-top:1px solid; border-bottom:1px solid;">Nama Pasien</td>
							<td width="15%" style="border-top:1px solid; border-bottom:1px solid;">Alamat</td>
							<td width="6%" style="border-top:1px solid; border-bottom:1px solid;">Umur</td>
							<td width="4%" style="border-top:1px solid; border-bottom:1px solid;">L/P</td>
							
							<td width="6%" style="border-top:1px solid; border-bottom:1px solid;">Tgl</td>
							<td width="15%" style="border-top:1px solid; border-bottom:1px solid;">Ke Ruang</td>
							<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">Verifikasi</td>
							<td width="15%" style="border-top:1px solid; border-bottom:1px solid;">Verifikator</td>
						</tr>
						<?php
								/*
								$qK = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_kunjungan INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id WHERE $fUnit2 $fKso $waktuIn GROUP BY b_ms_kso.id ORDER BY b_ms_kso.nama";
								*/
								
								$qK = "SELECT DISTINCT 
									  b_ms_kso.id,
									  b_ms_kso.nama 
									FROM
									  b_kunjungan 
									  INNER JOIN b_pelayanan 
										ON b_kunjungan.id = b_pelayanan.kunjungan_id 
									  INNER JOIN b_pasien_keluar 
										ON b_pelayanan.id = b_pasien_keluar.pelayanan_id 
									  INNER JOIN b_ms_pasien 
										ON b_ms_pasien.id = b_pelayanan.pasien_id 
									  INNER JOIN b_ms_kso 
										ON b_ms_kso.id = b_pelayanan.kso_id 
									WHERE 
									  $fUnit2
									  $waktuIn 
									  $fKso 
									ORDER BY b_ms_kso.nama";
								$rsK = mysql_query($qK);
								while($rwK = mysql_fetch_array($rsK))
								{
						?>
						<tr>
							<td colspan="11" style="font-weight:bold; text-decoration:underline; text-transform:uppercase; padding-left:20px;" height="30" valign="bottom"><?php echo $rwK['nama'];?></td>
						</tr>
						<?php
						/*
								$sql = "SELECT b_ms_pasien.id AS pasien_id, b_pelayanan.id AS pelayanan_id, b_ms_pasien.no_rm, b_ms_pasien.nama, b_ms_pasien.alamat, b_kunjungan.umur_bln, b_kunjungan.umur_thn, b_ms_pasien.sex, b_ms_kelas.nama AS kelas, DATE_FORMAT(b_tindakan_kamar.tgl_in,'%d-%m-%Y') AS mrs, u.nama AS unit, b_ms_kamar.nama AS pindah, IF(b_tindakan_kamar.verifikasi=1,'SUDAH','BELUM') AS verifikasi, IF(b_pelayanan.verifikator='','-',b_ms_pegawai.nama) AS verifikator FROM b_kunjungan INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_kunjungan.pasien_id INNER JOIN b_ms_kelas ON b_ms_kelas.id = b_tindakan_kamar.kelas_id INNER JOIN b_ms_unit ON b_ms_unit.id = b_tindakan_kamar.unit_id_asal INNER JOIN b_ms_unit u ON u.id = b_pelayanan.unit_id INNER JOIN b_ms_kamar ON b_ms_kamar.id = b_tindakan_kamar.kamar_id LEFT JOIN b_ms_pegawai ON b_ms_pegawai.id = b_pelayanan.verifikator WHERE $fUnit2 AND b_pelayanan.kso_id = '".$rwK['id']."' $waktuIn GROUP BY b_pelayanan.id";
						*/		
								$sql="SELECT DISTINCT 
									  b_ms_pasien.no_rm,
									  b_ms_pasien.nama,
									  b_ms_pasien.alamat,
									  b_kunjungan.umur_thn,
									  b_kunjungan.umur_bln,
									  b_ms_pasien.sex,
									  DATE_FORMAT(b_pelayanan.tgl, '%d-%m-%Y') AS tgl,
									  IF(
										b_pelayanan.verifikasi = 1,
										'SUDAH',
										'BELUM'
									  ) AS verifikasi,
									  IF(
										b_pelayanan.verifikator = '',
										'-',
										b_ms_pegawai.nama
									  ) AS verifikator,
									  u.nama asal,
									  b_ms_unit.nama ke_ruang 
									FROM
									  b_kunjungan 
									  INNER JOIN b_pelayanan 
										ON b_kunjungan.id = b_pelayanan.kunjungan_id 
									  INNER JOIN b_ms_pasien 
										ON b_ms_pasien.id = b_pelayanan.pasien_id 
									  INNER JOIN b_ms_kso 
										ON b_ms_kso.id = b_pelayanan.kso_id 
									  LEFT JOIN b_diagnosa_rm 
										ON b_diagnosa_rm.pelayanan_id = b_pelayanan.id 
									  LEFT JOIN b_ms_diagnosa 
										ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id 
									  LEFT JOIN b_ms_pegawai 
										ON b_ms_pegawai.id = b_pelayanan.verifikator 
									  INNER JOIN b_ms_unit 
										ON b_ms_unit.id = b_pelayanan.unit_id 
									  INNER JOIN b_ms_unit u 
										ON u.id = b_pelayanan.unit_id_asal 
									WHERE 
									  $fUnit2
									  $waktuIn 
									  AND b_pelayanan.kso_id = '".$rwK['id']."'
									GROUP BY b_pelayanan.id 
									ORDER BY b_ms_pasien.no_rm";
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
							<td style="text-align:center"><?php echo $rw['umur_thn'].'thn '.$rw['umur_bln'].'bln';?></td>
							<td style="text-align:center"><?php echo $rw['sex'];?></td>
							
							<td style="text-align:center"><?php echo $rw['tgl'];?></td>
							<td style="padding-left:5px; text-transform:uppercase;"><?php echo $rw['ke_ruang'];?></td>
							<td style="text-align:center; text-transform:uppercase;"><?php echo $rw['verifikasi'];?></td>
							<td style="text-align:center; text-transform:uppercase;"><?php echo $rw['verifikator'];?></td>
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
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>