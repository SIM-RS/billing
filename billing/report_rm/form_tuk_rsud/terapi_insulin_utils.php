<?php
include('../../koneksi/konek.php');

$id = $_POST['id'];
if($_POST['type'] == 'save'){
	$kunjungan_id = $_POST['kunjungan_id'];
	$pelayanan_id = $_POST['pelayanan_id'];
	$user_id = $_POST['user_id'];
	$tanggal_jam2 = $_POST['tanggal_jam'];
	$tj=explode(' ',$tanggal_jam2);
	$tanggal_jam=tglSQL($tj[0])." ".$tj[1].":00";
	
	$jenis = $_POST['jenis'];
	$dosis = $_POST['dosis'];
	$gula = $_POST['gula'];
	$reduksi = $_POST['reduksi'];
	$ket = $_POST['ket'];
	$nama = $_POST['nama'];
		
	if($id == ''){
		$sql = "insert into b_ms_terapi_insulin
			(kunjungan_id, 
				pelayanan_id,
				user_id,
				tanggal_jam, 
				jenis, 
				dosis, 
				gula, 
				reduksi, 
				ket,
				nama)
			values ({$kunjungan_id}, 
				{$pelayanan_id}, 
				{$user_id},
				'{$tanggal_jam}', 
				'{$jenis}', 
				'{$dosis}', 
				'{$gula}',
				'{$reduksi}', 
				'{$ket}',
				'{$nama}')";
		mysql_query($sql);
		mysql_insert_id();
	}else{
		$sql = "update b_ms_terapi_insulin
			set tanggal_jam = '{$tanggal_jam}',
				jenis = '{$jenis}', 
				dosis = '{$dosis}', 
				gula = '{$gula}', 
				reduksi = '{$reduksi}', 
				ket = '{$ket}',
				nama = '{$nama}'
			where id = {$id}";
		mysql_query($sql);
	}
}else if($_POST['type'] == 'delete'){
	$sql = "delete from b_ms_terapi_insulin where id = {$id}";
	mysql_query($sql);
}
?>