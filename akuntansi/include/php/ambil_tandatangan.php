<?php
session_start();
include 'koneksi.php';
$data['PHOTO']='';
$id      = $_GET['id'];
$query   = "SELECT image, image_type FROM dbkopega_hcr.pegawai_tandatangan WHERE pegawai_id = $id";
$hasil   = mysql_query($query);
$data    = mysql_fetch_array($hasil);
header("Content-type: ".$data['image_type']);
echo $data['image'];
?>