<?php
	session_start();
	$_SESSION["shift"] = $_REQUEST['shift'];
	header('location:apotek/main/main.php');
?>