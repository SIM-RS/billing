<?php
	session_start();
	echo ($_SESSION['iduser'])."|";
	if(empty($_SESSION['pegawai_id']) == true){
			echo "<script type='text/javascript'>
				alert('Maaf Username/Pasword Tidak Tepat!');
				window.location = 'index.php';
			</script>";
		}
	// header("location:portal.php");
?>