<?php
include '../sesi.php';
include("../koneksi/konek.php");
$no_ba = $_REQUEST['no_ba'];
$tgl_ba = date('Y-m-d',strtotime($_REQUEST['tgl_ba']));
$no_po = $_REQUEST['no_po'];

$q = "update as_po set no_ba='$no_ba',tgl_ba='$tgl_ba' where no_po='$no_po'";
mysql_query($q);
//echo $q;
?>