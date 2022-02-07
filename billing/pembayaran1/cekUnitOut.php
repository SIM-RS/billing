<?
include '../koneksi/konek.php';
$kunj_id=$_REQUEST['idKunj'];

$querB="SELECT GROUP_CONCAT( DISTINCT REPLACE(b.nama, ',','.') SEPARATOR ', ') AS nama FROM b_pelayanan a INNER JOIN b_ms_unit b ON a.unit_id = b.id
WHERE kunjungan_id = '$kunj_id' AND a.checkout = 0;";
$data=mysql_fetch_array(mysql_query($querB));
echo $data['nama'];
?>