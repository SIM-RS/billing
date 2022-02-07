<?php
	include('../sesi.php');
	include("../koneksi/konek.php");
	$dbbilling = "billing";
	$dbapotek = "dbapotek";
	$dbpendidikan = "db_rspendidikan";
	$dbkeuangan = "keuangan";

	$iduser = $_SESSION['id'];
	$tglact=gmdate('d-m-Y H:i:s',mktime(date('H')+7));
	$tgl=gmdate('d-m-Y',mktime(date('H')+7));
	$th=explode("-",$tgl);
	
	$sUser = "select nama from k_ms_user ku where ku.id = {$iduser}";
	$qUser = mysql_query($sUser);
	$dUser = mysql_fetch_array($qUser);
	
	//====================================================================
	//Paging,Sorting dan Filter======
	$page=$_REQUEST["page"];
	$defaultsort="id";
	$sorting=$_REQUEST["sorting"];
	$filter=$_REQUEST["filter"];
	//===============================
	
	// Parameter Query
	$klaim_terima_id = $_REQUEST['klaim_terima_id'];
	$klaim_id = $_REQUEST['klaim_id'];
	$posting = $_REQUEST['posting'];
	$tipe = $_REQUEST['tipe'];
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title></title>
	<style type="text/css">
		body{
			font-family:Arial,Helvetica,sans-serif;
			font-size:11px;
		}
		#content{
			width:100%;
		}
		table{
			border-collapse:collapse;
			font-size:12px;
		}
		td, th{
			border:solid 1px #000;
			padding:5px;
		}
		.tebal{
			font-weight:bold;
		}
		.judul{
			font-size:15px;
		}
	</style>
</head>
<body>
<div id="content">
	<p class="tebal"><?php echo $namaRS; ?><br /><?php echo $alamatRS; ?><br />Telepon <?php echo $tlpRS; ?></p>
	<p align="center" class="tebal judul">
		LAPORAN IMPORT DATA PENERIMAAN KLAIM KSO<br />
		<!-- PERIODE TGL RETUR: <?php echo "{$tglAwal} s/d {$tglAkhir}"; ?> -->
	</p>
	<table id="isiTable">
		<tr>
			<th >No</th>
			<th width='70px'>Tanggal Kunjungan</th>
			<th width='70px'>Tanggal Pulang</th>
			<th width='60px'>NoRM</th>
			<th>Nama</th>
			<th>KSO</th>
			<th>Kunjungan Awal</th>
			<th width='80px'>Tarif Reguler</th>
			<th width='80px'>Biaya Pasien</th>
			<th width='80px'>Nilai Pengajuan</th>
			<th width='80px'>Nilai Penerimaan</th>
			<!--th width='50px'>Status Verifikasi</th-->
		</tr>
		<?php
			if ($filter!="") {
				$filter=explode("|",$filter);
				$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
			}

			if ($sorting=="") {
				$sorting=$defaultsort;
			}
			
			switch($tipe){
				case "1":
					$sql = "SELECT *
							FROM (SELECT ktd.id,
								  ktd.klaim_detail_id,
								  ifnull(pas.no_rm, ktd.norm) no_rm,
								  ifnull(pas.nama, ktd.namapasien) AS pasien,
								  kso.id AS kso_id, kso.nama AS kso, mu.nama AS unit,
								  DATE_FORMAT(IFNULL(kp.tglK, ktd.tglmsk), '%d-%m-%Y') AS tgl,
								  DATE_FORMAT(IFNULL(kp.tglP, ktd.tglklr), '%d-%m-%Y') AS tgl_p,
								  IFNULL(SUM(IFNULL(kp.biayaRS, ktd.tariffrs)),0) AS biayaRS,
								  IFNULL(SUM(kp.biayaPasien),0) AS biayaPasien,
								  IFNULL(SUM(IFNULL(kd.nilai_klaim, ktd.tarif)),0) AS nilai_klaim,
								  IFNULL(SUM(ktd.nilai_terima),0) AS nilai_terima, ktd.sep,
								  IFNULL(ktd.kunjungan_id,0) kunjungan_id,
								  IF(ktd.tstatus = 0, 'belum', 'sudah') verif
								FROM k_klaim_terima kt
								INNER JOIN k_klaim_terima_detail ktd
								   ON ktd.klaim_terima_id = kt.id
								LEFT JOIN k_klaim_detail kd
								   ON kd.id = ktd.klaim_detail_id
								LEFT JOIN k_piutang kp
								   ON kp.id = kd.fk_id
								LEFT JOIN $dbbilling.b_kunjungan k
								   ON k.id = IFNULL(kp.kunjungan_id, ktd.kunjungan_id)
								LEFT JOIN $dbbilling.b_ms_unit mu
								   ON mu.id = k.unit_id
								LEFT JOIN $dbbilling.b_ms_pasien pas
								   ON pas.id = k.pasien_id
								LEFT JOIN $dbbilling.b_ms_kso kso
								   ON kso.id = IFNULL(kp.kso_id, ktd.kso_id)
								WHERE ktd.klaim_terima_id = '$klaim_terima_id'
								  /* AND ktd.tstatus < 2 */
								  AND ktd.sep IS NOT NULL
								GROUP BY kp.kunjungan_id, kp.kso_id, ktd.norm, ktd.sep) t1
							WHERE 0 = 0 $filter
							ORDER BY verif DESC, $sorting";
					break;
				case '2':
					$sql = "SELECT *
							FROM (SELECT 
									  kkd.id,
									  IFNULL(pas.no_rm, kkd.norm) no_rm,
									  IFNULL(pas.nama, kkd.namapasien) AS pasien,
									  kso.id AS kso_id,
									  kso.nama AS kso,
									  mu.nama AS unit,
									  DATE_FORMAT(IFNULL(kp.tglK, kkd.tglmsk),'%d-%m-%Y') AS tgl,
									  DATE_FORMAT(IFNULL(kp.tglP, kkd.tglklr),'%d-%m-%Y') AS tgl_p,
									  IFNULL(SUM(IFNULL(kp.biayaRS, kkd.tariffrs)),0) AS biayaRS,
									  IFNULL(SUM(IFNULL(kp.biayaKSO, kkd.tarif)),0) AS nilai_klaim,
									  IFNULL(SUM(IFNULL(kp.biayaKSO_Klaim, kkd.totaltarif)),0) AS nilai_terima,
									  IFNULL(SUM(kp.biayaPasien),0) AS biayaPasien,
									  IFNULL(SUM(kp.bayarKSO),0) AS bayarKSO,
									  IFNULL(SUM(kp.bayarPasien),0) AS bayarPasien,
									  IFNULL(SUM(kp.piutangPasien),0) AS piutangPasien,
									  kkd.kunjungan_id, kkd.sep, IF(kkd.tstatus = 0, 'belum', 'sudah') verif
									FROM k_klaim_detail kkd
									LEFT JOIN k_piutang kp
									   ON kp.id = kkd.fk_id
									LEFT JOIN $dbbilling.b_kunjungan k
									   ON k.id = IFNULL(kp.kunjungan_id, kkd.kunjungan_id)
									LEFT JOIN $dbbilling.b_ms_unit mu
									   ON mu.id = k.unit_id
									LEFT JOIN $dbbilling.b_ms_pasien pas
									   ON pas.id = k.pasien_id
									LEFT JOIN $dbbilling.b_ms_kso kso
									   ON kso.id = IFNULL(kp.kso_id, kkd.kso_id)
									WHERE kkd.tstatus < 2
									  AND kkd.sep IS NOT NULL
									  AND kkd.klaim_id = '{$klaim_id}'
									GROUP BY kp.kunjungan_id, kp.kso_id, kkd.norm, kkd.sep) t1
							WHERE 0 = 0 {$filter}
							ORDER BY {$sorting}";
					break;
			}
			$query = mysql_query($sql);
			if(mysql_num_rows($query) > 0){
				$jml = array();
				$head = "";
				$i = 1;
				$no = 1;
				while($data = mysql_fetch_object($query)){
					if($head != $data->verif){
						if($no != 1){
							echo "<tr><td colspan='7' align='right'>Total</td>";
							foreach($jml as $val){
								echo "<td align='right'>".number_format($val,0,",",".")."</td>";
							}
							echo "<!--td></td--></tr>";
						}
						if($data->verif == "sudah"){
							$verif = "<font color='blue'>".ucwords($data->verif)." Verifikasi</font>";
						} else {
							$verif = "<font color='red'>".ucwords($data->verif)." Verifikasi</font>";
						}
						echo "<tr><td style='color:red;' colspan='11' class='tebal'>{$verif}</td></tr>";
						$jml = array();
						$i = 1;
					}
					echo "<tr>
						<td align='center'>".$i++."</td>
						<td align='center'>".$data->tgl."</td>
						<td align='center'>".$data->tgl_p."</td>
						<td align='center'>".$data->no_rm."</td>
						<td>".$data->pasien."</td>
						<td>".$data->kso."</td>
						<td>".$data->unit."</td>
						<td align='right'>".number_format($data->biayaRS,0,",",".")."</td>
						<td align='right'>".number_format($data->biayaPasien,0,",",".")."</td>
						<td align='right'>".number_format($data->nilai_klaim,0,",",".")."</td>
						<td align='right'>".number_format($data->nilai_terima,0,",",".")."</td>
						<!--td align='center'>".ucwords($data->verif)."</td-->
					</tr>";
					$jml['totbiayaRS'] = $jml['totbiayaRS']+$data->biayaRS;
					$jml['totbiayaPasien'] = $jml['totbiayaPasien']+$data->biayaPasien;
					$jml['totnilai_klaim'] = $jml['totnilai_klaim']+$data->nilai_klaim;
					$jml['totnilai_terima'] = $jml['totnilai_terima']+$data->nilai_terima;
					
					$no++;
					$head = $data->verif;
				}
				
				echo "<tr><td colspan='7' align='right'>Total</td>";
				foreach($jml as $val){
					echo "<td align='right'>".number_format($val,0,",",".")."</td>";
				}
				echo "<!--td></td--></tr>";
			} else {
				echo "<tr>
					<td colspan='11' align='center'>Maaf, Data Tidak Ditemukan!</td>
				</tr>";
			}
		?>
		<tr>
			<td colspan="8" style='border:0px;' ></td>
			<td colspan="3" style='border:0px;' align="right">
				Tgl Cetak, <?php echo $tglact; ?><br />
				Petugas Cetak<br />
				<br />
				<br />
				<br />
				(<?php echo $dUser['nama']; ?>)
			</td>
		</tr>
	</table>
</div>
</body>
</html>