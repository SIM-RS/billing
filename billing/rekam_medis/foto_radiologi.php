<?
include("../koneksi/konek.php");
$id = $_REQUEST['id'];

$sql="SELECT nama_file,fcontent FROM b_hasil_rad WHERE id='$id'";
$my=mysql_query($sql);
$data=mysql_fetch_array($my);


header('Content-Type: image/jpeg');
echo $data[1];

?>
