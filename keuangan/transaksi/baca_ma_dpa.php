<?php
include("../sesi.php");
include("../koneksi/konek.php");
$idtrans=$_REQUEST['idtrans'];
$idma_sak=$_REQUEST['idma_sak'];

$dt="0|";
$q="SELECT madpa.ma_id,madpa.ma_kode,madpa.ma_nama 
FROM $dbakuntansi.ak_ms_jenis_transaksi_dpa mjt_dpa 
INNER JOIN $dbanggaran.ms_ma madpa ON mjt_dpa.fk_id_dpa=madpa.ma_id 
WHERE mjt_dpa.fk_jenis_trans='".$idtrans."' AND mjt_dpa.fk_ma_sak='".$idma_sak."'";
$rs1=mysql_query($q);
if (mysql_num_rows($rs1)>0){
	$rows1=mysql_fetch_array($rs1);
	$dt=$rows1["ma_id"]."|".$rows1["ma_nama"];
}
echo $dt;
?>