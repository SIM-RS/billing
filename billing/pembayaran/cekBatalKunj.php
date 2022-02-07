<?php
	session_start();
	include('../koneksi/konek.php');
	$idKunj = $_REQUEST['idKunj'];
	
	$sql = "SELECT CONCAT(COUNT(p.id), '*|*', SUM(p.batal)) batal
			FROM b_pelayanan p
			WHERE p.kunjungan_id = '{$idKunj}'";
	$query = mysql_query($sql);
	$data = mysql_fetch_array($query);
	
	echo $data['batal'];
?>