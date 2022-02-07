<?php 
include("../koneksi/konek.php");
include("../sesi.php");
//====================================================================
$bln=$_REQUEST["bln"];
$thn=$_REQUEST["thn"];
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="r.id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}

if($_REQUEST['act']=='hapus'){
	$hps = "delete from $dbbilling.b_return_pembayaran where id='".$_REQUEST['id_return']."'";
	mysql_query($hps);
}
  
$sql = "SELECT
		  p.no_rm,
		  p.nama,
		  p.alamat,
		  p.rt,
		  p.rw,
		  DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl_kunj,
		  DATE_FORMAT(r.tgl_return,'%d-%m-%Y') AS tgl_return,
		  r.id,
		  r.bayar_id,
		  r.no_return,
		  r.nilai_retur,
		  DATE_FORMAT(b.tgl,'%d-%m-%Y') AS tgl_bayar,
		  b.no_kwitansi,
		  b.nilai
		FROM $dbbilling.b_return_pembayaran r
		  INNER JOIN $dbbilling.b_bayar b
			ON b.id = r.bayar_id
		  INNER JOIN $dbbilling.b_kunjungan k
			ON k.id = b.kunjungan_id
		  INNER JOIN $dbbilling.b_ms_pasien p
			ON p.id = k.pasien_id
		WHERE MONTH(r.tgl_return) = '$bln' AND r.flag = '$flag'
			AND YEAR(r.tgl_return) = '$thn' $filter ORDER BY $sorting";
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
		$i++;
		$alamat = $rows['alamat']." RT.".$rows['rt']." RW.".$rows['rw'];
		$id=$rows['id'];
		$bayar_id=$rows['bayar_id'];
		$tcetak="<img src='../icon/printer.png' width='20' align='absmiddle' title='Klik Untuk Cetak Kuitansi Retur' onClick='cetakReturnById($id)'>";
		$dt.=$id.chr(3).$i.chr(3).$rows["tgl_return"].chr(3).$rows["no_return"].chr(3).$rows["tgl_kunj"].chr(3).$rows["tgl_bayar"].chr(3).$rows["no_kwitansi"].chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).number_format($rows["nilai_retur"],0,",",".").chr(3).$tcetak.chr(6);
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