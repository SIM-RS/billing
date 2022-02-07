<?php
include("../koneksi/konek.php");
$bl=date('m');
$th=date('Y');

$q="SELECT no_return FROM b_return WHERE no_return LIKE 'B/RTRN/$th-$bl/%' ORDER BY no_return DESC LIMIT 1";
$rs1=mysql_query($q);
if ($rows1=mysql_fetch_array($rs1)){
	$return=$rows1["0"];
	$ctmp=explode("/",$return);
	$dtmp=$ctmp[3]+1;
	$ctmp=$dtmp;
	for ($i=0;$i<(5-strlen($dtmp));$i++){ 
		$ctmp="0".$ctmp;	
	}
	$no_return="B/RTRN/$th-$bl/$ctmp";
}
else{
	$no_return="B/RTRN/$th-$bl/00001";
}

echo "$no_return";
?>