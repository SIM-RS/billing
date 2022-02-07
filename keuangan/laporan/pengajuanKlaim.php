<?php
	include('../sesi.php');
	$excell = $_REQUEST['excell'];
	if ($excell=="1"){
		header("Content-type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="Lap Pengajuan Klaim.xls"');		
	}
	
	include("../koneksi/konek.php");
	$tgl = gmdate('d-m-Y',mktime(date('H')+7));
    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'Nopember','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
	//echo $_REQUEST['tglAwal2']."<br>";
	$cwaktu=$waktu;
	
    if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$tglAkhir2 = $tglAwal2;
		$waktu = "AND k.tgl = '$tglAwal2' ";
		
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
		$cbln = ($bln<10)?"0".$bln:$bln;
		$waktu = "AND month(k.tgl) = '$bln' AND year(k.tgl) = '$thn' ";
		
        $Periode = "Bulan $arrBln[$cbln] Tahun $thn";
		$tglAkhir2="$thn-$cbln-".cal_days_in_month(CAL_GREGORIAN, $bln, $thn);
		$tglAwal2="$thn-$cbln-01";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $_REQUEST['tglAkhir'];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = "AND k.tgl between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
	
	$jReport = $_REQUEST['cmbJReport'];
	if($jReport == 0){
		$dReport = "Rekap";
		$width = "700px";
	} else {
		$width = "1280px";
		$dReport = "Detail";
	}
	$dklaim = explode('|',$_REQUEST['cmbKlaim']);
	$klaim_id = $dklaim[0];
	$klaim_tgl = $dklaim[1];
	$klaim_no = $dklaim[2];
	$klaim_nilai = $dklaim[3];
	
	$kso = $_REQUEST['cmbKsoRep'];
	$qKso = "";
	if($kso == 0){
		$fkso = "SEMUA";
		$nKso = $wkso = "";
	} else {
		$wkso = " AND k.kso_id = '{$kso}'";
		$qKso = "SELECT $dbbilling.b_ms_kso.id, $dbbilling.b_ms_kso.nama FROM $dbbilling.b_ms_kso
			WHERE $dbbilling.b_ms_kso.id = '".$kso."'";
		$sKso = mysql_query($qKso);
		$dKso = mysql_fetch_array($sKso);
		$nKso = "PEMJAMIN : ".$dKso['nama']."<br />";
	}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title><?php echo $dReport; ?> Pengajuan Klaim</title>
	<style type="text/css">
		body{
			margin:0px;
			padding:0px;
			font-family:Arial;
			font-size:12px;
			line-height:1.3em;
		}
		#container{
			width:<?php echo $width;?>;
			margin:10px auto;
			padding:0px;
			display:block;
		}
		#title{
			width:100%;
			display:block;
			margin-bottom:3px;
			text-align:left;
			font-weight:bold;
			font-size:14px;
		}
		.isian{
			border-collapse: collapse;
		}
		.isian td, .isian th{
			padding:5px;
			border:1px solid #000;
		}
		.isian th{
			background:#E1E1E1;
		}
		.isian .noborder{
			border:0px;
		}
		#des{
			font-size:12px;
		}
	</style>
</head>
<body>
	<center>
		<span id="cetakID" style="float:left; position:fixed; width:100%; display:block; left:0px; bottom:0px; background:#0084FF; padding:5px;"><button id="btCetak" type="button" name="btCetak" onClick="cetak()">Cetak <?php echo $dReport; ?> Pengajuan Klaim</button></span>
	</center>
	<div id="container">	
		<section style="margin-bottom:20px;">
			<b><?=$pemkabRS;?><br><?=$namaRS;?><br><?=$alamatRS;?><br>Telepon <?=$tlpRS;?></b>
		</section>
		<header id="title">
			<center style="text-transform:uppercase; line-height:1.25em;">
				<?php echo $dReport; ?> Pengajuan Klaim<br />
				<?php echo $nKso; ?>
				<?php echo $Periode; ?><br />
				<br />
			</center>
			<span id="des">
			<?php if($jReport != 0){ ?>
				<table id="isian">
					<tr>
						<td class="noborder">No Pengajuan</td>
						<td class="noborder">:</td>
						<td class="noborder"><?php echo $klaim_no; ?></td>
					</tr>
					<tr>
						<td class="noborder">Tgl Pengajuan</td>
						<td class="noborder">:</td>
						<td class="noborder"><?php echo tglSQL($klaim_tgl); ?></td>
					</tr>
				</table>
			<?php } ?>
			</span>
		</header>
		<section id="detail">
			<?php
				switch($jReport){
					case '0':
						$kolom = array('No|30','Tanggal|80','No Bukti|80','KSO|120','Nilai|100','Status|100');
						$sql = "SELECT 
								  k.id, k.tgl, DATE_FORMAT(k.tgl, '%d-%m-%Y') AS tgl_klaim, k.no_bukti, k.kso_id,
								  kso.nama, k.nilai, k.verifikasi 
								FROM
								  k_klaim k 
								  INNER JOIN $dbbilling.b_ms_kso kso 
									ON k.kso_id = kso.id 
								WHERE 0=0 {$waktu} {$wkso} AND k.flag = '$flag'";
						//echo $sql;
						$query = mysql_query($sql);
						$hasil = array();
						while($data = mysql_fetch_array($query)){
							switch ($data["verifikasi"]){
								case 0:
									$tstatus="Proses Pengajuan";
									break;
								case 1:
									$tstatus="Pengajuan ke KSO";
									break;
								case 2:
									$tstatus="Sudah Dibayar";
									break;
							}
							$hasil[] = array(
											$data['tgl_klaim'] => 'center',
											$data['no_bukti'] => 'center',
											$data['nama'] => 'center',
											number_format($data['nilai'],0,",",".") => 'right',
											$tstatus => 'center'
										);
							
							//$data['tgl_klaim']."|".$data['no_bukti']."|".$data['nama']."|".number_format($data["nilai"],0,",",".")."|".$tstatus;
						}
						break;
					case '1':
						//$klaim_id = "14";
						$kolom = array('No|20','Tanggal Kunjungan|60','Tanggal Pulang|60','No RM|60','Nama|120','KSO|100','Kunjungan Awal|100','TARIF RS|60','Biaya Pasien|60','Biaya KSO<br/>(SIMRS)|60','Biaya KSO<br/>(Verif Klaim)|60');
						
						$sql = "SELECT
								  k.id, pas.no_rm, pas.nama AS pasien, kso.id AS kso_id, kso.nama AS kso, mu.nama AS unit,
								  DATE_FORMAT(kp.tglK,'%d-%m-%Y') AS tgl, DATE_FORMAT(kp.tglP,'%d-%m-%Y') AS tgl_p,
								  IFNULL(SUM(kp.biayaRS),0) AS biayaRS, IFNULL(SUM(kp.biayaKSO),0) AS biayaKSO,
								  IFNULL(SUM(kp.biayaKSO_Klaim),0) AS biayaKSO_Klaim, IFNULL(SUM(kp.biayaPasien),0) AS biayaPasien,
								  IFNULL(SUM(kp.bayarKSO),0) AS bayarKSO, IFNULL(SUM(kp.bayarPasien),0) AS bayarPasien,
								  IFNULL(SUM(kp.piutangPasien),0) AS piutangPasien
								FROM k_klaim_detail kkd
								  INNER JOIN k_piutang kp ON kkd.fk_id = kp.id
								  INNER JOIN $dbbilling.b_kunjungan ku ON kp.kunjungan_id = ku.id
								  INNER JOIN $dbbilling.b_ms_unit mu ON ku.unit_id = mu.id
								  INNER JOIN $dbbilling.b_ms_pasien pas ON ku.pasien_id = pas.id
								  INNER JOIN $dbbilling.b_ms_kso kso ON kp.kso_id = kso.id
								  INNER JOIN k_klaim k ON k.id = kkd.klaim_id
								WHERE kp.status=2 AND kkd.klaim_id='{$klaim_id}'
									{$wkso} {$waktu} AND kkd.flag = '$flag'
								GROUP BY kp.kunjungan_id,kp.kso_id
								ORDER BY k.tgl DESC";
						//echo $sql;
						$query = mysql_query($sql);
						$hasil = array();
						while($data = mysql_fetch_array($query)){
							$tPerda=number_format($data["biayaRS"],0,",",".");
							$tKSO=number_format($data["biayaKSO"],0,",",".");
							$nilai=number_format($data["biayaKSO_Klaim"],0,",",".");
							$tPx=number_format($data["biayaPasien"],0,",",".");
							$tBayarPx=$data["bayarPasien"];
							$tPiutangPx=$tPx-$tBayarPx;
							
							$hasil[] = array(
											$data["tgl"] => "center",
											$data["tgl_p"] => "center",
											$data["no_rm"] => "center",
											$data["pasien"] => "left",
											$data["kso"] => "left",
											$data["unit"] => "left",
											$tPerda."|1" => "right",
											$tPx."|2" => "right",
											$tKSO."|3" => "right",
											$nilai."|4" => "right"
										);
										
							//$data["tgl"]."|".$data["tgl_p"]."|".$data["no_rm"]."|".$data["pasien"]."|".$kso."|".$tmpLay."|". number_format($tPerda,0,",",".")."|".number_format($tPx,0,",",".")."|".number_format($tKSO,0,",",".")."|". number_format($nilai,0,",",".");
							$tmpLay = '';
						}
						break;
				}
				//print_r($hasil);
			?>
			<table class="isian" width="100%">
				<tr>
					<?php 
						foreach($kolom as $val){
							$judulK = explode('|',$val);
							echo "<th width='".$judulK[1]."'>".$judulK[0]."</th>";
						}
					?>
				</tr>
			<?php
				$no = 1;
				foreach($hasil as $row){
			?>
				<tr>
					<?php 
						echo "<td align='center' >".$no++."</td>";
						foreach($row as $key => $align){
							$data = explode('|',$key);
							echo "<td align='".$align."' >".$data[0]."</td>";
						}
					?>
				</tr>
			<?php } ?>
				<tr>
					<td colspan="<?php echo count($kolom);?>" class="noborder" align="right">
						Tanggal Cetak<br /><?php echo $tgl; ?><br />
						<br />
						<br />
						<br />
						<br />
						(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
					</td>
				</tr>
			</table>
		</section>
	</div>
</body>
</html>