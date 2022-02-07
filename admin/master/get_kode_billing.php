<?php
include '../inc/koneksi.php';
$kode = $_REQUEST['kode'].".";
$q = "select billing_kode from ms_unit where billing_kode like '%$kode%' order by billing_kode desc limit 1";
$d = mysql_fetch_array(mysql_query($q));
$pch = explode(".",$d['billing_kode']);

$new_id = $pch[1]+1;
$new_kode = sprintf('%02d', $new_id);

echo $pch[0].".".$new_kode;

?>