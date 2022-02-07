<?php
include "../koneksi/konek.php";

$action = $_REQUEST['act'];

if($action == 'save') {
	$data = $_POST['informKonsen'];
	extract($data);
	$tindakan_alternatif = implode('*|*', $tindakan_alternatif);
	$saksi = implode('*|*', $saksi);

	if(!isset($id) || empty($id)) {
/*if($cek>=1){echo "<script language='text/javascript'>alert('Cukup');</script>";} else {*/
		$sql = "INSERT INTO lap_inform_konsen
				            (
				             nama,
				             umur,
				             jenis_kelamin,
				             alamat,
				             hubungan,
				             dokter_id,
				             tindakan,
				             status_persetujuan,
				             tindakan_alternatif,
				             saksi,
				             pelayanan_id,
				             kunjungan_id,
				             user_id)
				VALUES (
				        '{$nama}',
				        '{$umur}',
				        '{$jenis_kelamin}',
				        '{$alamat}',
				        '{$hubungan}',
				        '{$dokter_id}',
				        '{$tindakan}',
				        '{$status_persetujuan}',
				        '{$tindakan_alternatif}',
				        '{$saksi}',
				        '{$pelayanan_id}',
				        '{$kunjungan_id}',
				        '{$user_id}');";
//}
	} else {
		$sql = "UPDATE lap_inform_konsen
				SET 
				  nama = '{$nama}',
				  umur = '{$umur}',
				  jenis_kelamin = '{$jenis_kelamin}',
				  alamat = '{$alamat}',
				  hubungan = '{$hubungan}',
				  dokter_id = '{$dokter_id}',
				  tindakan = '{$tindakan}',
				  status_persetujuan = '{$status_persetujuan}',
				  tindakan_alternatif = '{$tindakan_alternatif}',
				  saksi = '{$saksi}'
				WHERE id = '{$id}'";
	}
	mysql_query($sql);
} elseif($action == 'grid') {
	$pelayananId = $_GET['idPel'];
	$kunjunganId = $_GET['idKunj'];
	$sql = "SELECT 
			  konsen.id, konsen.tindakan, konsen.nama, konsen.status_persetujuan
			FROM
			  lap_inform_konsen konsen 
			WHERE konsen.pelayanan_id = {$pelayananId} 
			  AND konsen.kunjungan_id = {$kunjunganId}
			order by konsen.id desc ";
	$query = mysql_query($sql);
	$i = 1;
	$totpage = 1;
	$dt=$totpage.chr(5);
	while($row = mysql_fetch_assoc($query)) {
		$dt .= $row['id'].chr(3).$i.chr(3).$row['tindakan'].chr(3).$row["nama"].chr(3).($row['status_persetujuan'] == 1 ? 'SETUJU' : 'MENOLAK').chr(6);
		$i++;
	}
	header("Cache-Control: no-cache, must-revalidate" );
	header("Pragma: no-cache" );
	if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
	    header("Content-type: application/xhtml+xml");
	}else {
	    header("Content-type: text/xml");
	}
	echo $dt;
} elseif ($action == 'get') {
	$id = $_GET['id'];
	$sql = "SELECT * FROM lap_inform_konsen konsen WHERE konsen.id = {$id}
			order by konsen.id desc";
	$query = mysql_query($sql);
	if($query && mysql_num_rows($query) > 0) {
		$data = mysql_fetch_assoc($query);
		list($alternatif1, $alternatif2, $alternatif3) = explode('*|*', $data['tindakan_alternatif']);
		$data['tindakan_alternatif_1'] = $alternatif1;
		$data['tindakan_alternatif_2'] = $alternatif2;
		$data['tindakan_alternatif_3'] = $alternatif3;
		list($saksi1, $saksi2) = explode('*|*', $data['saksi']);
		$data['saksi_1'] = $saksi1;
		$data['saksi_2'] = $saksi2;
		echo json_encode($data);
		exit();
	} else {
		die('false');
	}
} elseif ($action == 'delete') {
	$id = $_POST['id'];
	$sql = "DELETE
			FROM lap_inform_konsen
			WHERE id = '{$id}'";
	$query = mysql_query($sql);
}

?>