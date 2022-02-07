<?php 
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
	header("Content-type: application/xhtml+xml");
}else{
	header("Content-type: text/xml");
}

include("../sesi.php");
include("../koneksi/konek.php");
$idunit=$_REQUEST["idunit"];
$bln=$_REQUEST["bln"];
$ta=$_REQUEST["ta"];
$wkttgl=gmdate('Y-m-d',mktime(date('H')+7));
$sql="SELECT COUNT(*) AS jml FROM (SELECT DISTINCT DATE_FORMAT(am.tgl,'%d/%m/%Y') AS tgl1,am.no_bukti,am.status 
FROM a_minta_obat am 
WHERE am.tgl='$wkttgl' AND am.unit_id=$idunit) AS p1,
(SELECT t1.tgl1,t1.no_bukti,COUNT(t1.status) AS jml FROM (SELECT DISTINCT DATE_FORMAT(am.tgl,'%d/%m/%Y') AS tgl1,am.no_bukti,am.status 
FROM a_minta_obat am 
WHERE am.tgl='$wkttgl' AND am.unit_id=$idunit) AS t1 GROUP BY t1.tgl1,t1.no_bukti) AS p2
WHERE p1.tgl1=p2.tgl1 AND p1.no_bukti=p2.no_bukti AND p2.jml=1 AND p1.status=1";
//echo $sql."<br>";
$dt="2".chr(3);
$rs=mysqli_query($konek,$sql);
if ($rows=mysqli_fetch_array($rs)){
	if ($rows["jml"]>0) $dt .="Ada ".$rows["jml"]." Pengiriman Obat dr Unit Lain Yg Belum Diproses !";
}
mysqli_free_result($rs);
mysqli_close($konek);
echo $dt;
?>