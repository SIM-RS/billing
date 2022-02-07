<?php 
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="nama";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$id=$_GET['id'];
$idPasien=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$jnsRwt=$_REQUEST['jnsRwt'];
//===============================

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}

$tanggal = tglSQL($_REQUEST['tanggal']);

$sql = "SELECT
		  b.*,
		  DATE_FORMAT(b.tgl,'%d-%m-%Y') AS tgl_bayar,
		  DATE_FORMAT(b.disetor_tgl,'%d-%m-%Y') AS tgl_disetor,
		  DATE_FORMAT(rp.tgl_return,'%d-%m-%Y') AS tgl_return,
		  rp.id AS idretur,
		  rp.no_return,
		  rp.nilai_retur,
		  msu.nama petugasReturn,
		  mp.nama AS namaKasir
		FROM $dbbilling.b_bayar b
		  INNER JOIN $dbbilling.b_ms_pegawai mp
			ON b.user_act = mp.id
		  INNER JOIN $dbbilling.b_return_pembayaran rp
			ON b.id = rp.bayar_id
		  INNER JOIN k_ms_user msu
			ON msu.id = rp.user_act
		WHERE b.kunjungan_id = '$idKunj'";

//echo $sql."<br>";
$perpage=100;
$rs=mysql_query($sql);
$jmldata=mysql_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
//$sql=$sql." limit $tpage,$perpage";
//$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);

while ($rows=mysql_fetch_array($rs)){
		/*$sdhBayar=0;
		if ($rows["bayar_pasien"]>0) $sdhBayar=1;
		$id=$rows['ms_kelas_id']."|".$rows['unit_id']."|".$rows['parent_id']."|".$rows['pelayanan_id']."|".$rows['id']."|".$rows['ms_tindakan_kelas_id']."|".$rows['bayar_tindakan_id'];*/
		$i++;
		$id=$rows['idretur'];
		$chk = "<input type='checkbox' id='chkr_$rows[id]' />";
		$tcetak="<img src='../icon/printer.png' width='20' align='absmiddle' title='Klik Untuk Cetak Kuitansi Retur' onClick='cetakReturnById($id)'>";
		$dt.=$id.chr(3).$chk.chr(3).$rows["no_return"].chr(3).$rows["tgl_bayar"].chr(3).$rows["tgl_return"].chr(3).$rows["namaKasir"].chr(3).$rows["petugasReturn"].chr(3).number_format($rows["nilai_retur"],0,",",".").chr(3).$tcetak.chr(6);
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