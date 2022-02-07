<?
include "../inc/koneksi.php";

$sql="SELECT MAX(kodebarang)+1 AS maxkode FROM ms_barang where tipe=3"; //echo $sql;
$rs=mysql_query($sql);
$cmkode=1;
if ($rows=mysql_fetch_array($rs)){
	$cmkode=$rows["maxkode"];
}
$mkode=$cmkode;
for ($i=0;$i<(8-strlen($cmkode));$i++){
	$mkode="0".$mkode;
}
echo $mkode;

?>