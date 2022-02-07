<?php
session_start();
include("../../sesi.php");

if($_POST['isExcel']=='yes'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="masukInap.xls"');
}


?>
<title>.: Data Pasien Masuk Rawat Inap :.</title>
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " AND DATE(b_tindakan_kamar.tgl_in) = '$tglAwal2' ";
		$waktuLama = " AND DATE(b_tindakan_kamar.tgl_in) < '$tglAwal2' ";
		$waktuSemua = " AND DATE(b_tindakan_kamar.tgl_in) <= '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(b_tindakan_kamar.tgl_in) = '$bln' and year(b_tindakan_kamar.tgl_in) = '$thn' ";
		$waktuLama = " and month(b_tindakan_kamar.tgl_in) < '$bln' and year(b_tindakan_kamar.tgl_in) < '$thn' ";
		$waktuSemua = " and month(b_tindakan_kamar.tgl_in) <= '$bln' and year(b_tindakan_kamar.tgl_in) <= '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and DATE(b_tindakan_kamar.tgl_in) between '$tglAwal2' and '$tglAkhir2' ";
		$waktuLama = " and DATE(b_tindakan_kamar.tgl_in) between '$tglAwal2' and '$tglAkhir2' ";
		$waktuSemua = " and DATE(b_tindakan_kamar.tgl_in) between '$tglAwal2' and '$tglAkhir2' ";
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$jnsLayanan = $_REQUEST['cmbJenisLayananM'];
	$tmpLayanan = $_REQUEST['cmbTempatLayananM'];
	$stsKunj = $_REQUEST['cmbKunj'];
	$stsPas = $_REQUEST['StatusPas'];
		
	if($stsPas!=0){
		$fKso = "AND b_kunjungan.kso_id = '".$stsPas."'";
	}
	
	if($tmpLayanan==0){
		$fUnit = " b_pelayanan.jenis_kunjungan=3 ";
	}
	else{
		$fUnit = " b_pelayanan.unit_id = ".$tmpLayanan;
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
<table width="1000" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td height="70" valign="top" style="font-size:14px; font-weight:bold; text-align:center; text-transform:uppercase;">rekapitulasi data pasien masuk - RAWAT INAP<br>tempat layanan - <?php echo $txtUnit; ?><br><?php echo $Periode;?></td>
	</tr>
	<tr>
		<td height="30" style="font-weight:bold;">&nbsp;Status Kunjungan : <?php 
		if($stsKunj=='0'){ 
			echo "LAMA"; 
		}
		else if($stsKunj=='1'){ 
			echo "BARU";
		} 
		else if($stsKunj=='2'){
			echo "PINDAHAN";
		}
		else{
			echo "SEMUA";
		}
		?></td>
	</tr>
	<tr>
		<td>
			<?php if($stsKunj=='0' || $stsKunj=='1' ||$stsKunj=='') {?>
				<div id="lama">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
						<tr style="font-weight:bold; text-align:center">
							<td height="30" width="2%" style="border-top:1px solid; border-bottom:1px solid;">No</td>
							<td width="5%" style="border-top:1px solid; border-bottom:1px solid;">No RM</td>
							<td width="6%" style="border-top:1px solid; border-bottom:1px solid;">Kunjungan</td>
							<td width="8%" style="border-top:1px solid; border-bottom:1px solid;">Nama Pasien</td>
							<td width="9%" style="border-top:1px solid; border-bottom:1px solid;">Alamat</td>
							<td width="6%" style="border-top:1px solid; border-bottom:1px solid;">Kecamatan</td>
							<td width="4%" style="border-top:1px solid; border-bottom:1px solid;">Umur</td>
							<td width="3%" style="border-top:1px solid; border-bottom:1px solid;">L/P</td>
							<td width="11%" style="border-top:1px solid; border-bottom:1px solid;">Diagnosa Masuk</td>
							<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">Diagnosa Akhir</td>
							<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">Dokter Yang Merawat</td>
							<td width="7%" style="border-top:1px solid; border-bottom:1px solid;">Kelas</td>
							<td width="6%" style="border-top:1px solid; border-bottom:1px solid;">Tgl MRS</td>
							<td width="6%" style="border-top:1px solid; border-bottom:1px solid;">Ruangan</td>
							<td width="7%" style="border-top:1px solid; border-bottom:1px solid;">Asal Kunjungan</td>
						</tr>
						<?php
								if($stsKunj=='0'){ 
									$qK = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_kunjungan INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id WHERE $fUnit AND b_tindakan_kamar.tgl_out IS NULL $fKso $waktuLama GROUP BY b_ms_kso.id ORDER BY b_ms_kso.nama";
								}else if($stsKunj=='1'){
									$qK = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_kunjungan INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id WHERE $fUnit AND b_tindakan_kamar.tgl_out IS NULL $fKso $waktu GROUP BY b_ms_kso.id ORDER BY b_ms_kso.nama";
								}else if($stsKunj==''){
									$qK = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_kunjungan INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id WHERE $fUnit AND b_tindakan_kamar.tgl_out IS NULL $fKso $waktuSemua GROUP BY b_ms_kso.id ORDER BY b_ms_kso.nama";
								}
								$rsK = mysql_query($qK);
								while($rwK = mysql_fetch_array($rsK))
								{
						?>
						<tr>
							<td colspan="15" style="font-weight:bold; text-decoration:underline; text-transform:uppercase; padding-left:20px;"><?php echo $rwK['nama'];?></td>
						</tr>
						<?php
								if($stsKunj=='0'){ 
									$sql = "SELECT 
									b_pelayanan.id AS pelayanan_id,
									b_pelayanan.kunjungan_id, 
									b_ms_pasien.no_rm, 
									b_ms_pasien.nama, 
									b_ms_pasien.alamat,
									(SELECT nama FROM b_ms_wilayah WHERE id=b_kunjungan.kec_id) kec, 
									b_kunjungan.umur_bln, 
									b_kunjungan.umur_thn, 
									b_ms_pasien.sex, 
									b_ms_kelas.nama AS kelas, 
									DATE_FORMAT(b_tindakan_kamar.tgl_in,'%d-%m-%Y') AS mrs, 
									b_ms_unit.nama AS asal,
									mu.nama AS ruangan,
									if(b_kunjungan.isbaru='1','Baru','Lama') AS kunjungan 
									FROM b_kunjungan 
									INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id
									INNER JOIN b_ms_unit as mu ON mu.id = b_pelayanan.unit_id 
									INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
									INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_kunjungan.pasien_id 
									INNER JOIN b_ms_kelas ON b_ms_kelas.id = b_tindakan_kamar.kelas_id 
									INNER JOIN b_ms_unit ON b_ms_unit.id = b_tindakan_kamar.unit_id_asal 
									WHERE $fUnit AND b_pelayanan.kso_id = '".$rwK['id']."' AND b_ms_unit.inap <> '1' 
									AND b_tindakan_kamar.tgl_out IS NULL $waktuLama 
									GROUP BY b_pelayanan.id";
								}else if($stsKunj=='1'){
									$sql = "SELECT 
									b_pelayanan.id AS pelayanan_id,
									b_pelayanan.kunjungan_id, 
									b_ms_pasien.no_rm, 
									b_ms_pasien.nama, 
									b_ms_pasien.alamat,
									(SELECT nama FROM b_ms_wilayah WHERE id=b_kunjungan.kec_id) kec, 
									b_kunjungan.umur_bln, 
									b_kunjungan.umur_thn, 
									b_ms_pasien.sex,
									b_ms_kelas.nama AS kelas, 
									DATE_FORMAT(b_tindakan_kamar.tgl_in,'%d-%m-%Y') AS mrs, 
									b_ms_unit.nama AS asal,
									mu.nama AS ruangan,
									if(b_kunjungan.isbaru='1','Baru','Lama') AS kunjungan 
									FROM b_kunjungan 
									INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id
									INNER JOIN b_ms_unit as mu ON mu.id = b_pelayanan.unit_id   
									INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
									INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_kunjungan.pasien_id 
									INNER JOIN b_ms_kelas ON b_ms_kelas.id = b_tindakan_kamar.kelas_id 
									INNER JOIN b_ms_unit ON b_ms_unit.id = b_tindakan_kamar.unit_id_asal 
									WHERE $fUnit AND b_pelayanan.kso_id = '".$rwK['id']."' AND b_ms_unit.inap <> '1' 
									AND b_tindakan_kamar.tgl_out IS NULL $waktu 
									GROUP BY b_pelayanan.id";
								}else if($stsKunj==''){
									$sql = "SELECT 
									b_pelayanan.id AS pelayanan_id,
									b_pelayanan.kunjungan_id, 
									b_ms_pasien.no_rm, 
									b_ms_pasien.nama, 
									b_ms_pasien.alamat,
									(SELECT nama FROM b_ms_wilayah WHERE id=b_kunjungan.kec_id) kec, 
									b_kunjungan.umur_bln, 
									b_kunjungan.umur_thn, 
									b_ms_pasien.sex, 
									b_ms_kelas.nama AS kelas, 
									DATE_FORMAT(b_tindakan_kamar.tgl_in,'%d-%m-%Y') AS mrs, 
									b_ms_unit.nama AS asal,
									mu.nama AS ruangan,
									if(b_kunjungan.isbaru='1','Baru','Lama') AS kunjungan 
									FROM b_kunjungan 
									INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id
									INNER JOIN b_ms_unit as mu ON mu.id = b_pelayanan.unit_id 
									INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
									INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_kunjungan.pasien_id 
									INNER JOIN b_ms_kelas ON b_ms_kelas.id = b_tindakan_kamar.kelas_id 
									INNER JOIN b_ms_unit ON b_ms_unit.id = b_tindakan_kamar.unit_id_asal 
									WHERE $fUnit AND b_pelayanan.kso_id = '".$rwK['id']."' 
									AND b_tindakan_kamar.tgl_out IS NULL $waktuSemua 
									GROUP BY b_pelayanan.id";
								}
								//echo $sql."<br>";
								$rs = mysql_query($sql);
								$no = 1;
								while($rw = mysql_fetch_array($rs))
								{
						?>
						<tr>
							<td style="text-align:center" valign="top"><?php echo $no;?></td>
							<td style="text-align:center" valign="top"><?php echo $rw['no_rm'];?></td>
							<td style="padding-left:0px; text-transform:uppercase;" valign="top" align="center"><?php echo $rw['kunjungan'];?></td>
							<td style="padding-left:0px; text-transform:uppercase;" valign="top"><?php echo $rw['nama'];?></td>
							<td style="padding-left:0px; text-transform:uppercase;" valign="top"><?php echo $rw['alamat'];?></td>
						    <td style="text-align:center" valign="top"><?php echo $rw['kec'];?></td>
							<td style="text-align:center" valign="top"><?php echo $rw['umur_thn'].' thn '.$rw['umur_bln'].' bln';?></td>
							<td style="text-align:center" valign="top"><?php echo $rw['sex'];?></td>
						    <?php
							/*
							$sql="SELECT IF(d.ms_diagnosa_id=0,d.diagnosa_manual,md.nama) diagnosa1,
								IFNULL(drm.diagnosa_manual,b_ms_diagnosa2.nama) as diagnosa,
								IFNULL(mdrm.kode,'') icd10
								FROM b_diagnosa d LEFT JOIN b_ms_diagnosa md ON d.ms_diagnosa_id=md.id 
								LEFT JOIN b_diagnosa_rm drm ON d.diagnosa_id=drm.diagnosa_id
								LEFT JOIN b_ms_diagnosa mdrm ON drm.ms_diagnosa_id=mdrm.id
								inner join b_diagnosa ON b_diagnosa.diagnosa_id = drm.diagnosa_id
								left join b_ms_diagnosa as b_ms_diagnosa2 ON b_ms_diagnosa2.id = b_diagnosa.ms_diagnosa_id
								WHERE d.pelayanan_id='".$rw["pelayanan_id"]."'";
							*/
							$sql="SELECT IF(d.ms_diagnosa_id=0,d.diagnosa_manual,md.nama) diagnosa1,
								IFNULL(drm.diagnosa_manual,b_ms_diagnosa2.nama) as diagnosa,
								IFNULL(mdrm.kode,'') icd10
								FROM b_diagnosa d 
								INNER JOIN b_pelayanan pl ON pl.id=d.pelayanan_id
								LEFT JOIN b_ms_diagnosa md ON d.ms_diagnosa_id=md.id 
								LEFT JOIN b_diagnosa_rm drm ON d.diagnosa_id=drm.diagnosa_id
								LEFT JOIN b_ms_diagnosa mdrm ON drm.ms_diagnosa_id=mdrm.id
								inner join b_diagnosa ON b_diagnosa.diagnosa_id = drm.diagnosa_id
								left join b_ms_diagnosa as b_ms_diagnosa2 ON b_ms_diagnosa2.id = b_diagnosa.ms_diagnosa_id
								WHERE d.kunjungan_id='".$rw["kunjungan_id"]."' AND d.akhir=0";
							$rs1=mysql_query($sql);
							$diagnosa="";
							while ($rw1=mysql_fetch_array($rs1)){
								$icd10="";
								if ($rw1["icd10"]!=""){
									$icd10="[".$rw1["icd10"]."] ";
								}
								$diagnosa .=$icd10.$rw1["diagnosa"]."<br>";
							}
							if ($diagnosa!="") $diagnosa=substr($diagnosa,0,strlen($diagnosa)-4);
							?>
                            <td style="text-align:left" valign="top"><?php echo $diagnosa;?></td>
                            <?php
							$sqlA="SELECT IF(d.ms_diagnosa_id=0,d.diagnosa_manual,md.nama) diagnosa1,
								IFNULL(drm.diagnosa_manual,b_ms_diagnosa2.nama) as diagnosa,
								IFNULL(mdrm.kode,'') icd10
								FROM b_diagnosa d 
								INNER JOIN b_pelayanan pl ON pl.id=d.pelayanan_id
								LEFT JOIN b_ms_diagnosa md ON d.ms_diagnosa_id=md.id 
								LEFT JOIN b_diagnosa_rm drm ON d.diagnosa_id=drm.diagnosa_id
								LEFT JOIN b_ms_diagnosa mdrm ON drm.ms_diagnosa_id=mdrm.id
								inner join b_diagnosa ON b_diagnosa.diagnosa_id = drm.diagnosa_id
								left join b_ms_diagnosa as b_ms_diagnosa2 ON b_ms_diagnosa2.id = b_diagnosa.ms_diagnosa_id
								WHERE d.kunjungan_id='".$rw["kunjungan_id"]."' AND d.akhir=1";
							$rsA=mysql_query($sqlA);
							$diagnosaAkhir="";
							while ($rwA=mysql_fetch_array($rsA)){
								$icd10="";
								if ($rw1["icd10"]!=""){
									$icd10="[".$rw1["icd10"]."] ";
								}
								$diagnosaA .=$icd10.$rw1["diagnosa"]."<br>";
							}
							if ($diagnosaA!="") $diagnosaA=substr($diagnosaA,0,strlen($diagnosaA)-4);
							?>
                            <td style="text-align:left" valign="top"><?php echo $diagnosaA;?></td>
                            <?php
							$sDok="select pg.nama 
							from b_pelayanan pl
							inner join b_tindakan t on t.pelayanan_id=pl.id
							inner join b_ms_pegawai pg on pg.id=t.user_id
							where pl.id='".$rw["pelayanan_id"]."'";
							$qDok=mysql_query($sDok);
							$rwDok=mysql_fetch_array($qDok);
							?>
                          <td style="text-align:left" valign="top"><?php echo $rwDok['nama'];?></td>
							<td style="text-align:center" valign="top"><?php echo $rw['kelas'];?></td>
							<td style="text-align:center" valign="top"><?php echo $rw['mrs'];?></td>
						  <td style="padding-left:5px; text-transform:uppercase;" valign="top"><?php echo $rw['ruangan'];?></td>
							<td style="padding-left:5px; text-transform:uppercase;" valign="top"><?php echo $rw['asal'];?></td>
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
							<td height="30" width="2%" style="border-top:1px solid; border-bottom:1px solid;">No</td>
							<td width="5%" style="border-top:1px solid; border-bottom:1px solid;">No RM</td>
							<td width="6%" style="border-top:1px solid; border-bottom:1px solid;">Kunjungan</td>
							<td width="8%" style="border-top:1px solid; border-bottom:1px solid;">Nama Pasien</td>
							<td width="9%" style="border-top:1px solid; border-bottom:1px solid;">Alamat</td>
							<td width="6%" style="border-top:1px solid; border-bottom:1px solid;">Kecamatan</td>
							<td width="4%" style="border-top:1px solid; border-bottom:1px solid;">Umur</td>
							<td width="3%" style="border-top:1px solid; border-bottom:1px solid;">L/P</td>
							<td width="11%" style="border-top:1px solid; border-bottom:1px solid;">Diagnosa Masuk</td>
							<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">Diagnosa Akhir</td>
							<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">Dokter Yang Merawat</td>
							<td width="7%" style="border-top:1px solid; border-bottom:1px solid;">Kelas</td>
							<td width="6%" style="border-top:1px solid; border-bottom:1px solid;">Tgl MRS</td>
							<td width="6%" style="border-top:1px solid; border-bottom:1px solid;">Ruangan</td>
							<td width="7%" style="border-top:1px solid; border-bottom:1px solid;">Asal Ruangan</td>
						</tr>
						<?php
								$qK = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_kunjungan INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id WHERE $fUnit $fKso $waktu GROUP BY b_ms_kso.id ORDER BY b_ms_kso.nama";
								$rsK = mysql_query($qK);
								while($rwK = mysql_fetch_array($rsK))
								{
						?>
						<tr>
							<td colspan="15" style="font-weight:bold; text-decoration:underline; text-transform:uppercase; padding-left:20px;"><?php echo $rwK['nama'];?></td>
						</tr>
						<?php
								$sql = "SELECT
								b_pelayanan.kunjungan_id, 
								b_pelayanan.id AS pelayanan_id, 
								b_ms_pasien.no_rm, 
								b_ms_pasien.nama, 
								b_ms_pasien.alamat,
								(SELECT nama FROM b_ms_wilayah WHERE id=b_kunjungan.kec_id) kec, 
								b_kunjungan.umur_bln, 
								b_kunjungan.umur_thn, 
								b_ms_pasien.sex,
								b_ms_kelas.nama AS kelas, 
								DATE_FORMAT(b_tindakan_kamar.tgl_in,'%d-%m-%Y') AS mrs, 
								b_ms_unit.nama AS asal, 
								b_ms_kamar.nama AS ruang,
								mu.nama AS ruangan,
								if(b_kunjungan.isbaru='1','Baru','Lama') AS kunjungan 
								FROM b_kunjungan 
								INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id
								INNER JOIN b_ms_unit as mu ON mu.id = b_pelayanan.unit_id 
								INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id 
								INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_kunjungan.pasien_id 
								INNER JOIN b_ms_kelas ON b_ms_kelas.id = b_tindakan_kamar.kelas_id 
								INNER JOIN b_ms_unit ON b_ms_unit.id = b_tindakan_kamar.unit_id_asal 
								INNER JOIN b_ms_kamar ON b_ms_kamar.id = b_tindakan_kamar.kamar_id 
								WHERE $fUnit AND b_pelayanan.kso_id = '".$rwK['id']."' AND b_ms_unit.inap = '1' 
								AND b_tindakan_kamar.tgl_out IS NULL $waktu 
								GROUP BY b_pelayanan.id";
								$rs = mysql_query($sql);
								$no = 1;
								while($rw = mysql_fetch_array($rs))
								{
						?>
						<tr>
							<td style="text-align:center;" valign="top"><?php echo $no;?></td>
							<td style="text-align:center" valign="top"><?php echo $rw['no_rm'];?></td>
							<td style="padding-left:0px; text-transform:uppercase;" valign="top" align="center"><?php echo $rw['kunjungan'];?></td>
							<td style="padding-left:0px; text-transform:uppercase;" valign="top"><?php echo $rw['nama'];?></td>
							<td style="padding-left:0px; text-transform:uppercase;" valign="top"><?php echo $rw['alamat'];?></td>
							<td style="text-align:center" valign="top"><?php echo $rw['kec'];?></td>
							<td style="text-align:center" valign="top"><?php echo $rw['umur_thn'].' thn '.$rw['umur_bln'].' bln';?></td>
							<td style="text-align:center" valign="top"><?php echo $rw['sex'];?></td>
                            <?php
							/*
							$sql="SELECT IF(d.ms_diagnosa_id=0,d.diagnosa_manual,md.nama) diagnosa,
								IFNULL(mdrm.kode,'') icd10
								FROM b_diagnosa d LEFT JOIN b_ms_diagnosa md ON d.ms_diagnosa_id=md.id 
								LEFT JOIN b_diagnosa_rm drm ON d.diagnosa_id=drm.diagnosa_id
								LEFT JOIN b_ms_diagnosa mdrm ON drm.ms_diagnosa_id=mdrm.id
								WHERE d.pelayanan_id='".$rw["pelayanan_id"]."'";
							*/
							$sql="SELECT IF(d.ms_diagnosa_id=0,d.diagnosa_manual,md.nama) diagnosa1,
								IFNULL(drm.diagnosa_manual,b_ms_diagnosa2.nama) as diagnosa,
								IFNULL(mdrm.kode,'') icd10
								FROM b_diagnosa d 
								INNER JOIN b_pelayanan pl ON pl.id=d.pelayanan_id
								LEFT JOIN b_ms_diagnosa md ON d.ms_diagnosa_id=md.id 
								LEFT JOIN b_diagnosa_rm drm ON d.diagnosa_id=drm.diagnosa_id
								LEFT JOIN b_ms_diagnosa mdrm ON drm.ms_diagnosa_id=mdrm.id
								inner join b_diagnosa ON b_diagnosa.diagnosa_id = drm.diagnosa_id
								left join b_ms_diagnosa as b_ms_diagnosa2 ON b_ms_diagnosa2.id = b_diagnosa.ms_diagnosa_id
								WHERE d.kunjungan_id='".$rw["kunjungan_id"]."' AND d.akhir=0";
							$rs1=mysql_query($sql);
							$diagnosa="";
							while ($rw1=mysql_fetch_array($rs1)){
								$icd10="";
								if ($rw1["icd10"]!=""){
									$icd10="[".$rw1["icd10"]."] ";
								}
								$diagnosa .=$icd10.$rw1["diagnosa"]."<br>";
							}
							if ($diagnosa!="") $diagnosa=substr($diagnosa,0,strlen($diagnosa)-4);
							?>
						    <td style="text-align:left" valign="top"><?php echo $diagnosa;?></td>
                          <?php
							$sqlA="SELECT IF(d.ms_diagnosa_id=0,d.diagnosa_manual,md.nama) diagnosa1,
								IFNULL(drm.diagnosa_manual,b_ms_diagnosa2.nama) as diagnosa,
								IFNULL(mdrm.kode,'') icd10
								FROM b_diagnosa d 
								INNER JOIN b_pelayanan pl ON pl.id=d.pelayanan_id
								LEFT JOIN b_ms_diagnosa md ON d.ms_diagnosa_id=md.id 
								LEFT JOIN b_diagnosa_rm drm ON d.diagnosa_id=drm.diagnosa_id
								LEFT JOIN b_ms_diagnosa mdrm ON drm.ms_diagnosa_id=mdrm.id
								inner join b_diagnosa ON b_diagnosa.diagnosa_id = drm.diagnosa_id
								left join b_ms_diagnosa as b_ms_diagnosa2 ON b_ms_diagnosa2.id = b_diagnosa.ms_diagnosa_id
								WHERE d.kunjungan_id='".$rw["kunjungan_id"]."' AND d.akhir=1";
							$rsA=mysql_query($sqlA);
							$diagnosaAkhir="";
							while ($rwA=mysql_fetch_array($rsA)){
								$icd10="";
								if ($rw1["icd10"]!=""){
									$icd10="[".$rw1["icd10"]."] ";
								}
								$diagnosaA .=$icd10.$rw1["diagnosa"]."<br>";
							}
							if ($diagnosaA!="") $diagnosaA=substr($diagnosaA,0,strlen($diagnosaA)-4);
							?>
						    <td style="text-align:left" valign="top"><?php echo $diagnosaA;?></td>
						    <?php
							$sDok="select pg.nama 
							from b_pelayanan pl
							inner join b_tindakan t on t.pelayanan_id=pl.id
							inner join b_ms_pegawai pg on pg.id=t.user_id
							where pl.id='".$rw["pelayanan_id"]."'";
							$qDok=mysql_query($sDok);
							$rwDok=mysql_fetch_array($qDok);
							?>
                            <td style="text-align:left" valign="top"><?php echo $rwDok['nama']; ?></td>
							<td style="text-align:center" valign="top"><?php echo $rw['kelas'];?></td>
							<td style="text-align:center" valign="top"><?php echo $rw['mrs'];?></td>
						    <td style="padding-left:5px; text-transform:uppercase;" valign="top"><?php echo $rw['ruangan'];?></td>
							<td style="padding-left:5px; text-transform:uppercase;" valign="top"><?php echo $rw['ruang'];?></td>
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