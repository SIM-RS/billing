<?
session_start();
include '../koneksi/konek.php';
$unit_id = $_REQUEST['tmp'];
$tgl1 = tglSQL($_REQUEST['tgl1']);
$tgl2 = tglSQL($_REQUEST['tgl2']);
$jmlB = $_REQUEST['jmlB'];
$user_id = $_SESSION['userId'];

echo $sql = "insert into b_lap_bor(id_unit,tgl1,tgl2,tgl_act,user_id,jml_bed)values($unit_id,'$tgl1','$tgl1',CURDATE(),$user_id,$jmlB)";
if(mysql_query($sql))
{
	echo "1";
}else{
	echo "2";
}
?>