<body bgcolor="transparance">
<?
include("../koneksi/konek.php");
$id_pelayanan = $_REQUEST['id_pelayanan'];
$getIdPasien = $_REQUEST['getIdPasien'];
$in = $_REQUEST['in'];
$kh = $_REQUEST['kh'];
$kon1 = $_REQUEST['kon1'];
if($in=="true")
{
	$query12 = "update b_pelayanan set tgl_in = NOW() where id = $id_pelayanan and tgl_in IS NULL";
	mysql_query($query12);	
}elseif($in=="false"){
	$query12 = "update b_pelayanan set tgl_out = NOW() where id = $id_pelayanan";
	mysql_query($query12);
}elseif($kh=="true"){
	$query12 = "update b_ms_pasien set p_khusus = '$kon1' where id = $getIdPasien";
	mysql_query($query12);
}
?>
<!--<span style="color:#F00"></span>-->
</body>