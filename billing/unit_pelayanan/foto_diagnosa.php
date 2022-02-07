<?
include("../koneksi/konek.php");
$id = $_REQUEST['id'];

$sql="SELECT kdg_nama,kdg_gambar FROM b_ms_diagnosa_gambar WHERE kdg_id='$id'";
$my=mysql_query($sql);
$data=mysql_fetch_array($my);


header('Content-Type: image/jpeg');
echo $data[1];

?>
