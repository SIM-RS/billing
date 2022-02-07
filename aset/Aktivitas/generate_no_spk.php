<?php
include '../koneksi/konek.php'; 
$no_po = $_REQUEST['no_po'];
$tgl_po = tglSQL($_REQUEST['tgl_po']);
$no_spk = $_REQUEST['no_spk'];

$q = "select id from as_po where no_po='$no_po' and tgl_po='$tgl_po'";
$s = mysql_query($q);
while($d = mysql_fetch_array($s))
{
	$id = $d['id'];
	mysql_query("update as_po set no_spk='$no_spk' where id='$id'");
}
//echo $q;
?>
