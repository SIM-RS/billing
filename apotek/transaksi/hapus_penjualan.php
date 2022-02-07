<?php 
include("../sesi.php");
include("../koneksi/konek.php");
$no_jual=$_REQUEST['no_jual'];
$idunit=$_REQUEST['idunit'];
$ciduser=$_REQUEST['iduser'];
$iduser_jual=$_REQUEST['iduser_jual'];
if ($ciduser=="") $ciduser=$iduser_jual;
$tgl=$_REQUEST['tgl'];
$no_pasien=$_REQUEST['no_pasien'];
if ($iduser_jual!=""){
	$sql="SELECT * FROM a_penjualan WHERE UNIT_ID=$idunit AND NO_PENJUALAN='$no_jual' AND NO_PASIEN='$no_pasien' AND TGL='$tgl' AND USER_ID=$iduser_jual";
}else{
	$sql="SELECT * FROM a_penjualan WHERE UNIT_ID=$idunit AND NO_PENJUALAN='$no_jual' AND NO_PASIEN='$no_pasien' AND TGL='$tgl'";
}
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
while ($rows=mysqli_fetch_array($rs)){
	$cid=$rows['PENERIMAAN_ID'];
	$cqty=$rows['QTY_JUAL'];
	$ckpid=$rows['JENIS_PASIEN_ID'];
	$cnoJual=$rows['NO_PENJUALAN'];
	$cnoRM=$rows['NO_PASIEN'];
	$cnoKunj=$rows['NO_KUNJUNGAN'];
	$ciduser1=$rows['USER_ID'];
	if ($iduser_jual!="") $ciduser1=$iduser_jual;
	$sql="select * from a_penerimaan where ID=$cid";
	$rs1=mysqli_query($konek,$sql);
	$ch_satuan=0;
	if ($rows1=mysqli_fetch_array($rs1)){
		$ch_satuan=$rows1['HARGA_BELI_SATUAN'];
		$cdiskon=$rows1['DISKON'];
		$ctipetrans=$rows1['TIPE_TRANS'];
		$cnpajak=$rows1['NILAI_PAJAK'];
		if (($cnpajak<=0) || ($ctipetrans==4) || ($ctipetrans==5) || ($ctipetrans==100)){
			$ch_satuan=$ch_satuan * (1-($cdiskon/100));
		}else{
			$ch_satuan=$ch_satuan * (1-($cdiskon/100)) /* 1.1*/;
		}
	}
	
	$sql="UPDATE a_penerimaan SET QTY_STOK=QTY_STOK+$cqty WHERE ID=$cid";
	
	$rs1=mysqli_query($konek,$sql);
	$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS stok_after,IFNULL(SUM(t1.ntot),0) AS ntot 
	FROM (SELECT UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,
	IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),
	QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) /*1.1*/)),0) AS ntot
	FROM a_penerimaan WHERE OBAT_ID=(SELECT OBAT_ID FROM a_penerimaan WHERE ID=$cid) 
	AND KEPEMILIKAN_ID=$ckpid AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1) AS t1";
	$rs1=mysqli_query($konek,$sql);
	$rw1=mysqli_fetch_array($rs1);
	$cQtyStok=$rw1['stok_after'];
	$cNtotal=$rw1['ntot'];
	
		
	$hrg ="SELECT IFNULL(rata2,0) rata2, IFNULL(nilai,0) nilai, IFNULL(qty_stok,0) qty FROM a_stok WHERE unit_id=$idunit AND obat_id=(SELECT OBAT_ID FROM a_penerimaan WHERE ID=$cid) AND kepemilikan_id=$ckpid";
	$hrg1=mysqli_query($konek,$hrg);
		if ($hrg2=mysqli_fetch_array($hrg1)){
			$rata2=$hrg2['rata2'];
			$nilai=$hrg2['nilai'];
			$stok=$hrg2['qty'];
		}	
		
	$sql="SELECT IFNULL(COUNT(id),0) cAda FROM a_stok WHERE unit_id=$idunit AND obat_id=(SELECT OBAT_ID FROM a_penerimaan WHERE ID=$cid) AND kepemilikan_id=$ckpid";
	$rs1=mysqli_query($konek,$sql);
	$rw1=mysqli_fetch_array($rs1);
	
	if ($rw1["cAda"]>0){
		$sql="UPDATE a_stok SET qty_stok=$stok+$cqty,nilai=$nilai+($cqty*$rata2),rata2=$rata2,tgl_act=NOW() WHERE unit_id=$idunit AND obat_id=(SELECT OBAT_ID FROM a_penerimaan WHERE ID=$cid) AND kepemilikan_id=$ckpid";
	}else{
		$sql="INSERT INTO a_stok(unit_id,obat_id,kepemilikan_id,qty_stok,nilai,tgl_act) 
		VALUES($idunit,(SELECT OBAT_ID FROM a_penerimaan WHERE ID=$cid),$ckpid,$stok+$cqty,$nilai+($cqty*$rata2),NOW())";
	}
	$rs1=mysqli_query($konek,$sql);
	
	
	
	$sql="INSERT INTO A_KARTUSTOK(OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,
			STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,
			KET,USER_ID,fkid,tipetrans,HARGA_SATUAN_AWAL,NILAI_TOTAL,HARGA_SATUAN) 
			VALUES((SELECT OBAT_ID FROM a_penerimaan WHERE ID='$cid'),'$ckpid','$idunit',
			  CURDATE(),NOW(),'$cnoJual',
			  $stok,0,-$cqty,$stok+$cqty,
			  CONCAT('Hapus Penjualan: ','$cnoJual','-','$cnoRM','-','$cnoKunj'),'$ciduser','$cid',8,'$ch_satuan',$nilai+($cqty*$rata2),$rata2)";
	$rs1=mysqli_query($konek,$sql);
	
	
	
	
}

if ($iduser_jual!=""){
	$sql="DELETE FROM a_penjualan WHERE UNIT_ID=$idunit AND NO_PENJUALAN='$no_jual' AND NO_PASIEN='$no_pasien' AND TGL='$tgl' AND USER_ID=$ciduser1";
}else{
	$sql="DELETE FROM a_penjualan WHERE UNIT_ID=$idunit AND NO_PENJUALAN='$no_jual' AND NO_PASIEN='$no_pasien' AND TGL='$tgl'";
}
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
/*$sql="SELECT * FROM a_kartustok WHERE UNIT_ID=$idunit AND NO_BUKTI='$no_jual' AND TGL_TRANS='$tgl' AND tipetrans=8 order by ID desc";
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
while ($rows=mysqli_fetch_array($rs)){
	$cid=$rows['ID'];
	$cqty=$rows['KREDIT'];
	$cobatid=$rows['OBAT_ID'];
	$ckpid=$rows['KEPEMILIKAN_ID'];
	$cfkid=$rows['fkid'];
	$sql="SELECT IF (NILAI_PAJAK>0,(HARGA_BELI_SATUAN * (1-(DISKON/100))) * (1+1/10),HARGA_BELI_SATUAN-DISKON) AS harga FROM a_penerimaan WHERE ID=$cfkid";
	$rs1=mysqli_query($konek,$sql);
	$ntrans=0;
	if ($rows1=mysqli_fetch_array($rs1)){
		$ntrans=$cqty * $rows1['harga'];
	}
	$sql="UPDATE a_kartustok SET STOK_BEFOR=STOK_BEFOR+$cqty,STOK_AFTER=STOK_AFTER+$cqty,NILAI_TOTAL=NILAI_TOTAL+$ntrans WHERE UNIT_ID=$idunit AND OBAT_ID=$cobatid AND KEPEMILIKAN_ID=$ckpid AND ID>$cid";
	//echo $sql."<br>";
	$rs1=mysqli_query($konek,$sql);
	//$sql="UPDATE a_kartustok_detail SET qty_stok=qty_stok+$cqty WHERE fk_kartu_stok>$cid AND fk_idpenerimaan=$cfkid";
	//echo $sql."<br>";
	//$rs1=mysqli_query($konek,$sql);
	$sql="DELETE FROM a_kartustok WHERE ID=$cid";
	//echo $sql."<br>";
	$rs1=mysqli_query($konek,$sql);
	//$sql="DELETE FROM a_kartustok_detail WHERE fk_kartu_stok=$cid";
	//echo $sql."<br>";
	//$rs1=mysqli_query($konek,$sql);
}*/
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.msg {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
	text-transform: capitalize;
}
-->
</style>
</head>
<body>
	<p align="center" class="msg">Data Transaksi Penjualan Sudah Dihapus</p><br>
	<p align="center"><BUTTON type="button" onClick="window.close();"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">Close</BUTTON></p>
</body>
</html>
<?php 
mysqli_close($konek);
?>