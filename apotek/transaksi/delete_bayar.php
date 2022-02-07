<?php
include("../koneksi/konek.php");

$val = $_REQUEST['val'];
convert_var($val);

$sqlp="UPDATE a_penjualan p INNER JOIN a_kredit_utang aku ON (p.`NO_PENJUALAN`=aku.`FK_NO_PENJUALAN` AND p.UNIT_ID=aku.UNIT_ID) SET p.`SUDAH_BAYAR`=0 WHERE aku.NO_BAYAR='$val'";
//echo $sqlp;
$sp = mysqli_query($konek,$sqlp) or die (mysqli_error($konek));
if($sp)
{
	$q = "delete from a_kredit_utang where NO_BAYAR='$val'";
	$s = mysqli_query($konek,$q);
	//echo mysqli_error($konek);
}else{
	
}
if($s)
{
	echo "sukses";
}
else
{
	echo "gagal";
}
?>