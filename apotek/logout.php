<?php 
session_start();
include("koneksi/konek.php");

// [START] Hapus List Booking Penjualan Langsung dan List Booking Minta Obat
$sDelBook = "DELETE
			FROM a_booking_obat
			WHERE user_act = '".$_SESSION["iduser"]."'";
$dDelBook = mysqli_query($konek,$sDelBook);

$sDelMBook = "DELETE
			FROM a_booking_minta_obat
			WHERE user_act = '".$_SESSION["iduser"]."'";
$dDelMBook = mysqli_query($konek,$sDelMBook);
// [END] Hapus List Booking Penjualan Langsung dan List Booking Minta Obat

session_destroy();
header("location:../index.php");
?>