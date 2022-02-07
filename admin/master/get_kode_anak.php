<?php
include '../inc/koneksi.php';

$x = $_REQUEST['kode'];
$kode = $_REQUEST['kode'].".";
$lvl = $_REQUEST['lvl'];

$q = "select kodeunit from ms_unit where kodeunit like '$kode%' and `level`='$lvl' order by kodeunit desc limit 1"; //echo $q;
$s = mysql_query($q);
$d = mysql_fetch_array($s);
$jum = mysql_num_rows($s);
if($jum!=0)
{
	if(isset($_REQUEST['kode_parent_awal']) && $_REQUEST['kode_parent_awal']==$x)
	{
		echo $_REQUEST['kode_unit_awal'];
	}
	else
	{
		$pch = explode(".",$d['kodeunit']);
		$total = count($pch);
		$new = $pch[$total-1]+1;
		$kode_baru = $kode.sprintf('%02d', $new); 
		echo $kode_baru;
	}
}
else
{
	$kode_baru = $kode.sprintf('%02d', 1); 
	echo $kode_baru;
}
?>
