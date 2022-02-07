<?php
include('../../koneksi/konek.php');

$id = $_POST['id'];
if($_POST['type'] == 'save'){
	$kunjungan_id = $_POST['kunjungan_id'];
	$pelayanan_id = $_POST['pelayanan_id'];
	$user_id = $_POST['user_id'];
	$tanggal_jam = tglSQL($_POST['tanggal_jam']);
	
	$diagnosis = $_POST['diagnosis']; 
	$icd = $_POST['icd'];
	$obat = $_POST['obat'];
	$riwayat = $_POST['riwayat']; 
	$prosedur = $_POST['prosedur'];
	$nama = $_POST['nama'];
	$id_resep = $_POST['id_resep'];
		
	if($id == ''){
		$sql = "insert into b_ms_resume_poli
			(kunjungan_id, 
				pelayanan_id,
				user_id,
				tanggal_jam, 
				diagnosis, 
				icd, 
				obat, 
				riwayat, 
				prosedur,
				nama,
				id_resep)
			values ({$kunjungan_id}, 
				{$pelayanan_id}, 
				{$user_id},
				'{$tanggal_jam}', 
				'{$diagnosis}', 
				'{$icd}', 
				'{$obat}', 
				'{$riwayat}', 
				'{$prosedur}',
				'{$nama}',
				$id_resep)";
		mysql_query($sql);
		mysql_insert_id();
	}else{
		echo $sql = "update b_ms_resume_poli
			set tanggal_jam = '{$tanggal_jam}',
				diagnosis = '{$diagnosis}', 
				icd = '{$icd}', 
				obat = '{$obat}', 
				riwayat = '{$riwayat}', 
				prosedur = '{$prosedur}',
				id_resep = '{$id_resep}',
				nama = '{$nama}'
			where id = {$id}";
		mysql_query($sql);
	}
}else if($_POST['type'] == 'delete'){
	$sql = "delete from b_ms_resume_poli where id = {$id}";
	mysql_query($sql);
}
?>