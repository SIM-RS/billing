<?php
include('../../koneksi/konek.php');

$id = $_POST['id'];
if($_POST['type'] == 'save'){
	$kunjungan_id = $_POST['kunjungan_id'];
	$pelayanan_id = $_POST['pelayanan_id'];
	$pasien_id = $_POST['pasien_id'];
	$user_id = $_POST['user_id'];
	$tanggal_jam2 = $_POST['tanggal_jam'];
	$tj=explode(' ',$tanggal_jam2);
	$tanggal_jam=tglSQL($tj[0])." ".$tj[1].":00";
	
	$bagian = $_POST['bagian'];
	$informasi = $_POST['informasi'];
	$petugas = $_POST['petugas'];
	$penerima = $_POST['penerima'];
	$hubungan_pasien = $_POST['hubungan_pasien'];
		
	if($id == ''){
		$sql = "insert into lap_pemberian_edukasi
			(kunjungan_id, 
				pelayanan_id,
				user_id,
				tanggal_jam, 
				bagian, 
				informasi, 
				petugas, 
				penerima, 
				hubungan_pasien)
			values ({$kunjungan_id}, 
				{$pelayanan_id}, 
				{$user_id},
				'{$tanggal_jam}', 
				'{$bagian}', 
				'{$informasi}', 
				'{$petugas}',
				'{$penerima}', 
				'{$hubungan_pasien}')";
		mysql_query($sql);
		mysql_insert_id();
	}else{
		$sql = "update lap_pemberian_edukasi
			set tanggal_jam = '{$tanggal_jam}',
				bagian = '{$bagian}',
				informasi = '{$informasi}',
				petugas = '{$petugas}',
				penerima = '{$penerima}',
				hubungan_pasien = '{$hubungan_pasien}'
			where id = {$id}";
		mysql_query($sql);
	}
}else if($_POST['type'] == 'delete'){
	$sql = "delete from lap_pemberian_edukasi where id = {$id}";
	mysql_query($sql);
}
?>