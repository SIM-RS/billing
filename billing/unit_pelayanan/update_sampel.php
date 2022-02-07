<body bgcolor="transparance">
<?
include("../koneksi/konek.php");
//include("../sesi.php");
error_reporting(0);
if(session_id() == '') {
    session_start();
}
$id_pelayanan = $_REQUEST['id_pelayanan'];
$tglPengambilan = tglSQL($_REQUEST['tglPengambilan']);
$jamPengambilan = $_REQUEST['jamPengambilan'];
$cpasien = $_REQUEST['cpasien'];
$clab = $_REQUEST['clab'];
$isAcc = $_REQUEST['isAcc'];
$acc = $_REQUEST['acc'];

//echo $_SESSION['userId']." tes";

if($isAcc == "true")
{
	$queryubah = "UPDATE b_pelayanan SET accLab = $acc, user_acc = '".$_SESSION['userId']."' WHERE id = $id_pelayanan";
	$execQuery = mysql_query($queryubah);
	$queryubah = "UPDATE b_hasil_lab SET verifikasi=$acc, verifikasi2=$acc WHERE id_pelayanan=$id_pelayanan";
	$execQuery = mysql_query($queryubah);
}else{
	$queryubah = "UPDATE b_pelayanan SET tgl_sampel = '$tglPengambilan', jam_sampel = '$jamPengambilan', cpasien = '$cpasien', clab = '$clab' WHERE		 id = $id_pelayanan";
	$execQuery = mysql_query($queryubah);

}
?>
<!--<span style="color:#F00"></span>-->
</body>