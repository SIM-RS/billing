<?php
include("../sesi.php");
include("../koneksi/konek.php");

$sql = "select * from a_sop where id='".$_REQUEST['id']."'";
$kueri = mysql_query($sql);
$sop = mysql_fetch_array($kueri);

echo $sop['isi'];
?>