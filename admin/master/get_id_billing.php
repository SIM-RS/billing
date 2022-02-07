<?php
include '../inc/koneksi.php';
$q = "select billing_id from ms_unit order by billing_id desc limit 1";
$d = mysql_fetch_array(mysql_query($q));
$new_id = $d['billing_id']+1;
echo $new_id;

?>