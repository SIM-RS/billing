<?php
include '../../koneksi/konek.php';
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
if (stristr($_SERVER["HTTP_ACCEPT"], "application/xhtml+xml")) {
	header("Content-type: application/xhtml+xml");
} else {
	header("Content-type: text/xml");
}

$grd = $_REQUEST['grd'];

$sortDefault = "ORDER BY tindakan ASC";
$sorting = "";

if ($_REQUEST['sorting'] != '') {
	$sorting = "ORDER BY " . $_REQUEST['sorting'];
}

$filterSql = "";
$page = $_REQUEST["page"];
$filter = "";
if ($_REQUEST['filter'] != '') {
	$filter = explode('|', mysql_real_escape_string($_REQUEST['filter']));
	$filterSql = " WHERE {$filter[0]} LIKE '%{$filter[1]}%'";
	$filterSql2 = " AND {$filter[0]} LIKE '%{$filter[1]}%'";
}

$idDokter = mysql_real_escape_string($_REQUEST['dokterId']);
$idTindakanKelas = mysql_real_escape_string($_REQUEST['idTindakanKelas']);
$dataArr = explode(',', $idTindakanKelas);
$userId = $_REQUEST['user_id'];
$presentase = mysql_real_escape_string($_REQUEST['presentase']);
$nilai = mysql_real_escape_string($_REQUEST['nilai']);
$act = $_REQUEST['act'];
$id = $_REQUEST['id'];
$prosentase = mysql_real_escape_string($_REQUEST['prosentase']);
$nominal = mysql_real_escape_string($_REQUEST['nominal']);
$aktifGuarantee = mysql_real_escape_string($_REQUEST['aktif_guarantee']);
$id = mysql_real_escape_string($_REQUEST['id']);

//guarantee
$jumlahGuarantee = mysql_real_escape_string($_REQUEST['jumlahGuarantee']);
$nominalGuarantee = mysql_real_escape_string($_REQUEST['nominalGuarantee']);
$jenisGuarantee = mysql_real_escape_string($_REQUEST['jenisGuarantee']);
$nilaiGuarantee = mysql_real_escape_string($_REQUEST['nilaiGuarantee']);


switch ($act) {
	case "tambah":
		if ($presentase == 1) {
			for ($i = 0; $i < sizeof($dataArr) - 1; $i++) {
				$sql = "INSERT INTO b_ms_tarif_dokter ( id_dokter, id_tindakan_kelas, tarip_dokter_presentase, tanggal_act, user_id,jumlah_tindakan_guarantee,nominal_guarantee,nilai_guarantee,stat_guarantee)
						VALUES
							(
							{$idDokter},
							{$dataArr[$i]},
							{$nilai},
							now(),
							{$userId},
							{$jumlahGuarantee},
							{$nominalGuarantee},
							{$nilaiGuarantee},
							{$jenisGuarantee}
					)";
				echo $sql;
				mysql_query($sql);
			}
		} else {
			for ($i = 0; $i < sizeof($dataArr); $i++) {
				$sql = "INSERT INTO b_ms_tarif_dokter ( id_dokter, id_tindakan_kelas, tarip_dokter_nominal, tanggal_act, user_id,jumlah_tindakan_guarantee,nominal_guarantee,nilai_guarantee,stat_guarantee)
						VALUES
							(
							{$idDokter},
							{$dataArr[$i]},
							{$nilai},
							now(),
							{$userId},
							{$jumlahGuarantee},
							{$nominalGuarantee},
							{$nilaiGuarantee},
							{$jenisGuarantee}
					)";
				mysql_query($sql);
			}
		}
		break;
		case "update":
			if ($presentase == 1) {
				$sql = "UPDATE b_ms_tarif_dokter SET tarip_dokter_presentase = {$nilai},jumlah_tindakan_guarantee = {$jumlahGuarantee}, nominal_guarantee = {$nominalGuarantee}, nilai_guarantee = {$nilaiGuarantee},stat_guarantee = {$jenisGuarantee} WHERE id = {$id}";
			} else {
				$sql = "UPDATE b_ms_tarif_dokter SET tarip_dokter_nominal = {$nilai},jumlah_tindakan_guarantee = {$jumlahGuarantee}, nominal_guarantee = {$nominalGuarantee}, nilai_guarantee = {$nilaiGuarantee},stat_guarantee = {$jenisGuarantee} WHERE id = {$id}";
			}
			if(mysql_query($sql)){
				echo '<script>alert("berhasil")</scrip>';
			}else{
				echo '<script>alert("gagal")</scrip>';
			}
			break;
	case "deleteTindakanDokter":
		for ($i = 0; $i < sizeof($dataArr) - 1; $i++) {
			$sql = "DELETE FROM b_ms_tarif_dokter WHERE id = {$dataArr[$i]}";
			mysql_query($sql);
		}
		break;
	case "tambahGuarantee":
		$sql = "INSERT INTO b_ms_guarantee_fee(id_dokter,nominal,prosentase,tanggal_act,aktif_guarantee,user_id) VALUES({$idDokter},{$nominal},{$prosentase},now(),{$aktifGuarantee},{$userId})";
		mysql_query($sql);
		exit();
		break;
	case "updateGuarantee":
		$sql = "UPDATE b_ms_guarantee_fee SET nominal = {$nominal},prosentase = {$prosentase},aktif_guarantee = {$aktifGuarantee},tanggal_act = now(),user_id = {$userId} WHERE id = {$id} AND id_dokter = {$idDokter}";
		mysql_query($sql);
		exit();
		break;
	case "checkGuarantee":
		$sql = "SELECT * FROM b_ms_guarantee_fee WHERE id_dokter = {$idDokter}";
		$dataSql = mysql_query($sql);
		if (mysql_num_rows($dataSql) > 0) {
			$fetch = mysql_fetch_assoc($dataSql);
			$dataBalik = [
				'status' => 1,
				'id' => $fetch['id'],
				'nominal' => $fetch['nominal'],
				'prosentase' => $fetch['prosentase'],
				'aktif_guarantee' => $fetch['aktif_guarantee'],
			];
			echo json_encode($dataBalik);
		} else {
			$dataBalik = [
				'status' => 0,
			];
			echo json_encode($dataBalik);
		}
		exit();
		break;
	default:
		// code...
		break;
}

switch ($grd) {
	case "dokterData":
		$sql = "SELECT p.id,p.nama, r.nama as spesialis FROM b_ms_pegawai p LEFT JOIN b_ms_reference r ON r.id = p.spesialisasi_id WHERE p.pegawai_jenis = 8" . $filterSql2;
		echo $sql;
		break;
	case "dataTindakan":
		$sql = "SELECT
						* 
					FROM
						(
						SELECT
							tk1.kode AS kodetk,
							tk1.id,
							tk1.nama_penjamin,
							tk1.ms_tindakan_id,
							tk1.ms_kelas_id,
							t.nama AS tindakan,
							k.nama AS kelas,
							kt.nama AS kelompok,
							kl.nama AS klasifikasi,
							tk1.kode_tindakan,
							tk1.tarip 
						FROM
							(
							SELECT
								* 
							FROM
								(
								SELECT
									tk.*,
									p.nama AS nama_penjamin 
								FROM
									b_ms_tindakan_kelas tk
									LEFT JOIN b_ms_kso p ON p.id = tk.kso_id
								) AS t1
								WHERE id NOT IN (SELECT id_tindakan_kelas FROM b_ms_tarif_dokter WHERE id_dokter = {$idDokter})
							) tk1
							INNER JOIN b_ms_tindakan t ON tk1.ms_tindakan_id = t.id
							INNER JOIN b_ms_kelompok_tindakan kt ON t.kel_tindakan_id = kt.id
							INNER JOIN b_ms_klasifikasi kl ON t.klasifikasi_id = kl.id
							INNER JOIN b_ms_kelas k ON tk1.ms_kelas_id = k.id 
						) AS t2 " . $filterSql . " ORDER BY tindakan";
		break;
	case "dataTindakanDokter":
		$sql = "SELECT
					* 
				FROM
					(
					SELECT
						td.*,
						tk.ms_tindakan_id,
						tk.ms_kelas_id,
						t.nama AS tindakan,
						kt.nama AS kelompok,
						kl.nama AS klasifikasi,
						k.nama AS kelas,
						tk.tarip,
						tk.nama_penjamin 
					FROM
					  b_ms_tarif_dokter td
						INNER JOIN ( SELECT mtk.*, k.nama AS nama_penjamin FROM b_ms_tindakan_kelas mtk LEFT JOIN b_ms_kso k ON mtk.kso_id = k.id ) AS tk ON td.id_tindakan_kelas = tk.id
						INNER JOIN b_ms_tindakan t ON tk.ms_tindakan_id = t.id
						INNER JOIN b_ms_kelompok_tindakan kt ON t.kel_tindakan_id = kt.id
						INNER JOIN b_ms_klasifikasi kl ON t.klasifikasi_id = kl.id
						INNER JOIN b_ms_kelas k ON tk.ms_kelas_id = k.id 
					WHERE
					td.id_dokter = {$idDokter} 
					) AS t1 " . $filterSql;
		break;
}


//paginatiaon
$query = mysql_query($sql);
$jumlahData = mysql_num_rows($query);

if ($page == "" || $page == 0) $page = 1;

$totalPage = ($page - 1) * $perpage;

if ($jumlahData % $perpage > 0) $totalpage = floor($jumlahData / $perpage) + 1;
else $totalpage = floor($jumlahData / $perpage);

if ($page > 1) $bpage = $page - 1;
else $bpage = 1;
if ($page < $totalpage) $npage = $page + 1;
else $npage = $totalpage;

$sql = $sql . " LIMIT $totalPage,$perpage";
$query = mysql_query($sql);
$i = ($page - 1) * $perpage;

$data = $totalpage . chr(5);

switch ($grd) {
	case "dokterData":
		while ($rows = mysql_fetch_assoc($query)) {
			$i++;
			$valdata = $rows['id'] . '|' . $rows['nama'] . '|' . $rows['spesialis'];
			$button = '<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#setTarifDokterRs" value="' . $valdata . '" onclick="setIdDokter(this.value)" style="height:25px;font-size:10px;">View</button>';

			$data .= $rows['id'] . chr(3) . $i . chr(3) . $rows['nama'] . chr(3) . $rows['spesialis'] . chr(3) . $button . chr(6);
		}
		break;

	case "dataTindakan":
		while ($rows = mysql_fetch_array($query)) {
			$i++;
			$sisipan = $rows["id"] . "|" . $rows["ms_tindakan_id"] . "|" . $rows["kode_tindakan"];
			$data .= $sisipan . chr(3) . "0" . chr(3) . $rows["tindakan"] . chr(3) . $rows["nama_penjamin"] . chr(3) . $rows["kelas"] . chr(3) . number_format($rows["tarip"], 2, ',', '.') . chr(3) . $rows["kelompok"] . chr(3) . $rows["klasifikasi"] . chr(6);
		}
		break;
	case "dataTindakanDokter":
		while ($rows = mysql_fetch_array($query)) {
			$i++;
			$jenisPembagianPendapatan = 0;
			if($rows['tarip_dokter_nominal'] == NULL || $rows['tarip_dokter_nominal'] == ''){
				$jenisPembagianPendapatan = 1;
				$nilaiPembagianPendapatan = $rows['tarip_dokter_presentase'];
			}else{
				$jenisPembagianPendapatan = 2;
				$nilaiPembagianPendapatan = $rows['tarip_dokter_nominal'];
			}
			$sisipan = $rows['id'] . '|' . $nilaiPembagianPendapatan . '|' . $jenisPembagianPendapatan . '|' . $rows['jumlah_tindakan_guarantee'] . '|' . $rows['nominal_guarantee'] . '|' . $rows['nilai_guarantee'] . '|' . $rows['stat_guarantee'];
			$data .= $sisipan . chr(3) . "0" . chr(3) . $rows["tindakan"] . chr(3) . $rows["nama_penjamin"] . chr(3) . $rows["kelas"] . chr(3) . number_format($rows["tarip"], 2, ',', '.') . chr(3) . $rows["kelompok"] . chr(3) . $rows["klasifikasi"] . chr(6);
		}
		break;
	default:
		// code...
		break;
}

if ($data != $totalpage . chr(5)) {
	$data = substr($data, 0, strlen($data) - 1);
	// $data = str_replace('"','\"',$data);
}

echo $data;
