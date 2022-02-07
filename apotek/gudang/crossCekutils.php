<?php
include("../sesi.php");
include("../koneksi/konek.php");
$fdata=$_REQUEST["fdata"];
$dt="";

$arfdata=explode("**",$fdata);
for ($i=0;$i<count($arfdata);$i++){
	$arfvalue=explode("|",$arfdata[$i]);
	$sql="SELECT * FROM a_penerimaan ap INNER JOIN a_obat ao ON ap.OBAT_ID=ao.OBAT_ID WHERE ap.FK_MINTA_ID=".$arfvalue[0]." AND ap.OBAT_ID=".$arfvalue[1]." AND ap.TIPE_TRANS=0 ORDER BY ID DESC LIMIT 1";
	//echo $sql."<br>";
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)){
		//echo $arfvalue[2]."-".$rows["HARGA_KEMASAN"]."-".$arfvalue[3]."-".$rows["DISKON"]."<br>";
		if ($arfvalue[2]<>$rows["HARGA_KEMASAN"] || $arfvalue[3]<>$rows["DISKON"]){
			$dt.=$rows["OBAT_NAMA"]." : Harga Kemasan = ".$rows["HARGA_KEMASAN"].", Diskon = ".$rows["DISKON"]." %".chr(13).chr(10);
		}
	}
}
//echo $dt."<br>";
if ($dt=="") $dt="Belum Ada Penerimaan Obat-Obat Yang Dipilih dr PO Ini !"; 
//mysqli_free_result($rs);
mysqli_close($konek);
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
	header("Content-type: application/xhtml+xml");
}else{
	header("Content-type: text/xml");
}

echo $dt;
?>