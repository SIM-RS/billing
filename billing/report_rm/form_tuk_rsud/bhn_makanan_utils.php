<?php
include('../../koneksi/konek.php');

$id = $_POST['id'];
if($_POST['type'] == 'save'){
	$kunjungan_id = $_POST['kunjungan_id'];
	$pelayanan_id = $_POST['pelayanan_id'];
	$user_id = $_POST['user_id'];
	
	$bahan = $_POST['bahan'];
	$ukuran = $_POST['ukuran'];
	$satuan = $_POST['satuan'];
	$ya = $_POST['ya'];
	$tidak = $_POST['tidak'];
		
	if($id == ''){
		$sql = "insert into b_ms_bhn_makan
			(kunjungan_id, 
				pelayanan_id,
				user_id,
				bahan, 
				ukuran, 
				satuan, 
				ya, 
				tidak)
			values ({$kunjungan_id}, 
				{$pelayanan_id}, 
				{$user_id}, 
				'{$bahan}', 
				'{$ukuran}', 
				'{$satuan}',
				'{$ya}', 
				'{$tidak}')";
		mysql_query($sql);
		mysql_insert_id();
	}else{
		$sql = "update b_ms_bhn_makan
			set tanggal_jam = '{$tanggal_jam}',
				bahan = '{$bahan}', 
				ukuran = '{$ukuran}', 
				satuan = '{$satuan}', 
				ya = '{$ya}', 
				tidak = '{$tidak}'
			where id = {$id}";
		mysql_query($sql);
	}
}else if($_POST['type'] == 'delete'){
	$sql = "delete from b_ms_bhn_makan where id = {$id}";
	mysql_query($sql);
}
?>