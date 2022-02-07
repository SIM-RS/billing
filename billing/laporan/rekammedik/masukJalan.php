<?php
session_start();
include("../../sesi.php");

if($_POST['isExcel']=='yes'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="masukJalan.xls"');
}

?>
<title>.: Data Pasien Masuk Rawat Jalan :.</title>
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " AND DATE(p.tgl) = '$tglAwal2' ";
		$waktuLama = " AND DATE(b_tindakan_kamar.tgl_in) < '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(p.tgl) = '$bln' and year(p.tgl) = '$thn' ";
		$waktuLama = " and month(b_tindakan_kamar.tgl_in) < '$bln' and year(b_tindakan_kamar.tgl_in) < '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and DATE(p.tgl) between '$tglAwal2' and '$tglAkhir2' ";
		$waktuLama = " and DATE(b_tindakan_kamar.tgl_in) between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$jnsLayanan = $_REQUEST['cmbJenisLayananM'];
	$tmpLayanan = $_REQUEST['cmbTempatLayananM'];
	$stsKunj = $_REQUEST['cmbKunj'];
	$stsPas = $_REQUEST['StatusPas'];
	
	if($stsPas!=0){
		$fKso = "AND k.kso_id = '".$stsPas."'";
		$fKso2 = "AND p.kso_id = '".$stsPas."'";
	}
	
	if($tmpLayanan==0){
		$fUnit = " p.jenis_kunjungan = ".$jnsLayanan." AND mu1.penunjang=0";
	}
	else{
		$fUnit = " p.unit_id = ".$tmpLayanan;
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
		<td height="70" valign="top" style="font-size:14px; font-weight:bold; text-align:center; text-transform:uppercase;">rekapitulasi data pasien masuk - <?php if($jnsLayanan=='1') echo "RAWAT JALAN"; else echo "RAWAT DARURAT"; ?><br>tempat layanan - <?php echo $txtUnit?><br><?php echo $Periode;?></td>
	</tr>
	<tr>
		<td height="30" style="font-weight:bold;">&nbsp;Status Kunjungan : <?php
		if($stsKunj=='0')
		{ 
			echo "LAMA"; 
		}else if($stsKunj=='1')
		{ 
			echo "BARU";
		} 
		else if($stsKunj=='2') 
		{ 
			echo "PINDAHAN";
		}
		else if($stsKunj=='')
		{
			echo "SEMUA";
		}?></td>
	</tr>
	<tr>
		<td>
					<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
						<tr style="font-weight:bold; text-align:center">
							<td height="30" width="4%" style="border-top:1px solid; border-bottom:1px solid;">No</td>
							<td width="90" style="border-top:1px solid; border-bottom:1px solid;">No RM</td>
							<td width="150" style="border-top:1px solid; border-bottom:1px solid;">Nama Pasien</td>
							<td style="border-top:1px solid; border-bottom:1px solid;">Alamat</td>
							<td width="120" style="border-top:1px solid; border-bottom:1px solid;">Kecamatan</td>
							<td width="110" style="border-top:1px solid; border-bottom:1px solid;">Umur</td>
							<td width="30" style="border-top:1px solid; border-bottom:1px solid;">L/P</td>
							<td width="80" style="border-top:1px solid; border-bottom:1px solid;">Tgl Kunj.</td>
							<td width="120" style="border-top:1px solid; border-bottom:1px solid;">Unit Pelayanan</td>
							<td width="200" style="border-top:1px solid; border-bottom:1px solid;">Diagnosa</td>
							<td width="150" style="border-top:1px solid; border-bottom:1px solid;">Dokter</td>
							<td width="150" style="border-top:1px solid; border-bottom:1px solid;">Asal Kunjungan</td>
							<td width="80" style="border-top:1px solid; border-bottom:1px solid;">Kunjungan</td>
						</tr>
                        <?php
						if($stsKunj=='0' || $stsKunj=='1'){
						$sql = "SELECT DISTINCT 
						  kso.id,
						  kso.nama 
						FROM
						  b_kunjungan k 
						  INNER JOIN b_pelayanan p 
							ON p.kunjungan_id = k.id 
						  INNER JOIN b_ms_kso kso 
							ON kso.id = k.kso_id
						  INNER JOIN b_ms_unit mu1 
							ON mu1.id = p.unit_id 
						WHERE 
						$fUnit
						$waktu
						$fKso
						AND k.isbaru=".$stsKunj."
						ORDER BY kso.nama";
						
						}
						else if($stsKunj=='2'){
						$sql = "SELECT DISTINCT 
						  kso.id,
						  kso.nama 
						FROM
						  b_pelayanan p 
						  INNER JOIN b_kunjungan k
							ON p.kunjungan_id = k.id   
						  INNER JOIN b_ms_kso kso
							ON kso.id = p.kso_id
						  INNER JOIN b_ms_unit mu1 
							ON mu1.id = p.unit_id 
						WHERE 
						$fUnit
						$waktu
						$fKso2 
						  AND p.unit_id_asal IN 
						  (SELECT 
							id 
						  FROM
							b_ms_unit u 
						  WHERE u.kategori = 2) 
						ORDER BY kso.nama";
						}
						else if($stsKunj==''){
						$sql = "SELECT DISTINCT 
						  kso.id,
						  kso.nama 
						FROM
						  b_kunjungan k 
						  INNER JOIN b_pelayanan p 
							ON p.kunjungan_id = k.id 
						  INNER JOIN b_ms_kso kso 
							ON kso.id = k.kso_id
						  INNER JOIN b_ms_unit mu1 
							ON mu1.id = p.unit_id 
						WHERE 
						$fUnit
						$waktu
						$fKso
						ORDER BY kso.nama";	
						}
						
						$qkso=mysql_query($sql);
						while($rwK=mysql_fetch_array($qkso)){
							$no=0;
						?>
						<tr>
							<td colspan="13" style="font-weight:bold; text-decoration:underline; text-transform:uppercase; padding-left:20px;"><?php echo $rwK['nama'];?></td>
						</tr>
                        <?php
						if($stsKunj=='0' || $stsKunj=='1'){
						$sql="SELECT DISTINCT 
						  ps.no_rm,
						  ps.nama,
						  ps.alamat,
						  (SELECT nama FROM b_ms_wilayah WHERE id=k.kec_id) kec,
						  ps.sex,
						  DATE_FORMAT(k.tgl,'%d-%m-%Y') tgl,
						  k.umur_thn,
						  k.umur_bln,
						  k.umur_hr,
						  mu.nama as asal_kunjungan,
						  p.id, mu1.nama unit,
						  if(k.isbaru='1','Baru','Lama') AS kunjungan 
						FROM
						  b_kunjungan k 
						  INNER JOIN b_pelayanan p 
							ON p.kunjungan_id = k.id 
						  INNER JOIN b_ms_pasien ps 
							ON ps.id = k.pasien_id 
						  INNER JOIN b_ms_unit mu 
							ON mu.id = p.unit_id_asal 
						  INNER JOIN b_ms_unit mu1 
							ON p.unit_id = mu1.id 
						WHERE 
						  $fUnit 
						  $waktu
						  AND k.kso_id = ".$rwK['id']."
						  AND k.isbaru=".$stsKunj."
						ORDER BY ps.no_rm";
						}
						else if($stsKunj=='2'){
						$sql="SELECT DISTINCT 
						  ps.no_rm,
						  ps.nama,
						  ps.alamat,
						  (SELECT nama FROM b_ms_wilayah WHERE id=k.kec_id) kec,
						  k.umur_thn,
						  k.umur_bln,
						  k.umur_hr,
						  ps.sex,
						  p.tgl,
						  mu.nama asal_kunjungan, 
						  p.id, mu1.nama unit,
						  if(k.isbaru='1','Baru','Lama') AS kunjungan 
						FROM
						  b_pelayanan p 
						  INNER JOIN b_kunjungan k 
							ON p.kunjungan_id = k.id 
						  INNER JOIN b_ms_pasien ps 
							ON ps.id = p.pasien_id 
						  INNER JOIN b_ms_unit mu 
							ON mu.id = p.unit_id_asal 
						  INNER JOIN b_ms_kso kso 
							ON kso.id = p.kso_id 
						  INNER JOIN b_ms_unit mu1 
							ON p.unit_id = mu1.id 
						WHERE 
						  $fUnit 
						  $waktu
						  AND p.kso_id = ".$rwK['id']." 
						  AND p.unit_id_asal IN 
						  (SELECT 
							id 
						  FROM
							b_ms_unit u 
						  WHERE u.kategori = 2)";
						}
						else if($stsKunj==''){
							$sql="SELECT DISTINCT 
						  ps.no_rm,
						  ps.nama,
						  ps.alamat,
						  (SELECT nama FROM b_ms_wilayah WHERE id=k.kec_id) kec,
						  ps.sex,
						  DATE_FORMAT(k.tgl,'%d-%m-%Y') tgl,
						  k.umur_thn,
						  k.umur_bln,
						  k.umur_hr,
						  mu.nama as asal_kunjungan,
						  p.id, mu1.nama unit,
						  if(k.isbaru='1','Baru','Lama') AS kunjungan 
						FROM
						  b_kunjungan k 
						  INNER JOIN b_pelayanan p 
							ON p.kunjungan_id = k.id 
						  INNER JOIN b_ms_pasien ps 
							ON ps.id = k.pasien_id 
						  INNER JOIN b_ms_unit mu 
							ON mu.id = p.unit_id_asal 
						  INNER JOIN b_ms_unit mu1 
							ON p.unit_id = mu1.id 
						WHERE 
						  $fUnit 
						  $waktu
						  AND k.kso_id = ".$rwK['id']."
						ORDER BY ps.no_rm";
						}
						//echo $sql." <br>";
						$kueri=mysql_query($sql);
						
						while($rw=mysql_fetch_array($kueri)){
							$no++;
							$dokter="";
							$sql="SELECT DISTINCT peg.nama AS dokter FROM b_tindakan t INNER JOIN b_ms_pegawai peg ON t.user_id=peg.id WHERE t.pelayanan_id='".$rw["id"]."' AND peg.spesialisasi_id>0";
							$rs1=mysql_query($sql);
							while ($rw1=mysql_fetch_array($rs1)){
								$dokter .=$rw1["dokter"]."<br>";
							}
							if ($dokter!="") $dokter=substr($dokter,0,strlen($dokter)-4);
							
							$sql="SELECT IF(d.ms_diagnosa_id=0,d.diagnosa_manual,md.nama) diagnosa,
IFNULL(mdrm.kode,'') icd10
FROM b_diagnosa d LEFT JOIN b_ms_diagnosa md ON d.ms_diagnosa_id=md.id 
LEFT JOIN b_diagnosa_rm drm ON d.diagnosa_id=drm.diagnosa_id
LEFT JOIN b_ms_diagnosa mdrm ON drm.ms_diagnosa_id=mdrm.id
WHERE d.pelayanan_id='".$rw["id"]."'
UNION
SELECT IF(drm.ms_diagnosa_id=0,drm.diagnosa_manual,mdrm.nama) diagnosa, IFNULL(mdrm.kode,'') icd10 
FROM b_diagnosa_rm drm LEFT JOIN b_diagnosa d ON drm.diagnosa_id = d.diagnosa_id
LEFT JOIN b_ms_diagnosa md ON d.ms_diagnosa_id=md.id 
LEFT JOIN b_ms_diagnosa mdrm ON drm.ms_diagnosa_id=mdrm.id
WHERE drm.pelayanan_id='".$rw["id"]."' AND drm.diagnosa_id = 0";
//echo $sql."<br>";
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
						<tr>
							<td style="text-align:center" valign="top"><?php echo $no;?></td>
							<td style="text-align:center" valign="top"><?php echo $rw['no_rm'];?></td>
							<td style="padding-left:5px; text-transform:uppercase;" valign="top"><?php echo $rw['nama'];?></td>
							<td style="padding-left:5px; text-transform:uppercase;" valign="top"><?php echo $rw['alamat'];?></td>
							<td style="text-align:center" valign="top"><?php echo $rw['kec'];?></td>
							<td style="text-align:center" valign="top"><?php echo $rw['umur_thn'].' thn '.$rw['umur_bln'].' bln '.$rw['umur_hr'].' hr';?></td>
							<td style="text-align:center" valign="top"><?php echo $rw['sex'];?></td>
							<td style="text-align:center" valign="top"><?php echo $rw['tgl'];?></td>
							<td style="text-align:center" valign="top"><?php echo $rw['unit'];?></td>
							<td style="text-align:left" valign="top"><?php echo $diagnosa;?></td>
							<td style="text-align:center" valign="top"><?php echo $dokter;?></td>
							<td align="center" style="padding-left:5px; text-transform:uppercase;" valign="top"><?php echo $rw['asal_kunjungan'];?></td>
							<td align="center" style="padding-left:5px; text-transform:uppercase;" valign="top"><?php echo $rw['kunjungan'];?></td>
						</tr>
                        <?php
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
		</td>
	</tr>
	<tr>
		<td style="border-top:1px solid #000; padding-top:5px; font-size:12px;" align="right">
			Printed By : <?php echo $rwPeg['nama']; ?>
		</td>
	</tr>
</table>