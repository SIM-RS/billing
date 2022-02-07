<?php
include('../../koneksi/konek.php');

$id = $_POST['id'];
if($_POST['type'] == 'save'){
	$kunjungan_id = $_POST['kunjungan_id'];
	$pelayanan_id = $_POST['pelayanan_id'];
	$user_id = $_POST['user_id'];
	$tgl_jam2 = $_POST['tgl_jam'];
	$tj=explode(' ',$tgl_jam2);
	$tgl_jam=tglSQL($tj[0])." ".$tj[1].":00";
	
	$ku = $_POST['ku'];
	$suhu = $_POST['suhu'];
	$nadi = $_POST['nadi'];
	$pernafasan = $_POST['pernafasan'];
	$minum = $_POST['minum'];
	$infus = $_POST['infus'];
	$mt = $_POST['mt'];
	$bab = $_POST['bab'];
	$bak = $_POST['bak'];
	$keterangan = $_POST['keterangan'];
		
	if($id == ''){
		$sql = "insert into b_ms_pengawasan_khusus_bayi
			(kunjungan_id, 
				pelayanan_id,
				user_id,
				tgl_jam, 
				ku, 
				suhu, 
				nadi, 
				pernafasan, 
				minum,
				infus,
				mt,
				bab,
				bak,
				keterangan)
			values ({$kunjungan_id}, 
				{$pelayanan_id}, 
				{$user_id},
				'{$tgl_jam}', 
				'{$ku}', 
				'{$suhu}', 
				'{$nadi}',
				'{$pernafasan}', 
				'{$minum}',
				'{$infus}',
				'{$mt}',
				'{$bab}',
				'{$bak}',
				'{$keterangan}')";
		mysql_query($sql);
		mysql_insert_id();
	}else{
		$sql = "update b_ms_pengawasan_khusus_bayi
			set tgl_jam = '{$tgl_jam}',
				ku = '{$ku}', 
				suhu = '{$suhu}', 
				nadi = '{$nadi}', 
				pernafasan = '{$pernafasan}', 
				minum = '{$minum}',
				infus = '{$infus}',
				mt = '{$mt}',
				bab = '{$bab}',
				bak = '{$bak}',
				keterangan = '{$keterangan}'
			where id = {$id}";
		mysql_query($sql);
	}
}else if($_POST['type'] == 'delete'){
	$sql = "delete from b_ms_pengawasan_khusus_bayi where id = {$id}";
	mysql_query($sql);
}
?>