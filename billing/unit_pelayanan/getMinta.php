<?php
include("../koneksi/konek.php");
$idunit=$_REQUEST['idunit'];
$th2=$_REQUEST['th2'];
$th1=$_REQUEST['th1'];
$bulan=$_REQUEST['bulan'];

$sqlb="SELECT * FROM $dbapotek.a_unit WHERE unit_billing = $idunit";
$rsqlb=mysql_query($sqlb);
$dsqlb=mysql_fetch_array($rsqlb);
$kodeunit=$dsqlb['UNIT_KODE'];
$idbaru=$dsqlb['UNIT_ID'];
//echo $idbaru;
//echo $kodeunit;
if($idbaru=="")
{
	//echo "masuk";
	$idbaru=0;
	$kodeunit=0;
}

$sql="SELECT * FROM (SELECT * FROM $dbapotek.a_minta_obat WHERE unit_id=$idbaru AND MONTH(tgl)=$bulan AND YEAR(tgl)=$th2 AND no_bukti LIKE '$kodeunit/UP/$th2-$th1/%') AS t1 ORDER BY no_bukti DESC LIMIT 1";
//echo $sql."<br>";
$rs1=mysql_query($sql);
if ($rows1=mysql_fetch_array($rs1)){
	$no_minta=$rows1["no_bukti"];
	$ctmp=explode("/",$no_minta);
	$dtmp=$ctmp[3]+1;
	$ctmp=$dtmp;
	for ($i=0;$i<(4-strlen($dtmp));$i++) $ctmp="0".$ctmp;
	$no_minta="$kodeunit/UP/$th2-$th1/$ctmp";
}else{
	$no_minta="$kodeunit/UP/$th2-$th1/0001";
}
//echo $no_minta;
?>
<script>
jQuery("#no_minta").val('<? echo $no_minta?>');
</script>