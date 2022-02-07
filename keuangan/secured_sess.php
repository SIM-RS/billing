<?php
session_start();
// echo $_SESSION['user']."|";
if(!isset($_SESSION['user']) || $_SESSION['user'] == ''){
	header("location:http://".$_SERVER['HTTP_HOST'].$base_addr."/");
}
?>
