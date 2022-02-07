<?php 
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="OBAT_NAMA";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

$unit_id=$_REQUEST['unit_id'];	

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}



$sql = "SELECT * FROM (SELECT 
  ao.OBAT_ID, ao.OBAT_KODE, ao.OBAT_NAMA, ak.ID, ak.NAMA, ap.QTY_STOK, ap.nilai 
FROM
  (SELECT 
    OBAT_ID, 
    KEPEMILIKAN_ID, 
    SUM(QTY_STOK) AS QTY_STOK, 
    IF(TIPE_TRANS = 4, 
	SUM(FLOOR(QTY_STOK * HARGA_BELI_SATUAN)), 
	SUM(FLOOR((QTY_STOK * HARGA_BELI_SATUAN - (DISKON * QTY_STOK * HARGA_BELI_SATUAN / 100)) /* 1.1*/))) AS nilai 
  FROM
    $dbapotek.a_penerimaan 
  WHERE UNIT_ID_TERIMA = '".$unit_id."' 
    AND STATUS = 1 
    AND QTY_STOK > 0 
  GROUP BY OBAT_ID, KEPEMILIKAN_ID) AS ap 
  INNER JOIN $dbapotek.a_obat ao 
    ON ap.OBAT_ID = ao.OBAT_ID 
  INNER JOIN $dbapotek.a_kepemilikan ak 
    ON ap.KEPEMILIKAN_ID = ak.ID 
  LEFT JOIN $dbapotek.a_kelas kls 
    ON ao.KLS_ID = kls.KLS_ID 
WHERE ao.OBAT_ISAKTIF = 1 
ORDER BY ao.OBAT_NAMA, ak.ID) AS tbl ".$filter." ORDER BY ".$sorting;
echo $sql."<br>";
$rs=mysql_query($sql);
$jmldata=mysql_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
$sql=$sql." limit $tpage,$perpage";
//echo $sql;

$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);


while ($rows=mysql_fetch_array($rs))
{	
	$i++;
	
	$cid=$rows['OBAT_ID'];
	$ckpid=$rows['ID'];
	$sql2="SELECT * FROM $dbapotek.a_min_max_stok WHERE obat_id=$cid AND kepemilikan_id=$ckpid AND unit_id=$unit_id";
	$rs1=mysql_query($sql2);
	$idminmax=0;
	$stokmin=0;
	$stokmax=0;
	if ($rows1=mysql_fetch_array($rs1)){
		$idminmax=$rows1["min_max_id"];
		$stokmin=$rows1["min_stok"];
		$stokmax=$rows1["max_stok"];
	}
	
	$dt.=$id.chr(3).number_format($i,0,",","").chr(3).$rows["OBAT_KODE"].chr(3).$rows["OBAT_NAMA"].chr(3).$rows["NAMA"].chr(3).number_format($rows["QTY_STOK"],0,',','.')."&nbsp;&nbsp;".chr(3).$stokmin.chr(3).$stokmax.chr(3).number_format($rows["nilai"],0,',','.').chr(6);
}


if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1);
	$dt=str_replace('"','\"',$dt);
}
mysql_free_result($rs);
mysql_close($konek);

header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
	header("Content-type: application/xhtml+xml");
}else{
	header("Content-type: text/xml");
}
echo $dt;

?>
