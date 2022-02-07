<?php
include('../koneksi/konek.php');
$ta = $_REQUEST['th'];
$bln = $_REQUEST['bln'];
$idunit = $_REQUEST['unitId'];
$kodeunit = 'RTR';

$sunit = "select UNIT_ID,UNIT_KODE from $dbapotek.a_unit u where u.unit_billing = $idunit";
$qunit = mysql_query($sunit);
$jml = mysql_num_rows($qunit);
if($jml>0){
	$unitId = mysql_fetch_array($qunit);
	if($unitId['UNIT_ID'] != 0){
		$idunit = $unitId['UNIT_ID'];
	}
	$kodeunit = $unitId['UNIT_KODE'];
}

$sql="select * from $dbapotek.a_retur_togudang WHERE UNIT_ID=$idunit AND MONTH(TGL_RETUR)=$bln AND YEAR(TGL_RETUR)=$ta order by NO_RETUR desc limit 1";
//echo $sql;
$rs=mysql_query($sql);
$noretur="$kodeunit/RTR/$ta-$bln/0001";
if ($rows=mysql_fetch_array($rs)){
	$noretur=$rows["NO_RETUR"];
	$ctmp=explode("/",$noretur);
	$dtmp=$ctmp[3]+1;
	$ctmp=$dtmp;
	for ($i=0;$i<(4-strlen($dtmp));$i++) $ctmp="0".$ctmp;
	$noretur="$kodeunit/RTR/$ta-$bln/$ctmp";
}
echo $noretur;
?>