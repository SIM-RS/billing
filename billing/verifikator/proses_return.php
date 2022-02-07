<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
$userId = $_SESSION['userId'];
include("../koneksi/konek.php");

$no_return = $_REQUEST['no_return'];
$bayar_tindakan_id = $_REQUEST['id_bt'];
$fdata = $_REQUEST['fdata'];


if($_REQUEST['retur']=='ya'){
	$temp = explode("|",$fdata);
	for($i=0;$i<count($temp)-1;$i++){
		$sql = "insert into b_return (bayar_tindakan_id,no_return,tgl_return,user_act,tgl_act,flag) values ('$temp[$i]','$no_return',now(),'$userId',now(),'$flag')";
		$r=mysql_query($sql);	
	}
	
}
if($_REQUEST['retur']=='tidak'){
	$temp = explode("|",$fdata);
	for($i=0;$i<count($temp)-1;$i++){
		$hapus = "delete from b_return where bayar_tindakan_id='".$temp[$i]."'";
		$h=mysql_query($hapus);
	}
}
?>