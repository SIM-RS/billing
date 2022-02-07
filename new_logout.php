<?php
	session_start();
	include("billing/koneksi/konek.php");
	if($_SESSION["iduser"] > 0){
		// [START] Hapus List Booking Penjualan Langsung dan List Booking Minta Obat
		$sDelBook = "DELETE
					FROM $dbapotek.a_booking_obat
					WHERE user_act = '".$_SESSION["iduser"]."'";
		$dDelBook = mysql_query($sDelBook);

		$sDelMBook = "DELETE
					FROM $dbapotek.a_booking_minta_obat
					WHERE user_act = '".$_SESSION["iduser"]."'";
		$dDelMBook = mysql_query($sDelMBook);
		// [END] Hapus List Booking Penjualan Langsung dan List Booking Minta Obat
	}
	session_destroy();
	header("location:index.php");
?>