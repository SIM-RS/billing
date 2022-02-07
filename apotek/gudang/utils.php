<?php
include("../sesi.php");
include("../koneksi/konek.php");
$noFakturLama=$_REQUEST["noFakturLama"];
$noFaktur=$_REQUEST["noFaktur"];
$noGD=$_REQUEST["noGD"];
$noPO=$_REQUEST["noPO"];
$noSPKLama=$_REQUEST["noSPKLama"];
$noSPK=$_REQUEST["noSPK"];
$dt=$noFakturLama;
switch($_REQUEST["act"]){
	case "UpdateFaktur":
		$sql="UPDATE ".$dbapotek.".a_penerimaan SET NOBUKTI='$noFaktur' WHERE NOTERIMA='$noGD' AND NOBUKTI='$noFakturLama' AND TIPE_TRANS=0";
		$rs=mysqli_query($konek,$sql);
		if (mysqli_errno($konek)==0){
			$dt=$noFaktur;
		}
		break;
	case "UpdateSPK":
		$dt=$noSPKLama;
		$sql="UPDATE ".$dbapotek.".a_po SET KET='$noSPK' WHERE NO_PO='$noPO'";
		$rs=mysqli_query($konek,$sql);
		if (mysqli_errno($konek)==0){
			$dt=$noSPK;
			//$sql="UPDATE a_penerimaan SET BATCH='$noSPK' WHERE NOTERIMA='$noGD' AND NOBUKTI='$noFakturLama' AND TIPE_TRANS=0";
			$sql="UPDATE ".$dbapotek.".a_penerimaan p INNER JOIN a_po po ON p.FK_MINTA_ID=po.ID SET p.BATCH='$noSPK' WHERE po.NO_PO='$noPO' AND p.TIPE_TRANS=0";
			$rs=mysqli_query($konek,$sql);
			/*if (mysqli_errno($konek)==0){
				$dt=$noSPK;
			}*/
			$sql="SELECT DISTINCT p.NOTERIMA,p.NOBUKTI FROM a_penerimaan p INNER JOIN a_po po ON p.FK_MINTA_ID=po.ID WHERE po.NO_PO='$noPO' AND p.TIPE_TRANS=0";
			$rs1=mysqli_query($konek,$sql);
			while ($rw=mysqli_fetch_array($rs1)){
				$sql="UPDATE ".$dbakuntansi.".ak_posting SET no_bukti='$noSPK' WHERE no_terima='".$rw['NOTERIMA']."' AND no_faktur='".$rw['NOBUKTI']."' AND tipe=3";
				$rs=mysqli_query($konek,$sql);
			}
			
			if ($noSPK=="") $dt="&nbsp;";
		}
		break;
}
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