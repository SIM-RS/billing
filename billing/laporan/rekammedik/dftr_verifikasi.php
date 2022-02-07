<?php
	session_start();
	include("../../sesi.php");
	include("../../koneksi/konek.php");
	if($_REQUEST['isExcel']=='yes'){
		header("Content-type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="dftr_verifikasi.xls"');
	}
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	
	$waktu = $_REQUEST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " and b_pelayanan.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_REQUEST['cmbBln'];
		$thn = $_REQUEST['cmbThn'];
		$waktu = " and month(b_pelayanan.tgl) = '$bln' and year(b_pelayanan.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and b_pelayanan.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$sqlUnit1 = "SELECT id,nama,kode FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	
	$sqlKso = "SELECT id,nama from b_ms_kso where id = '".$_REQUEST['StatusPas']."'";
	$rsKso = mysql_query($sqlKso);
	$rwKso = mysql_fetch_array($rsKso);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Daftar Verifikasi Diagnosis PP</title>
	<style type="text/css">
		body{
			font-family:Arial, Helvetica, sans-serif; 
			font-size:11px
		}
		#container{
			width:100%;
		}
		#head{
			margin-top: 18px;
			margin-left: 10px;
		}
		#data{
			width:auto;
			border-collapse:collapse;
		}
		#data td{
			
			padding:5px;
		}	
		#data th{
			border-top:1px solid #000;
			border-bottom:1px solid #000;
			padding-top:10px;
			padding-bottom:10px;
		}
	</style>
</head>
<body>
<div id="container">
	<div id="head">
		<b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b>
	</div>
	<div id="isi">
		<table id="data">
			<caption>
				<h2 style="text-transform:uppercase; font-size:14px;">Daftar Verifikasi Diagnosis Pasien <?php if($rwKso['nama']=="") echo 'Semua'; else echo $rwKso['nama'] ?><br /><?php echo $Periode;?></h2>
				<br />
				<br />
				<br />
			</caption>
			<tr>
				<th width="40">TL</th>
				<th width="69">Tgl Kunjungan</th>
				<th width="54">No. RM</th>
				<th width="111">Nama Pasien</th>
				<th width="67">KSO</th>
				<th width="114">ICD X-Diagnosis</th>
				<th width="97">Dokter</th>
				<th width="58">Kasus</th>
                <th width="58">Prioritas</th>
				<th width="105">Diagnosa Akhir</th>
				<!--<th width="103">Tindakan</th>-->
				<th width="38">JK</th>
				<th width="121">Umur</th>
				<th width="98">Alamat</th>
				<th width="92">Kecamatan</th>
				<th width="69">Tgl Selesai</th>
			</tr>
			<?php
				$fKso = '';
				if($_REQUEST['StatusPas']!=0) {
					$fKso = " AND b_kunjungan.kso_id = ".$_REQUEST['StatusPas'];
				}
				if($_REQUEST['TmpLayanan']==0) {
					//$fTmp = " b_ms_unit.parent_id = '".$_REQUEST['JnsLayanan']."' ";
					if($_REQUEST['JnsLayanan']==1){
							$fTmp = " b_ms_unit.parent_id IN ('".$_REQUEST['JnsLayanan']."','44')";
						}else{
							$fTmp = " b_ms_unit.parent_id=".$_REQUEST['JnsLayanan'] ;
						}
				}else {
					$fTmp = " b_ms_unit.id = '".$_REQUEST['TmpLayanan']."' ";
				}
				
				$qU = "SELECT b_ms_unit.nama AS unit, b_kunjungan.unit_id, b_ms_unit.id
					FROM 
					b_kunjungan 
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
					WHERE b_pelayanan.batal=0 AND $fTmp $fKso $waktu 
					GROUP BY b_ms_unit.id";
				//echo $qU."<br>";
				$rsU = mysql_query($qU);
				while($rwU = mysql_fetch_array($rsU)){
			?>
				<tr>	
					<td colspan="14" style="text-transform:uppercase">&nbsp;<b><?php echo $rwU['unit'];?></b></td>
				</tr>
			<?php
					$qUnit = "SELECT 
								b_pelayanan.id AS pelayanan_id, 
								DATE_FORMAT(b_pelayanan.tgl,'%d-%m-%Y') AS tgl,
								DATE_FORMAT(b_pelayanan.tgl_keluar,'%d-%m-%Y') AS tgl_selesai, 
								b_ms_pasien.no_rm, 
								b_ms_pasien.nama, 
								b_ms_pasien.sex, 
								b_ms_pasien.alamat, 
								DATE_FORMAT(b_kunjungan.tgl_pulang,'%d-%m-%Y') AS tgl_pulang,
								b_kunjungan.umur_thn, 
								b_kunjungan.umur_bln, 
								b_kunjungan.umur_hr,
								desa.nama as nama_desa,
								kec.nama as nama_kec,
								kab.nama as nama_kab,
								kso.nama as namakso 
								FROM b_pelayanan 
								INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_pelayanan.pasien_id
								INNER JOIN b_kunjungan ON b_kunjungan.id = b_pelayanan.kunjungan_id
								INNER JOIN b_ms_wilayah desa ON desa.id=b_ms_pasien.desa_id
								INNER JOIN b_ms_wilayah kec ON kec.id=b_ms_pasien.kec_id
								INNER JOIN b_ms_wilayah kab ON kab.id=b_ms_pasien.kab_id
								INNER JOIN b_ms_kso kso ON kso.id=b_pelayanan.kso_id 
								WHERE b_pelayanan.batal=0 AND b_pelayanan.unit_id = '".$rwU['unit_id']."' $fKso $waktu 
								GROUP BY b_pelayanan.id";
					//echo $qUnit."<br>";
					$rsUnit = mysql_query($qUnit);
					$no = 1;
					while($rwUnit = mysql_fetch_array($rsUnit)){
			?>
			<tr valign="top" style="padding-left:5px;">
				<td style="text-align:right; padding-right:20px;"><?php echo $no++; ?></td>
				<td style="text-transform:uppercase" align="center"><?php echo $rwUnit['tgl'];?></td>
				<td style="text-transform:uppercase" align="center"><?php echo $rwUnit['no_rm'];?></td>
				<td style="text-transform:uppercase"><?php echo $rwUnit['nama'];?></td>
				<td style="text-transform:uppercase" align="center"><?php echo $rwUnit['namakso'];?></td>
				<?php
					$qDiag = "SELECT 
							b_ms_diagnosa.*,
							IF(b_diagnosa_rm.diagnosa_manual IS NULL,b_ms_diagnosa2.nama,IF(b_diagnosa_rm.diagnosa_id=0,b_ms_diagnosa.nama,b_diagnosa_rm.diagnosa_manual)) AS diagnosa,
							b_ms_pegawai.nama as dokter,
							if(b_diagnosa_rm.kasus_baru=1,'Baru',if(b_diagnosa_rm.kasus_baru=0,'Lama','-')) as kasus_baru,
							IF(b_diagnosa.primer = 1,'Diagnosa Utama','Diagnosa Sekunder') AS diagnosa_utama,
b_diagnosa_rm.akhir
							FROM b_diagnosa_rm 
							INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id
							left JOIN b_ms_pegawai ON b_diagnosa_rm.user_id = b_ms_pegawai.id
							left join b_diagnosa ON b_diagnosa.diagnosa_id = b_diagnosa_rm.diagnosa_id
							left join b_ms_diagnosa as b_ms_diagnosa2 ON b_ms_diagnosa2.id = b_diagnosa.ms_diagnosa_id 
							WHERE b_diagnosa_rm.pelayanan_id = '".$rwUnit['pelayanan_id']."' ORDER BY b_diagnosa_rm.primer DESC";
							//echo $qDiag."<br>";
					$rsDiag = mysql_query($qDiag);
					$nDiag=mysql_num_rows($rsDiag);
					$cek = 0;
					$kode = $dokter = $tipe = $kasus = $diag = array();
					if($nDiag>0){
						while($rwDiag = mysql_fetch_array($rsDiag)){
							$kode[]=$rwDiag['kode'];
							$dokter[]=$rwDiag['dokter'];
							$kasus[]=$rwDiag['kasus_baru'];
							$diag[]=$rwDiag['diagnosa'];
							$tipe[]=$rwDiag['diagnosa_utama'];
							/* if($cek == 0){
				?>
						<td style="text-transform:uppercase">qqqqq <?php echo $rwDiag['kode']?>&nbsp;&nbsp;&nbsp;<?php echo $rwDiag['diagnosa'];?></td>
						<td align="left" style="text-transform:uppercase"><?php echo $rwDiag['dokter']?></td>
						<td align="center" style="text-transform:uppercase"><?php echo $rwDiag['kasus_baru']; ?></td>
				<?php
							} else {
				?>
						<tr>
							<td style="text-align:right; padding-right:20px;">&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td style="text-transform:uppercase">wwwwwww <?php echo $rwDiag['kode']?>&nbsp;&nbsp;&nbsp;<?php echo $rwDiag['diagnosa'];?></td>
							<td align="left" style="text-transform:uppercase"><?php echo $rwDiag['dokter']?></td>
							<td align="center" style="text-transform:uppercase"><?php echo $rwDiag['kasus_baru']; ?></td>
						</tr>
				<?php
							}
							$cek++; */
						}
						$span = $nDiag;
					} else {
				?>
						<!--td></td>
						<td></td>
						<td></td-->
				<?php
						$span = 1;
					}
					
					if($span == 0){
						$span = 1;
					}
					$jmlD = count($kasus);
				?>
					<td style="text-transform:uppercase"><?php echo $kode[0]?>&nbsp;&nbsp;&nbsp;<?php echo $diag[0];?></td>
					<td align="left" style="text-transform:uppercase"><?php echo $dokter[0]; ?></td>
					<td align="center" style="text-transform:uppercase"><?php echo $kasus[0]; ?></td>
                    <td align="center" style="text-transform:uppercase"><?php echo $tipe[0]; ?></td>
				<?
					$qDiagAkhir = "SELECT GROUP_CONCAT(CONCAT(b_ms_diagnosa.kode,' ',IFNULL(b_diagnosa_rm.diagnosa_manual,b_ms_diagnosa2.nama))) as diagnosa
								FROM b_diagnosa_rm 
								INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id
								INNER JOIN b_ms_pegawai ON b_diagnosa_rm.user_id = b_ms_pegawai.id
								inner join b_diagnosa ON b_diagnosa.diagnosa_id = b_diagnosa_rm.diagnosa_id
								left join b_ms_diagnosa as b_ms_diagnosa2 ON b_ms_diagnosa2.id = b_diagnosa.ms_diagnosa_id 
								WHERE 
								b_diagnosa_rm.pelayanan_id = '".$rwUnit['pelayanan_id']."' 
								AND b_diagnosa_rm.akhir=1
								GROUP BY b_diagnosa_rm.pelayanan_id";
					$rsDiagAkhir = mysql_query($qDiagAkhir);
					$rwDiagAkhir = mysql_fetch_array($rsDiagAkhir);
				?>
				<td align="left" rowspan="<?php echo $span ?>" style="text-transform:uppercase"><?php echo $rwDiagAkhir['diagnosa'];?></td>
				<?php
					$sTind="select CONCAT('-&nbsp;',GROUP_CONCAT(distinct mt.nama SEPARATOR '<br>-&nbsp;')) as tindakan
							from b_ms_tindakan mt
							inner join b_ms_tindakan_kelas mtk ON mt.id=mtk.ms_tindakan_id
							inner join b_tindakan t ON t.ms_tindakan_kelas_id=mtk.id
							where t.pelayanan_id='".$rwUnit['pelayanan_id']."' GROUP BY t.pelayanan_id";
					$qTind=mysql_query($sTind);
					$rwTind=mysql_fetch_array($qTind);
				?>
				<!--<td align="left" rowspan="<?php echo $span ?>" style="text-transform:uppercase"><?php echo $rwTind['tindakan']; ?></td>-->
				<td align="center" rowspan="<?php echo $span ?>" style="text-transform:uppercase"><?php echo $rwUnit['sex'];?></td>
				<td align="center" rowspan="<?php echo $span ?>" style="text-transform:uppercase"><?php echo $rwUnit['umur_thn']." Th ".$rwUnit['umur_bln']." Bln ".$rwUnit['umur_hr']." hr";?></td>
				<td style="text-transform:uppercase" rowspan="<?php echo $span ?>"><?php echo $rwUnit['alamat'];?></td>
				<td style="text-transform:uppercase" rowspan="<?php echo $span ?>"><?php echo $rwUnit['nama_kec'];?></td>
				<td align="center" style="text-transform:uppercase" rowspan="<?php echo $span ?>"><?php echo $rwUnit['tgl_selesai'];?></td>
			</tr>
			<?php
				
				if($jmlD > 0){
					for($baris = 1; $baris <= ($jmlD-1); $baris++){
			?>
				<tr>
					<td style="text-align:right; padding-right:20px;">&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td style="text-transform:uppercase">&nbsp;</td>
					<td style="text-transform:uppercase"><?php echo $kode[$baris]?>&nbsp;&nbsp;&nbsp;<?php echo $diag[$baris];?></td>
					<td align="left" style="text-transform:uppercase"><?php echo $dokter[$baris]?></td>
					<td align="center" style="text-transform:uppercase"><?php echo $kasus[$baris]; ?></td>
                    <td align="center" style="text-transform:uppercase"><?php echo $tipe[$baris]; ?></td>
				</tr>
			<?
					}
				}
					}
				}
			?>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
	</div>
</div>

</body>
</html>