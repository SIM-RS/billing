<?php
include("../koneksi/konek.php");
$pelayanan_id = $_REQUEST['pelayanan_id'];
$nolab=str_replace(".","",$_REQUEST['noLab']);
$nolab=str_replace(",","",$nolab);
$sqlLab = "SELECT * FROM b_pelayanan WHERE no_lab='".$nolab."' AND id<>'".$pelayanan_id."' AND tgl=CURDATE()";
//echo $sqlLab."<br>";
$rsLab = mysql_query($sqlLab);
if (mysql_num_rows($rsLab)>0){
	echo 'No Spesimen Sudah Ada !';
}else{
	$sqlLab = "UPDATE b_pelayanan SET no_lab='".$nolab."' where id='".$pelayanan_id."'";
	$rsLab = mysql_query($sqlLab);
	if(mysql_affected_rows()>0)
	{
		echo 'Update Berhasil';
	}
	else{
		echo 'Update Gagal';
	}
}
mysql_close($konek);
?>