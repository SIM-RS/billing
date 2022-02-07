<?php
include("../../koneksi/konek.php");
$id_pelayanan = $_REQUEST['id_pelayanan'];
$userId = $_REQUEST['userId'];
$isAcc = $_REQUEST['isAcc'];
$acc = $_REQUEST['acc'];

$queryubah = "UPDATE b_pelayanan SET accLab = $acc, user_acc = '$userId' WHERE id = $id_pelayanan";
//echo $queryubah."<br>";
$execQuery = mysql_query($queryubah);
$queryubah = "UPDATE b_hasil_lab SET verifikasi=$acc WHERE id_pelayanan=$id_pelayanan";
//echo $queryubah."<br>";
$execQuery = mysql_query($queryubah);
?>