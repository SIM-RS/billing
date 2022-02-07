<?php
include("../sesi.php");
$userId = $_SESSION['id'];
include("../koneksi/konek.php");

$no_return = $_REQUEST['no_return'];
$tgl_return = tglSQL($_REQUEST['tgl_return']);
$bayar_tindakan_id = $_REQUEST['id_bt'];
$fdata = $_REQUEST['fdata'];


if($_REQUEST['retur']=='ya'){
	$temp = explode("|",$fdata);
	for($i=0;$i<count($temp)-1;$i++){
		$sql = "insert into $dbbilling.b_return (bayar_tindakan_id,no_return,tgl_return,user_act,tgl_act) values ('$temp[$i]','$no_return','$tgl_return','$userId',now())";
		$r=mysql_query($sql);	
	}
	
}
if($_REQUEST['retur']=='tidak'){
	$temp = explode("|",$fdata);
	for($i=0;$i<count($temp)-1;$i++){
		$hapus = "delete from $dbbilling.b_return where bayar_tindakan_id='".$temp[$i]."'";
		$h=mysql_query($hapus);
	}
}
?>