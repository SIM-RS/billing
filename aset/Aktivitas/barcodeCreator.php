<?php
include '../sesi.php';
include"barcode/barcodeClass.php";
$txt=$_GET['txt'];
$bc = new barCode();
$bc->build($txt,true); 
?>