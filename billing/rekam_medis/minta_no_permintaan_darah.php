<?php
include("../koneksi/konek.php");
$bl=date('m');
$th=date('Y');
$q1="SELECT no_minta FROM $dbbank_darah.bd_permintaan_unit WHERE no_minta LIKE 'BD/MT/$th-$bl/%' ORDER BY no_minta DESC LIMIT 1";
$rs1=mysql_query($q1);
if ($rows1=mysql_fetch_array($rs1)){
	$no_minta=$rows1["0"];
	$ctmp=explode("/",$no_minta);
	$dtmp=$ctmp[3]+1;
	$ctmp=$dtmp;
	for ($i=0;$i<(5-strlen($dtmp));$i++) $ctmp="0".$ctmp;
	$no_pakai="BD/MT/$th-$bl/$ctmp";
}else{
	$no_pakai="BD/MT/$th-$bl/00001";
}

echo $no_pakai;
?>