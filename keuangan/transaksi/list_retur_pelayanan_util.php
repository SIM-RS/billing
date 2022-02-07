<?php 
include("../koneksi/konek.php");
include("../sesi.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="nama";
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
	$hps = "delete from $dbbilling.b_return where no_return='".$_REQUEST['no_return']."'";
	mysql_query($hps);
}

/*
$sql = "SELECT DISTINCT 
		  p.id,
		  p.no_rm,
		  p.nama,
		  p.alamat,
		  p.rt,
		  p.rw,
		  w.nama AS desa,
		  i.nama AS kec,
		  l.nama AS kab,
		  p.tgl_lahir,
		  p.sex,
		  k.tgl,
		  k.umur_thn,
		  n.nama AS unit,
		  k.id AS kunjungan_id,
		  k.verifikasi,
		  k.note_verifikasi,
		  r.tgl_return,
		  r.no_return 
		FROM
		  $dbbilling.b_ms_pasien p 
		  INNER JOIN $dbbilling.b_kunjungan k 
			ON k.pasien_id = p.id 
		  LEFT JOIN $dbbilling.b_ms_wilayah w 
			ON w.id = p.desa_id 
		  LEFT JOIN $dbbilling.b_ms_wilayah i 
			ON i.id = p.kec_id 
		  LEFT JOIN $dbbilling.b_ms_wilayah l 
			ON l.id = p.kab_id 
		  LEFT JOIN $dbbilling.b_ms_unit n 
			ON n.id = k.unit_id 
		  INNER JOIN $dbbilling.b_bayar b 
			ON b.kunjungan_id = k.id 
		  INNER JOIN $dbbilling.b_bayar_tindakan bt 
			ON bt.bayar_id = b.id 
		  INNER JOIN $dbbilling.b_return r 
			ON r.bayar_tindakan_id = bt.id WHERE MONTH(r.tgl_return) = '".$_REQUEST['bln']."' 
  AND YEAR(r.tgl_return) = '".$_REQUEST['thn']."'";
*/  
  
$sql = "SELECT 
		  p.id,
		  p.no_rm,
		  p.nama,
		  p.alamat,
		  p.rt,
		  p.rw,
		  w.nama AS desa,
		  i.nama AS kec,
		  l.nama AS kab,
		  p.tgl_lahir,
		  p.sex,
		  k.tgl,
		  k.umur_thn,
		  n.nama AS unit,
		  k.id AS kunjungan_id,
		  k.verifikasi,
		  k.note_verifikasi,
		  r.tgl_return,
		  r.no_return
		FROM
		  $dbbilling.b_return r 
		  INNER JOIN $dbbilling.b_bayar_tindakan bt 
			ON bt.id = r.bayar_tindakan_id 
		  INNER JOIN $dbbilling.b_tindakan t 
			ON t.id = bt.tindakan_id 
		  INNER JOIN $dbbilling.b_pelayanan pl 
			ON pl.id = t.pelayanan_id 
		  INNER JOIN $dbbilling.b_ms_pasien p 
			ON pl.pasien_id = p.id 
		  LEFT JOIN $dbbilling.b_ms_wilayah w 
			ON w.id = p.desa_id 
		  LEFT JOIN $dbbilling.b_ms_wilayah i 
			ON i.id = p.kec_id 
		  LEFT JOIN $dbbilling.b_ms_wilayah l 
			ON l.id = p.kab_id 
		  INNER JOIN $dbbilling.b_kunjungan k 
			ON k.id = pl.kunjungan_id 
		  INNER JOIN $dbbilling.b_ms_unit n 
			ON n.id = k.unit_id 
		WHERE r.flag = '$flag' AND MONTH(r.tgl_return) = '".$_REQUEST['bln']."' 
		  AND YEAR(r.tgl_return) = '".$_REQUEST['thn']."' $filter 
		GROUP BY r.no_return";  

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
		$alamat = $rows['alamat']." RT.".$rows['rt']." RW.".$rows['rw']." Desa/Kel.".$rows['desa']." Kec.".$rows['kec']." Kab.".$rows['kab'];
		$id=$rows['id']."|".$rows['nama']."|".$alamat."|".tglSQL($rows['tgl_lahir'])."|".tglSQL($rows['tgl'])."|".$rows['umur_thn']."|".$rows['sex']."|".tglSQL($rows['tgl'])."|".$rows['kunjungan_id']."|"."0";
		$i++;
		$dt.=$id.chr(3).$i.chr(3).tglSQL($rows["tgl_return"]).chr(3).$rows["no_return"].chr(3).tglSQL($rows["tgl"]).chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).$alamat.chr(6);
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