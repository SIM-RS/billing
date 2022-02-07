<?php
include("../sesi.php");
include("../koneksi/konek.php");

$sql = "select * from a_sop where id='".$_REQUEST['id']."'";
$kueri = mysqli_query($konek,$sql);
$sop = mysqli_fetch_array($kueri);

echo $sop['isi'];
?>