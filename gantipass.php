<?php
	session_start();
	if($_SESSION['logon'] != "1"){
		header("location:index.php");
	}
	include("billing/koneksi/konek.php");
	$old 		= $_REQUEST["old"];
	$new 		= $_REQUEST["new"];
	$pegawai_id = $_SESSION['pegawai_id'];
	$uname 		= $_SESSION['uname'];
	
	if($old != "" && $new != ""){
		$cek = "select * from b_ms_pegawai where id = '{$pegawai_id}' and pwd = password('{$old}')";
		$qcek = mysql_query($cek);
		if($qcek && mysql_num_rows($qcek) > 0 ){
			$sql = "update b_ms_pegawai set pwd = password('{$new}') where id=$pegawai_id";
			$query = mysql_query($sql);
			echo "<script type='text/javascript'>alert('Password Berhasil di Ganti!'); window.location='portal.php';</script>";
		} else {
			echo "<script type='text/javascript'>alert('Maaf Proses Ganti Password Tidak Dapat Dilakukan!'); window.location='portal.php';</script>";
		}
	}
?>