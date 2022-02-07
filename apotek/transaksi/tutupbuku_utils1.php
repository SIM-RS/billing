<?php 
include("../sesi.php");
include("../koneksi/konek.php");
$th=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$th);
$cunit=$_REQUEST["cunit"];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$bulan=$_REQUEST["bulan"];
$p="OK";
//$p=$cunit." - ".$bulan." - ".$ta;
if ($bulan==""){
	$bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
}else{
	$bulan=explode("|",$bulan);
}
if ($bulan[0]==1){
	$bbulan=12;
	$bta=$ta-1;
}else{
	$bbulan=$bulan[0]-1;
	$bta=$ta;
}
$tbulan=$bulan[0];
if ($bulan[0]<10) $tbulan="0".$bulan[0];
//$corder="";
$corder="TGL_ACT DESC,";
//if (($bulan[0]<7 && $ta==2010) || ($ta<2010)) $corder="TGL_ACT DESC,";
$sql="DELETE FROM a_rpt_mutasi WHERE UNIT_ID=$cunit AND BULAN=$bulan[0] AND TAHUN=$ta";
$rs=mysqli_query($konek,$sql);
$sql="SELECT * FROM a_rpt_mutasi WHERE UNIT_ID=$cunit AND BULAN=$bbulan AND TAHUN=$bta LIMIT 1";
$rs=mysqli_query($konek,$sql);
$jml=mysqli_num_rows($rs);
if ($jml==1){
	if (($bulan[0]<8 && $ta==2010) || ($ta<2010)){
		$sql="INSERT INTO a_rpt_mutasi SELECT t1.OBAT_ID,t1.KEPEMILIKAN_ID,$cunit,$bulan[0],$ta,t1.QTY_AWAL,t1.NILAI_AWAL,IFNULL(t2.pbf,0) AS pbf,IFNULL(t2.pbf_nilai,0) AS pbf_nilai, 
IFNULL(t2.unit_in,0) AS unit_in,IFNULL(t2.unit_in_nilai,0) AS unit_in_nilai,IFNULL(t2.milik_in,0) AS milik_in,
IFNULL(t2.milik_in_nilai,0) AS milik_in_nilai,IFNULL(t2.rt_in,0) AS rt_in,IFNULL(t2.rt_in_nilai,0) AS rt_in_nilai,
IFNULL(t2.prod_in,0) AS prod_in,IFNULL(t2.prod_in_nilai,0) AS prod_in_nilai,IFNULL(t2.rsp,0) AS rsp,
IFNULL(t2.rsp_nilai,0) AS rsp_nilai,IFNULL(t2.unit_out,0) AS unit_out,IFNULL(t2.unit_out_nilai,0) AS unit_out_nilai,
IFNULL(t2.rt_out,0) AS rt_out,IFNULL(t2.rt_out_nilai,0) AS rt_out_nilai,IFNULL(t2.milik_out,0) AS milik_out,
IFNULL(t2.milik_out_nilai,0) AS milik_out_nilai,IFNULL(t2.hapus,0) AS hapus,IFNULL(t2.hapus_nilai,0) AS hapus_nilai,
IFNULL(t2.prod_out,0) AS prod_out,IFNULL(t2.prod_out_nilai,0) AS prod_out_nilai,IFNULL(t2.adj,0) AS adj,
IFNULL(t2.adj_nilai,0) AS adj_nilai,IFNULL(t2.QTY_AKHIR,IF(t1.QTY_AWAL<0,0,t1.QTY_AWAL)) AS QTY_AKHIR,IFNULL(t2.NILAI_AKHIR,IF(t1.QTY_AWAL<=0,0,t1.NILAI_AWAL)) AS NILAI_AKHIR 
FROM (SELECT OBAT_ID,KEPEMILIKAN_ID,QTY_AKHIR AS QTY_AWAL,NILAI_AKHIR AS NILAI_AWAL 
FROM a_rpt_mutasi WHERE BULAN=$bbulan AND TAHUN=$bta AND UNIT_ID=$cunit) AS t1 LEFT JOIN 
(SELECT tmp.OBAT_ID,tmp.KEPEMILIKAN_ID,STOK_AFTER AS QTY_AKHIR,NILAI_TOTAL AS NILAI_AKHIR,
SUM(IF (tipetrans=0,IF (DEBET IS NULL,0,DEBET),0)) AS pbf, 
SUM(IF (tipetrans=0,DEBET * ap.HARGA_BELI_SATUAN,0)) AS pbf_nilai,
SUM(IF (tipetrans=1,IF (DEBET IS NULL,0,DEBET),0)) AS unit_in,
SUM(IF (tipetrans=1,DEBET * ap.HARGA_BELI_SATUAN,0)) AS unit_in_nilai, 
SUM(IF (tipetrans=2,IF (DEBET IS NULL,0,DEBET),0)) AS milik_in, 
SUM(IF (tipetrans=2,DEBET * ap.HARGA_BELI_SATUAN,0)) AS milik_in_nilai, 
SUM(IF ((tipetrans=6 OR tipetrans=7),IF (KREDIT IS NULL,0,IF(KREDIT=0,0,KREDIT * -1)),0)) AS rt_in, 
SUM(IF ((tipetrans=6 OR tipetrans=7),IF(KREDIT=0,0,(KREDIT * -1)) * ap.HARGA_BELI_SATUAN,0)) AS rt_in_nilai, 
SUM(IF (tipetrans=4,IF (DEBET IS NULL,0,DEBET),0)) AS prod_in, 
SUM(IF (tipetrans=4,DEBET * ah.HARGA_BELI_SATUAN,0)) AS prod_in_nilai, 
SUM(IF (tipetrans=8,IF (KREDIT IS NULL,0,KREDIT),0)) AS rsp, 
SUM(IF (tipetrans=8,KREDIT * ap.HARGA_BELI_SATUAN,0)) AS rsp_nilai, 
SUM(IF (tipetrans=1,IF (KREDIT IS NULL,0,KREDIT),0)) AS unit_out, 
SUM(IF (tipetrans=1,KREDIT * ap.HARGA_BELI_SATUAN,0)) AS unit_out_nilai, 
SUM(IF ((tipetrans=9 OR tipetrans=7),IF (DEBET IS NULL,0,IF(DEBET=0,0,DEBET * -1)),0)) AS rt_out, 
SUM(IF ((tipetrans=9 OR tipetrans=7),IF(DEBET=0,0,(DEBET * -1)) * ap.HARGA_BELI_SATUAN,0)) AS rt_out_nilai, 
SUM(IF (tipetrans=2,IF (KREDIT IS NULL,0,KREDIT),0)) AS milik_out, 
SUM(IF (tipetrans=2,KREDIT * ap.HARGA_BELI_SATUAN,0)) AS milik_out_nilai, 
SUM(IF (tipetrans=10,IF (KREDIT IS NULL,0,KREDIT),0)) AS hapus, 
SUM(IF (tipetrans=10,KREDIT * ap.HARGA_BELI_SATUAN,0)) AS hapus_nilai, 
SUM(IF (tipetrans=4,IF (KREDIT IS NULL,0,KREDIT),0)) AS prod_out, 
SUM(IF (tipetrans=4,KREDIT * ap.HARGA_BELI_SATUAN,0)) AS prod_out_nilai, 
SUM(IF (tipetrans=5,IF (DEBET-KREDIT IS NULL,0,DEBET-KREDIT),0)) AS adj, 
SUM(IF (tipetrans=5,IF (fkid=0,(DEBET-KREDIT) * ah.HARGA_BELI_SATUAN,(DEBET-KREDIT) * ap.HARGA_BELI_SATUAN),0)) AS adj_nilai 
FROM (SELECT * FROM a_kartustok WHERE UNIT_ID=$cunit AND TGL_ACT BETWEEN '$ta-$tbulan-01 00:00:00' AND '$ta-$tbulan-31 23:59:59' ORDER BY ".$corder."ID DESC) AS tmp
LEFT JOIN a_penerimaan ap ON tmp.fkid=ap.ID LEFT JOIN (SELECT OBAT_ID,KEPEMILIKAN_ID,MAX(HARGA_BELI_SATUAN) AS HARGA_BELI_SATUAN FROM a_harga GROUP BY OBAT_ID,KEPEMILIKAN_ID) ah ON (tmp.OBAT_ID=ah.OBAT_ID AND tmp.KEPEMILIKAN_ID=ah.KEPEMILIKAN_ID)
GROUP BY tmp.OBAT_ID,tmp.KEPEMILIKAN_ID) AS t2 ON (t1.OBAT_ID=t2.OBAT_ID AND t1.KEPEMILIKAN_ID=t2.KEPEMILIKAN_ID)";
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$sql="INSERT INTO a_rpt_mutasi SELECT t1.OBAT_ID,t1.KEPEMILIKAN_ID,$cunit,$bulan[0],$ta,0,0,t1.pbf,t1.pbf_nilai,t1.unit_in,t1.unit_in_nilai,t1.milik_in,t1.milik_in_nilai,
		t1.rt_in,t1.rt_in_nilai,t1.prod_in,t1.prod_in_nilai,t1.rsp,t1.rsp_nilai,t1.UNIT_OUT,t1.UNIT_OUT_NILAI,
		t1.rt_out,t1.rt_out_nilai,t1.milik_out,t1.milik_out_nilai,t1.hapus,t1.hapus_nilai,t1.prod_out,t1.prod_out_nilai,
		t1.adj,t1.adj_nilai,t1.QTY_AKHIR,t1.NILAI_AKHIR 
		FROM (SELECT tmp.OBAT_ID,tmp.KEPEMILIKAN_ID,STOK_AFTER AS QTY_AKHIR,NILAI_TOTAL AS NILAI_AKHIR,
		SUM(IF (tipetrans=0,IF (DEBET IS NULL,0,DEBET),0)) AS pbf, 
		SUM(IF (tipetrans=0,DEBET * ap.HARGA_BELI_SATUAN,0)) AS pbf_nilai,
		SUM(IF (tipetrans=1,IF (DEBET IS NULL,0,DEBET),0)) AS unit_in,
		SUM(IF (tipetrans=1,DEBET * ap.HARGA_BELI_SATUAN,0)) AS unit_in_nilai, 
		SUM(IF (tipetrans=2,IF (DEBET IS NULL,0,DEBET),0)) AS milik_in, 
		SUM(IF (tipetrans=2,DEBET * ap.HARGA_BELI_SATUAN,0)) AS milik_in_nilai, 
		SUM(IF ((tipetrans=6 OR tipetrans=7),IF (KREDIT IS NULL,0,IF(KREDIT=0,0,KREDIT * -1)),0)) AS rt_in, 
		SUM(IF ((tipetrans=6 OR tipetrans=7),IF(KREDIT=0,0,(KREDIT * -1)) * ap.HARGA_BELI_SATUAN,0)) AS rt_in_nilai, 
		SUM(IF (tipetrans=4,IF (DEBET IS NULL,0,DEBET),0)) AS prod_in, 
		SUM(IF (tipetrans=4,DEBET * ah.HARGA_BELI_SATUAN,0)) AS prod_in_nilai, 
		SUM(IF (tipetrans=8,IF (KREDIT IS NULL,0,KREDIT),0)) AS rsp, 
		SUM(IF (tipetrans=8,KREDIT * ap.HARGA_BELI_SATUAN,0)) AS rsp_nilai, 
		SUM(IF (tipetrans=1,IF (KREDIT IS NULL,0,KREDIT),0)) AS unit_out, 
		SUM(IF (tipetrans=1,KREDIT * ap.HARGA_BELI_SATUAN,0)) AS unit_out_nilai, 
		SUM(IF ((tipetrans=9 OR tipetrans=7),IF (DEBET IS NULL,0,IF(DEBET=0,0,DEBET * -1)),0)) AS rt_out, 
		SUM(IF ((tipetrans=9 OR tipetrans=7),IF(DEBET=0,0,(DEBET * -1)) * ap.HARGA_BELI_SATUAN,0)) AS rt_out_nilai, 
		SUM(IF (tipetrans=2,IF (KREDIT IS NULL,0,KREDIT),0)) AS milik_out, 
		SUM(IF (tipetrans=2,KREDIT * ap.HARGA_BELI_SATUAN,0)) AS milik_out_nilai, 
		SUM(IF (tipetrans=10,IF (KREDIT IS NULL,0,KREDIT),0)) AS hapus, 
		SUM(IF (tipetrans=10,KREDIT * ap.HARGA_BELI_SATUAN,0)) AS hapus_nilai, 
		SUM(IF (tipetrans=4,IF (KREDIT IS NULL,0,KREDIT),0)) AS prod_out, 
		SUM(IF (tipetrans=4,KREDIT * ap.HARGA_BELI_SATUAN,0)) AS prod_out_nilai, 
		SUM(IF (tipetrans=5,IF (DEBET-KREDIT IS NULL,0,DEBET-KREDIT),0)) AS adj, 
		SUM(IF (tipetrans=5,IF (fkid=0,(DEBET-KREDIT) * ah.HARGA_BELI_SATUAN,(DEBET-KREDIT) * ap.HARGA_BELI_SATUAN),0)) AS adj_nilai 
		FROM (SELECT * FROM a_kartustok WHERE UNIT_ID=$cunit AND TGL_ACT BETWEEN '$ta-$tbulan-01 00:00:00' AND '$ta-$tbulan-31 23:59:59' ORDER BY ".$corder."ID DESC) AS tmp
		LEFT JOIN a_penerimaan ap ON tmp.fkid=ap.ID LEFT JOIN (SELECT OBAT_ID,KEPEMILIKAN_ID,MAX(HARGA_BELI_SATUAN) AS HARGA_BELI_SATUAN FROM a_harga GROUP BY OBAT_ID,KEPEMILIKAN_ID) ah ON (tmp.OBAT_ID=ah.OBAT_ID AND tmp.KEPEMILIKAN_ID=ah.KEPEMILIKAN_ID)
		GROUP BY tmp.OBAT_ID,tmp.KEPEMILIKAN_ID) AS t1 LEFT JOIN 
		(SELECT OBAT_ID,KEPEMILIKAN_ID FROM a_rpt_mutasi WHERE BULAN=$bulan[0] AND TAHUN=$ta AND UNIT_ID=$cunit) AS t2 
		ON (t1.OBAT_ID=t2.OBAT_ID AND t1.KEPEMILIKAN_ID=t2.KEPEMILIKAN_ID) WHERE t2.OBAT_ID IS NULL";
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
	}else{
		$sql="INSERT INTO a_rpt_mutasi SELECT t1.OBAT_ID,t1.KEPEMILIKAN_ID,$cunit AS UNIT_ID,$bulan[0] AS BULAN,$ta AS TAHUN,IF(t1.QTY_AWAL<0,0,t1.QTY_AWAL) AS QTY_AWAL,IF(t1.QTY_AWAL<=0,0,t1.NILAI_AWAL) AS NILAI_AWAL,IFNULL(t2.pbf,0) AS pbf,IFNULL(t2.pbf_nilai,0) AS pbf_nilai, 
IFNULL(t2.unit_in,0) AS unit_in,IFNULL(t2.unit_in_nilai,0) AS unit_in_nilai,IFNULL(t2.milik_in,0) AS milik_in,
IFNULL(t2.milik_in_nilai,0) AS milik_in_nilai,IFNULL(t2.rt_in,0) AS rt_in,IFNULL(t2.rt_in_nilai,0) AS rt_in_nilai,
IFNULL(t2.prod_in,0) AS prod_in,IFNULL(t2.prod_in_nilai,0) AS prod_in_nilai,IFNULL(t2.rsp,0) AS rsp,
IFNULL(t2.rsp_nilai,0) AS rsp_nilai,IFNULL(t2.unit_out,0) AS unit_out,IFNULL(t2.unit_out_nilai,0) AS unit_out_nilai,
IFNULL(t2.rt_out,0) AS rt_out,IFNULL(t2.rt_out_nilai,0) AS rt_out_nilai,IFNULL(t2.milik_out,0) AS milik_out,
IFNULL(t2.milik_out_nilai,0) AS milik_out_nilai,IFNULL(t2.hapus,0) AS hapus,IFNULL(t2.hapus_nilai,0) AS hapus_nilai,
IFNULL(t2.prod_out,0) AS prod_out,IFNULL(t2.prod_out_nilai,0) AS prod_out_nilai,IFNULL(t2.adj,0) AS adj,
IFNULL(t2.adj_nilai,0) AS adj_nilai,IFNULL(t2.QTY_AKHIR,IF(t1.QTY_AWAL<0,0,t1.QTY_AWAL)) AS QTY_AKHIR,IFNULL(t2.NILAI_AKHIR,IF(t1.QTY_AWAL<=0,0,t1.NILAI_AWAL)) AS NILAI_AKHIR 
FROM (SELECT OBAT_ID,KEPEMILIKAN_ID,QTY_AKHIR AS QTY_AWAL,NILAI_AKHIR AS NILAI_AWAL 
FROM a_rpt_mutasi WHERE BULAN=$bbulan AND TAHUN=$bta AND UNIT_ID=$cunit) AS t1 LEFT JOIN 
(SELECT tmp.OBAT_ID,tmp.KEPEMILIKAN_ID,STOK_AFTER AS QTY_AKHIR,NILAI_TOTAL AS NILAI_AKHIR,
SUM(IF (tipetrans=0,IF (DEBET IS NULL,0,DEBET),0)) AS pbf, 
SUM(IF (tipetrans=0,DEBET * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS pbf_nilai,
SUM(IF (tipetrans=1,IF (DEBET IS NULL,0,DEBET),0)) AS unit_in,
SUM(IF (tipetrans=1,DEBET * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS unit_in_nilai, 
SUM(IF (tipetrans=2,IF (DEBET IS NULL,0,DEBET),0)) AS milik_in, 
SUM(IF (tipetrans=2,DEBET * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS milik_in_nilai, 
SUM(IF ((tipetrans=6 OR tipetrans=7),IF (KREDIT IS NULL,0,IF(KREDIT=0,0,KREDIT * -1)),0)) AS rt_in, 
SUM(IF ((tipetrans=6 OR tipetrans=7),IF(KREDIT=0,0,(KREDIT * -1)) * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS rt_in_nilai, 
SUM(IF (tipetrans=4,IF (DEBET IS NULL,0,DEBET),0)) AS prod_in, 
SUM(IF (tipetrans=4,DEBET * ah.HARGA_BELI_SATUAN,0)) AS prod_in_nilai, 
SUM(IF (tipetrans=8,IF (KREDIT IS NULL,0,KREDIT),0)) AS rsp, 
SUM(IF (tipetrans=8,KREDIT * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS rsp_nilai, 
SUM(IF (tipetrans=1,IF (KREDIT IS NULL,0,KREDIT),0)) AS unit_out, 
SUM(IF (tipetrans=1,KREDIT * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS unit_out_nilai, 
SUM(IF ((tipetrans=9 OR tipetrans=7),IF (DEBET IS NULL,0,IF(DEBET=0,0,DEBET * -1)),0)) AS rt_out, 
SUM(IF ((tipetrans=9 OR tipetrans=7),IF(DEBET=0,0,(DEBET * -1)) * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS rt_out_nilai, 
SUM(IF (tipetrans=2,IF (KREDIT IS NULL,0,KREDIT),0)) AS milik_out, 
SUM(IF (tipetrans=2,KREDIT * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS milik_out_nilai, 
SUM(IF (tipetrans=10,IF (KREDIT IS NULL,0,KREDIT),0)) AS hapus, 
SUM(IF (tipetrans=10,KREDIT * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS hapus_nilai, 
SUM(IF (tipetrans=4,IF (KREDIT IS NULL,0,KREDIT),0)) AS prod_out, 
SUM(IF (tipetrans=4,KREDIT * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS prod_out_nilai, 
SUM(IF (tipetrans=5,IF (DEBET-KREDIT IS NULL,0,DEBET-KREDIT),0)) AS adj, 
SUM(IF (tipetrans=5,IF (fkid=0,(DEBET-KREDIT) * ah.HARGA_BELI_SATUAN,(DEBET-KREDIT) * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1)),0)) AS adj_nilai 
FROM (SELECT * FROM a_kartustok WHERE UNIT_ID=$cunit AND TGL_ACT BETWEEN '$ta-$tbulan-01 00:00:00' AND '$ta-$tbulan-31 23:59:59' ORDER BY ".$corder."ID DESC) AS tmp
LEFT JOIN a_penerimaan ap ON tmp.fkid=ap.ID LEFT JOIN (SELECT OBAT_ID,KEPEMILIKAN_ID,MAX(HARGA_BELI_SATUAN) AS HARGA_BELI_SATUAN FROM a_harga GROUP BY OBAT_ID,KEPEMILIKAN_ID) ah ON (tmp.OBAT_ID=ah.OBAT_ID AND tmp.KEPEMILIKAN_ID=ah.KEPEMILIKAN_ID)
GROUP BY tmp.OBAT_ID,tmp.KEPEMILIKAN_ID) AS t2 ON (t1.OBAT_ID=t2.OBAT_ID AND t1.KEPEMILIKAN_ID=t2.KEPEMILIKAN_ID)";
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$sql="INSERT INTO a_rpt_mutasi SELECT t1.OBAT_ID,t1.KEPEMILIKAN_ID,$cunit,$bulan[0],$ta,0,0,t1.pbf,t1.pbf_nilai,t1.unit_in,t1.unit_in_nilai,t1.milik_in,t1.milik_in_nilai,
		t1.rt_in,t1.rt_in_nilai,t1.prod_in,t1.prod_in_nilai,t1.rsp,t1.rsp_nilai,t1.UNIT_OUT,t1.UNIT_OUT_NILAI,
		t1.rt_out,t1.rt_out_nilai,t1.milik_out,t1.milik_out_nilai,t1.hapus,t1.hapus_nilai,t1.prod_out,t1.prod_out_nilai,
		t1.adj,t1.adj_nilai,t1.QTY_AKHIR,t1.NILAI_AKHIR 
		FROM (SELECT tmp.OBAT_ID,tmp.KEPEMILIKAN_ID,STOK_AFTER AS QTY_AKHIR,NILAI_TOTAL AS NILAI_AKHIR,
		SUM(IF (tipetrans=0,IF (DEBET IS NULL,0,DEBET),0)) AS pbf, 
		SUM(IF (tipetrans=0,DEBET * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS pbf_nilai,
		SUM(IF (tipetrans=1,IF (DEBET IS NULL,0,DEBET),0)) AS unit_in,
		SUM(IF (tipetrans=1,DEBET * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS unit_in_nilai, 
		SUM(IF (tipetrans=2,IF (DEBET IS NULL,0,DEBET),0)) AS milik_in, 
		SUM(IF (tipetrans=2,DEBET * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS milik_in_nilai, 
		SUM(IF ((tipetrans=6 OR tipetrans=7),IF (KREDIT IS NULL,0,IF(KREDIT=0,0,KREDIT * -1)),0)) AS rt_in, 
		SUM(IF ((tipetrans=6 OR tipetrans=7),IF(KREDIT=0,0,(KREDIT * -1)) * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS rt_in_nilai, 
		SUM(IF (tipetrans=4,IF (DEBET IS NULL,0,DEBET),0)) AS prod_in, 
		SUM(IF (tipetrans=4,DEBET * ah.HARGA_BELI_SATUAN,0)) AS prod_in_nilai, 
		SUM(IF (tipetrans=8,IF (KREDIT IS NULL,0,KREDIT),0)) AS rsp, 
		SUM(IF (tipetrans=8,KREDIT * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS rsp_nilai, 
		SUM(IF (tipetrans=1,IF (KREDIT IS NULL,0,KREDIT),0)) AS unit_out, 
		SUM(IF (tipetrans=1,KREDIT * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS unit_out_nilai, 
		SUM(IF ((tipetrans=9 OR tipetrans=7),IF (DEBET IS NULL,0,IF(DEBET=0,0,DEBET * -1)),0)) AS rt_out, 
		SUM(IF ((tipetrans=9 OR tipetrans=7),IF(DEBET=0,0,(DEBET * -1)) * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS rt_out_nilai, 
		SUM(IF (tipetrans=2,IF (KREDIT IS NULL,0,KREDIT),0)) AS milik_out, 
		SUM(IF (tipetrans=2,KREDIT * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS milik_out_nilai, 
		SUM(IF (tipetrans=10,IF (KREDIT IS NULL,0,KREDIT),0)) AS hapus, 
		SUM(IF (tipetrans=10,KREDIT * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS hapus_nilai, 
		SUM(IF (tipetrans=4,IF (KREDIT IS NULL,0,KREDIT),0)) AS prod_out, 
		SUM(IF (tipetrans=4,KREDIT * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS prod_out_nilai, 
		SUM(IF (tipetrans=5,IF (DEBET-KREDIT IS NULL,0,DEBET-KREDIT),0)) AS adj, 
		SUM(IF (tipetrans=5,IF (fkid=0,(DEBET-KREDIT) * ah.HARGA_BELI_SATUAN,(DEBET-KREDIT) * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1)),0)) AS adj_nilai 
		FROM (SELECT * FROM a_kartustok WHERE UNIT_ID=$cunit AND TGL_ACT BETWEEN '$ta-$tbulan-01 00:00:00' AND '$ta-$tbulan-31 23:59:59' ORDER BY ".$corder."ID DESC) AS tmp
		LEFT JOIN a_penerimaan ap ON tmp.fkid=ap.ID LEFT JOIN (SELECT OBAT_ID,KEPEMILIKAN_ID,MAX(HARGA_BELI_SATUAN) AS HARGA_BELI_SATUAN FROM a_harga GROUP BY OBAT_ID,KEPEMILIKAN_ID) ah ON (tmp.OBAT_ID=ah.OBAT_ID AND tmp.KEPEMILIKAN_ID=ah.KEPEMILIKAN_ID)
		GROUP BY tmp.OBAT_ID,tmp.KEPEMILIKAN_ID) AS t1 LEFT JOIN 
		(SELECT OBAT_ID,KEPEMILIKAN_ID FROM a_rpt_mutasi WHERE BULAN=$bulan[0] AND TAHUN=$ta AND UNIT_ID=$cunit) AS t2 
		ON (t1.OBAT_ID=t2.OBAT_ID AND t1.KEPEMILIKAN_ID=t2.KEPEMILIKAN_ID) WHERE t2.OBAT_ID IS NULL";
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
	}
}else{
	if (($bulan[0]<8 && $ta==2010) || ($ta<2010)){
		$sql="INSERT INTO a_rpt_mutasi SELECT t2.OBAT_ID,t2.KEPEMILIKAN_ID,$cunit,$bulan[0],$ta,t2.QTY_AWAL,t2.NILAI_AWAL,IFNULL(pbf,0) AS pbf,IFNULL(pbf_nilai,0) AS pbf_nilai,
		IFNULL(unit_in,0) AS unit_in,IFNULL(unit_in_nilai,0) AS unit_in_nilai,IFNULL(milik_in,0) AS milik_in,
		IFNULL(milik_in_nilai,0) AS milik_in_nilai,IFNULL(rt_in,0) AS rt_in,IFNULL(rt_in_nilai,0) AS rt_in_nilai,
		IFNULL(prod_in,0) AS prod_in,IFNULL(prod_in_nilai,0) AS prod_in_nilai,IFNULL(rsp,0) AS rsp,IFNULL(rsp_nilai,0) AS rsp_nilai,
		IFNULL(unit_out,0) AS unit_out,IFNULL(unit_out_nilai,0) AS unit_out_nilai,IFNULL(rt_out,0) AS rt_out,
		IFNULL(rt_out_nilai,0) AS rt_out_nilai,IFNULL(milik_out,0) AS milik_out,IFNULL(milik_out_nilai,0) AS milik_out_nilai,
		IFNULL(hapus,0) AS hapus,IFNULL(hapus_nilai,0) AS hapus_nilai,IFNULL(prod_out,0) AS prod_out,
		IFNULL(prod_out_nilai,0) AS prod_out_nilai,IFNULL(adj,0) AS adj,IFNULL(adj_nilai,0) AS adj_nilai,
		IFNULL(QTY_AKHIR,t2.QTY_AWAL) AS QTY_AKHIR,IFNULL(NILAI_AKHIR,t2.NILAI_AWAL) AS NILAI_AKHIR 
		FROM (SELECT OBAT_ID,KEPEMILIKAN_ID,STOK_AFTER AS QTY_AWAL,NILAI_TOTAL AS NILAI_AWAL FROM 
		(SELECT OBAT_ID,KEPEMILIKAN_ID,STOK_AFTER,NILAI_TOTAL FROM a_kartustok 
		WHERE UNIT_ID=$cunit AND TGL_ACT<'$ta-$tbulan-01 00:00:00' ORDER BY ".$corder."ID DESC) AS tpm GROUP BY OBAT_ID,KEPEMILIKAN_ID) AS t2
		LEFT JOIN 
		(SELECT tmp.OBAT_ID,tmp.KEPEMILIKAN_ID,STOK_AFTER AS QTY_AKHIR,NILAI_TOTAL AS NILAI_AKHIR,
		SUM(IF (tipetrans=0,IF (DEBET IS NULL,0,DEBET),0)) AS pbf, 
		SUM(IF (tipetrans=0,DEBET * ap.HARGA_BELI_SATUAN,0)) AS pbf_nilai,
		SUM(IF (tipetrans=1,IF (DEBET IS NULL,0,DEBET),0)) AS unit_in,
		SUM(IF (tipetrans=1,DEBET * ap.HARGA_BELI_SATUAN,0)) AS unit_in_nilai, 
		SUM(IF (tipetrans=2,IF (DEBET IS NULL,0,DEBET),0)) AS milik_in, 
		SUM(IF (tipetrans=2,DEBET * ap.HARGA_BELI_SATUAN,0)) AS milik_in_nilai, 
		SUM(IF ((tipetrans=6 OR tipetrans=7),IF (KREDIT IS NULL,0,IF(KREDIT=0,0,KREDIT * -1)),0)) AS rt_in, 
		SUM(IF ((tipetrans=6 OR tipetrans=7),IF(KREDIT=0,0,(KREDIT * -1)) * ap.HARGA_BELI_SATUAN,0)) AS rt_in_nilai, 
		SUM(IF (tipetrans=4,IF (DEBET IS NULL,0,DEBET),0)) AS prod_in, 
		SUM(IF (tipetrans=4,DEBET * ah.HARGA_BELI_SATUAN,0)) AS prod_in_nilai, 
		SUM(IF (tipetrans=8,IF (KREDIT IS NULL,0,KREDIT),0)) AS rsp, 
		SUM(IF (tipetrans=8,KREDIT * ap.HARGA_BELI_SATUAN,0)) AS rsp_nilai, 
		SUM(IF (tipetrans=1,IF (KREDIT IS NULL,0,KREDIT),0)) AS unit_out, 
		SUM(IF (tipetrans=1,KREDIT * ap.HARGA_BELI_SATUAN,0)) AS unit_out_nilai, 
		SUM(IF ((tipetrans=9 OR tipetrans=7),IF (DEBET IS NULL,0,IF(DEBET=0,0,DEBET * -1)),0)) AS rt_out, 
		SUM(IF ((tipetrans=9 OR tipetrans=7),IF(DEBET=0,0,(DEBET * -1)) * ap.HARGA_BELI_SATUAN,0)) AS rt_out_nilai, 
		SUM(IF (tipetrans=2,IF (KREDIT IS NULL,0,KREDIT),0)) AS milik_out, 
		SUM(IF (tipetrans=2,KREDIT * ap.HARGA_BELI_SATUAN,0)) AS milik_out_nilai, 
		SUM(IF (tipetrans=10,IF (KREDIT IS NULL,0,KREDIT),0)) AS hapus, 
		SUM(IF (tipetrans=10,KREDIT * ap.HARGA_BELI_SATUAN,0)) AS hapus_nilai, 
		SUM(IF (tipetrans=4,IF (KREDIT IS NULL,0,KREDIT),0)) AS prod_out, 
		SUM(IF (tipetrans=4,KREDIT * ap.HARGA_BELI_SATUAN,0)) AS prod_out_nilai, 
		SUM(IF (tipetrans=5,IF (DEBET-KREDIT IS NULL,0,DEBET-KREDIT),0)) AS adj, 
		SUM(IF (tipetrans=5,IF (fkid=0,(DEBET-KREDIT) * ah.HARGA_BELI_SATUAN,(DEBET-KREDIT) * ap.HARGA_BELI_SATUAN),0)) AS adj_nilai 
		FROM (SELECT * FROM a_kartustok WHERE UNIT_ID=$cunit AND TGL_ACT BETWEEN '$ta-$tbulan-01 00:00:00' AND '$ta-$tbulan-31 23:59:59' ORDER BY ".$corder."ID DESC) AS tmp
		LEFT JOIN a_penerimaan ap ON tmp.fkid=ap.ID LEFT JOIN (SELECT OBAT_ID,KEPEMILIKAN_ID,MAX(HARGA_BELI_SATUAN) AS HARGA_BELI_SATUAN FROM a_harga GROUP BY OBAT_ID,KEPEMILIKAN_ID) ah ON (tmp.OBAT_ID=ah.OBAT_ID AND tmp.KEPEMILIKAN_ID=ah.KEPEMILIKAN_ID)
		GROUP BY tmp.OBAT_ID,tmp.KEPEMILIKAN_ID) AS t1 ON (t2.OBAT_ID=t1.OBAT_ID AND t2.KEPEMILIKAN_ID=t1.KEPEMILIKAN_ID)";
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$sql="INSERT INTO a_rpt_mutasi SELECT t1.OBAT_ID,t1.KEPEMILIKAN_ID,$cunit,$bulan[0],$ta,0,0,t1.pbf,t1.pbf_nilai,t1.unit_in,t1.unit_in_nilai,t1.milik_in,t1.milik_in_nilai,
		t1.rt_in,t1.rt_in_nilai,t1.prod_in,t1.prod_in_nilai,t1.rsp,t1.rsp_nilai,t1.UNIT_OUT,t1.UNIT_OUT_NILAI,
		t1.rt_out,t1.rt_out_nilai,t1.milik_out,t1.milik_out_nilai,t1.hapus,t1.hapus_nilai,t1.prod_out,t1.prod_out_nilai,
		t1.adj,t1.adj_nilai,t1.QTY_AKHIR,t1.NILAI_AKHIR 
		FROM (SELECT tmp.OBAT_ID,tmp.KEPEMILIKAN_ID,STOK_AFTER AS QTY_AKHIR,NILAI_TOTAL AS NILAI_AKHIR,
		SUM(IF (tipetrans=0,IF (DEBET IS NULL,0,DEBET),0)) AS pbf, 
		SUM(IF (tipetrans=0,DEBET * ap.HARGA_BELI_SATUAN,0)) AS pbf_nilai,
		SUM(IF (tipetrans=1,IF (DEBET IS NULL,0,DEBET),0)) AS unit_in,
		SUM(IF (tipetrans=1,DEBET * ap.HARGA_BELI_SATUAN,0)) AS unit_in_nilai, 
		SUM(IF (tipetrans=2,IF (DEBET IS NULL,0,DEBET),0)) AS milik_in, 
		SUM(IF (tipetrans=2,DEBET * ap.HARGA_BELI_SATUAN,0)) AS milik_in_nilai, 
		SUM(IF ((tipetrans=6 OR tipetrans=7),IF (KREDIT IS NULL,0,IF(KREDIT=0,0,KREDIT * -1)),0)) AS rt_in, 
		SUM(IF ((tipetrans=6 OR tipetrans=7),IF(KREDIT=0,0,(KREDIT * -1)) * ap.HARGA_BELI_SATUAN,0)) AS rt_in_nilai, 
		SUM(IF (tipetrans=4,IF (DEBET IS NULL,0,DEBET),0)) AS prod_in, 
		SUM(IF (tipetrans=4,DEBET * ah.HARGA_BELI_SATUAN,0)) AS prod_in_nilai, 
		SUM(IF (tipetrans=8,IF (KREDIT IS NULL,0,KREDIT),0)) AS rsp, 
		SUM(IF (tipetrans=8,KREDIT * ap.HARGA_BELI_SATUAN,0)) AS rsp_nilai, 
		SUM(IF (tipetrans=1,IF (KREDIT IS NULL,0,KREDIT),0)) AS unit_out, 
		SUM(IF (tipetrans=1,KREDIT * ap.HARGA_BELI_SATUAN,0)) AS unit_out_nilai, 
		SUM(IF ((tipetrans=9 OR tipetrans=7),IF (DEBET IS NULL,0,IF(DEBET=0,0,DEBET * -1)),0)) AS rt_out, 
		SUM(IF ((tipetrans=9 OR tipetrans=7),IF(DEBET=0,0,(DEBET * -1)) * ap.HARGA_BELI_SATUAN,0)) AS rt_out_nilai, 
		SUM(IF (tipetrans=2,IF (KREDIT IS NULL,0,KREDIT),0)) AS milik_out, 
		SUM(IF (tipetrans=2,KREDIT * ap.HARGA_BELI_SATUAN,0)) AS milik_out_nilai, 
		SUM(IF (tipetrans=10,IF (KREDIT IS NULL,0,KREDIT),0)) AS hapus, 
		SUM(IF (tipetrans=10,KREDIT * ap.HARGA_BELI_SATUAN,0)) AS hapus_nilai, 
		SUM(IF (tipetrans=4,IF (KREDIT IS NULL,0,KREDIT),0)) AS prod_out, 
		SUM(IF (tipetrans=4,KREDIT * ap.HARGA_BELI_SATUAN,0)) AS prod_out_nilai, 
		SUM(IF (tipetrans=5,IF (DEBET-KREDIT IS NULL,0,DEBET-KREDIT),0)) AS adj, 
		SUM(IF (tipetrans=5,IF (fkid=0,(DEBET-KREDIT) * ah.HARGA_BELI_SATUAN,(DEBET-KREDIT) * ap.HARGA_BELI_SATUAN),0)) AS adj_nilai 
		FROM (SELECT * FROM a_kartustok WHERE UNIT_ID=$cunit AND TGL_ACT BETWEEN '$ta-$tbulan-01 00:00:00' AND '$ta-$tbulan-31 23:59:59' ORDER BY ".$corder."ID DESC) AS tmp
		LEFT JOIN a_penerimaan ap ON tmp.fkid=ap.ID LEFT JOIN (SELECT OBAT_ID,KEPEMILIKAN_ID,MAX(HARGA_BELI_SATUAN) AS HARGA_BELI_SATUAN FROM a_harga GROUP BY OBAT_ID,KEPEMILIKAN_ID) ah ON (tmp.OBAT_ID=ah.OBAT_ID AND tmp.KEPEMILIKAN_ID=ah.KEPEMILIKAN_ID)
		GROUP BY tmp.OBAT_ID,tmp.KEPEMILIKAN_ID) AS t1 LEFT JOIN 
		(SELECT OBAT_ID,KEPEMILIKAN_ID FROM a_rpt_mutasi WHERE BULAN=$bulan[0] AND TAHUN=$ta AND UNIT_ID=$cunit) AS t2 
		ON (t1.OBAT_ID=t2.OBAT_ID AND t1.KEPEMILIKAN_ID=t2.KEPEMILIKAN_ID) WHERE t2.OBAT_ID IS NULL";
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
	}else{
		$sql="INSERT INTO a_rpt_mutasi SELECT t2.OBAT_ID,t2.KEPEMILIKAN_ID,$cunit,$bulan[0],$ta,t2.QTY_AWAL,t2.NILAI_AWAL,IFNULL(pbf,0) AS pbf,IFNULL(pbf_nilai,0) AS pbf_nilai,
		IFNULL(unit_in,0) AS unit_in,IFNULL(unit_in_nilai,0) AS unit_in_nilai,IFNULL(milik_in,0) AS milik_in,
		IFNULL(milik_in_nilai,0) AS milik_in_nilai,IFNULL(rt_in,0) AS rt_in,IFNULL(rt_in_nilai,0) AS rt_in_nilai,
		IFNULL(prod_in,0) AS prod_in,IFNULL(prod_in_nilai,0) AS prod_in_nilai,IFNULL(rsp,0) AS rsp,IFNULL(rsp_nilai,0) AS rsp_nilai,
		IFNULL(unit_out,0) AS unit_out,IFNULL(unit_out_nilai,0) AS unit_out_nilai,IFNULL(rt_out,0) AS rt_out,
		IFNULL(rt_out_nilai,0) AS rt_out_nilai,IFNULL(milik_out,0) AS milik_out,IFNULL(milik_out_nilai,0) AS milik_out_nilai,
		IFNULL(hapus,0) AS hapus,IFNULL(hapus_nilai,0) AS hapus_nilai,IFNULL(prod_out,0) AS prod_out,
		IFNULL(prod_out_nilai,0) AS prod_out_nilai,IFNULL(adj,0) AS adj,IFNULL(adj_nilai,0) AS adj_nilai,
		IFNULL(QTY_AKHIR,t2.QTY_AWAL) AS QTY_AKHIR,IFNULL(NILAI_AKHIR,t2.NILAI_AWAL) AS NILAI_AKHIR 
		FROM (SELECT OBAT_ID,KEPEMILIKAN_ID,STOK_AFTER AS QTY_AWAL,NILAI_TOTAL AS NILAI_AWAL FROM 
		(SELECT OBAT_ID,KEPEMILIKAN_ID,STOK_AFTER,NILAI_TOTAL FROM a_kartustok 
		WHERE UNIT_ID=$cunit AND TGL_ACT<'$ta-$tbulan-01 00:00:00' ORDER BY ".$corder."ID DESC) AS tpm GROUP BY OBAT_ID,KEPEMILIKAN_ID) AS t2
		LEFT JOIN 
		(SELECT tmp.OBAT_ID,tmp.KEPEMILIKAN_ID,STOK_AFTER AS QTY_AKHIR,NILAI_TOTAL AS NILAI_AKHIR,
		SUM(IF (tipetrans=0,IF (DEBET IS NULL,0,DEBET),0)) AS pbf, 
		SUM(IF (tipetrans=0,DEBET * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS pbf_nilai,
		SUM(IF (tipetrans=1,IF (DEBET IS NULL,0,DEBET),0)) AS unit_in,
		SUM(IF (tipetrans=1,DEBET * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS unit_in_nilai, 
		SUM(IF (tipetrans=2,IF (DEBET IS NULL,0,DEBET),0)) AS milik_in, 
		SUM(IF (tipetrans=2,DEBET * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS milik_in_nilai, 
		SUM(IF ((tipetrans=6 OR tipetrans=7),IF (KREDIT IS NULL,0,IF(KREDIT=0,0,KREDIT * -1)),0)) AS rt_in, 
		SUM(IF ((tipetrans=6 OR tipetrans=7),IF(KREDIT=0,0,(KREDIT * -1)) * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS rt_in_nilai, 
		SUM(IF (tipetrans=4,IF (DEBET IS NULL,0,DEBET),0)) AS prod_in, 
		SUM(IF (tipetrans=4,DEBET * ah.HARGA_BELI_SATUAN,0)) AS prod_in_nilai, 
		SUM(IF (tipetrans=8,IF (KREDIT IS NULL,0,KREDIT),0)) AS rsp, 
		SUM(IF (tipetrans=8,KREDIT * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS rsp_nilai, 
		SUM(IF (tipetrans=1,IF (KREDIT IS NULL,0,KREDIT),0)) AS unit_out, 
		SUM(IF (tipetrans=1,KREDIT * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS unit_out_nilai, 
		SUM(IF ((tipetrans=9 OR tipetrans=7),IF (DEBET IS NULL,0,IF(DEBET=0,0,DEBET * -1)),0)) AS rt_out, 
		SUM(IF ((tipetrans=9 OR tipetrans=7),IF(DEBET=0,0,(DEBET * -1)) * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS rt_out_nilai, 
		SUM(IF (tipetrans=2,IF (KREDIT IS NULL,0,KREDIT),0)) AS milik_out, 
		SUM(IF (tipetrans=2,KREDIT * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS milik_out_nilai, 
		SUM(IF (tipetrans=10,IF (KREDIT IS NULL,0,KREDIT),0)) AS hapus, 
		SUM(IF (tipetrans=10,KREDIT * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS hapus_nilai, 
		SUM(IF (tipetrans=4,IF (KREDIT IS NULL,0,KREDIT),0)) AS prod_out, 
		SUM(IF (tipetrans=4,KREDIT * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS prod_out_nilai, 
		SUM(IF (tipetrans=5,IF (DEBET-KREDIT IS NULL,0,DEBET-KREDIT),0)) AS adj, 
		SUM(IF (tipetrans=5,IF (fkid=0,(DEBET-KREDIT) * ah.HARGA_BELI_SATUAN,(DEBET-KREDIT) * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1)),0)) AS adj_nilai 
		FROM (SELECT * FROM a_kartustok WHERE UNIT_ID=$cunit AND TGL_ACT BETWEEN '$ta-$tbulan-01 00:00:00' AND '$ta-$tbulan-31 23:59:59' ORDER BY ".$corder."ID DESC) AS tmp
		LEFT JOIN a_penerimaan ap ON tmp.fkid=ap.ID LEFT JOIN (SELECT OBAT_ID,KEPEMILIKAN_ID,MAX(HARGA_BELI_SATUAN) AS HARGA_BELI_SATUAN FROM a_harga GROUP BY OBAT_ID,KEPEMILIKAN_ID) ah ON (tmp.OBAT_ID=ah.OBAT_ID AND tmp.KEPEMILIKAN_ID=ah.KEPEMILIKAN_ID)
		GROUP BY tmp.OBAT_ID,tmp.KEPEMILIKAN_ID) AS t1 ON (t2.OBAT_ID=t1.OBAT_ID AND t2.KEPEMILIKAN_ID=t1.KEPEMILIKAN_ID)";
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$sql="INSERT INTO a_rpt_mutasi SELECT t1.OBAT_ID,t1.KEPEMILIKAN_ID,$cunit,$bulan[0],$ta,0,0,t1.pbf,t1.pbf_nilai,t1.unit_in,t1.unit_in_nilai,t1.milik_in,t1.milik_in_nilai,
		t1.rt_in,t1.rt_in_nilai,t1.prod_in,t1.prod_in_nilai,t1.rsp,t1.rsp_nilai,t1.UNIT_OUT,t1.UNIT_OUT_NILAI,
		t1.rt_out,t1.rt_out_nilai,t1.milik_out,t1.milik_out_nilai,t1.hapus,t1.hapus_nilai,t1.prod_out,t1.prod_out_nilai,
		t1.adj,t1.adj_nilai,t1.QTY_AKHIR,t1.NILAI_AKHIR 
		FROM (SELECT tmp.OBAT_ID,tmp.KEPEMILIKAN_ID,STOK_AFTER AS QTY_AKHIR,NILAI_TOTAL AS NILAI_AKHIR,
		SUM(IF (tipetrans=0,IF (DEBET IS NULL,0,DEBET),0)) AS pbf, 
		SUM(IF (tipetrans=0,DEBET * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS pbf_nilai,
		SUM(IF (tipetrans=1,IF (DEBET IS NULL,0,DEBET),0)) AS unit_in,
		SUM(IF (tipetrans=1,DEBET * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS unit_in_nilai, 
		SUM(IF (tipetrans=2,IF (DEBET IS NULL,0,DEBET),0)) AS milik_in, 
		SUM(IF (tipetrans=2,DEBET * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS milik_in_nilai, 
		SUM(IF ((tipetrans=6 OR tipetrans=7),IF (KREDIT IS NULL,0,IF(KREDIT=0,0,KREDIT * -1)),0)) AS rt_in, 
		SUM(IF ((tipetrans=6 OR tipetrans=7),IF(KREDIT=0,0,(KREDIT * -1)) * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS rt_in_nilai, 
		SUM(IF (tipetrans=4,IF (DEBET IS NULL,0,DEBET),0)) AS prod_in, 
		SUM(IF (tipetrans=4,DEBET * ah.HARGA_BELI_SATUAN,0)) AS prod_in_nilai, 
		SUM(IF (tipetrans=8,IF (KREDIT IS NULL,0,KREDIT),0)) AS rsp, 
		SUM(IF (tipetrans=8,KREDIT * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS rsp_nilai, 
		SUM(IF (tipetrans=1,IF (KREDIT IS NULL,0,KREDIT),0)) AS unit_out, 
		SUM(IF (tipetrans=1,KREDIT * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS unit_out_nilai, 
		SUM(IF ((tipetrans=9 OR tipetrans=7),IF (DEBET IS NULL,0,IF(DEBET=0,0,DEBET * -1)),0)) AS rt_out, 
		SUM(IF ((tipetrans=9 OR tipetrans=7),IF(DEBET=0,0,(DEBET * -1)) * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS rt_out_nilai, 
		SUM(IF (tipetrans=2,IF (KREDIT IS NULL,0,KREDIT),0)) AS milik_out, 
		SUM(IF (tipetrans=2,KREDIT * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS milik_out_nilai, 
		SUM(IF (tipetrans=10,IF (KREDIT IS NULL,0,KREDIT),0)) AS hapus, 
		SUM(IF (tipetrans=10,KREDIT * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS hapus_nilai, 
		SUM(IF (tipetrans=4,IF (KREDIT IS NULL,0,KREDIT),0)) AS prod_out, 
		SUM(IF (tipetrans=4,KREDIT * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1),0)) AS prod_out_nilai, 
		SUM(IF (tipetrans=5,IF (DEBET-KREDIT IS NULL,0,DEBET-KREDIT),0)) AS adj, 
		SUM(IF (tipetrans=5,IF (fkid=0,(DEBET-KREDIT) * ah.HARGA_BELI_SATUAN,(DEBET-KREDIT) * ((ap.HARGA_BELI_SATUAN * (1-(DISKON/100))) * 1.1)),0)) AS adj_nilai 
		FROM (SELECT * FROM a_kartustok WHERE UNIT_ID=$cunit AND TGL_ACT BETWEEN '$ta-$tbulan-01 00:00:00' AND '$ta-$tbulan-31 23:59:59' ORDER BY ".$corder."ID DESC) AS tmp
		LEFT JOIN a_penerimaan ap ON tmp.fkid=ap.ID LEFT JOIN (SELECT OBAT_ID,KEPEMILIKAN_ID,MAX(HARGA_BELI_SATUAN) AS HARGA_BELI_SATUAN FROM a_harga GROUP BY OBAT_ID,KEPEMILIKAN_ID) ah ON (tmp.OBAT_ID=ah.OBAT_ID AND tmp.KEPEMILIKAN_ID=ah.KEPEMILIKAN_ID)
		GROUP BY tmp.OBAT_ID,tmp.KEPEMILIKAN_ID) AS t1 LEFT JOIN 
		(SELECT OBAT_ID,KEPEMILIKAN_ID FROM a_rpt_mutasi WHERE BULAN=$bulan[0] AND TAHUN=$ta AND UNIT_ID=$cunit) AS t2 
		ON (t1.OBAT_ID=t2.OBAT_ID AND t1.KEPEMILIKAN_ID=t2.KEPEMILIKAN_ID) WHERE t2.OBAT_ID IS NULL";
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
	}
}

mysqli_close($konek);
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
	header("Content-type: application/xhtml+xml");
}else{
	header("Content-type: text/xml");
}
echo $p;
?>