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
$wkttgl=gmdate('Y-m-d',mktime(date('H')+7));
$sql="SELECT COUNT(*) AS jml FROM (SELECT t1.*,IFNULL(t2.QTY_STOK,0) AS QTY_STOK FROM (SELECT * FROM a_min_max_stok WHERE unit_id=$idunit) AS t1 LEFT JOIN
(SELECT OBAT_ID,KEPEMILIKAN_ID,SUM(QTY_STOK) AS QTY_STOK 
FROM a_penerimaan WHERE UNIT_ID_TERIMA=$idunit AND STATUS=1 AND QTY_STOK>0 
GROUP BY OBAT_ID,KEPEMILIKAN_ID) AS t2 ON (t1.obat_id=t2.OBAT_ID AND t1.kepemilikan_id=t2.KEPEMILIKAN_ID)) AS t3
WHERE t3.QTY_STOK<t3.min_stok";
//echo $sql."<br>";
$dt="2".chr(3);
$rs=mysqli_query($konek,$sql);
if ($rows=mysqli_fetch_array($rs)){
	if ($rows["jml"]>0) $dt .="Ada ".$rows["jml"]." Obat Yg Stoknya Kurang dari Stok Minimum !";
}
mysqli_free_result($rs);
mysqli_close($konek);
echo $dt;
?>