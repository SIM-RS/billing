<?php 
session_start();
$userId=$_SESSION['userId'];
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$dokter_id=$_REQUEST['dokter_id'];
$id=$_REQUEST['id'];
//===============================
switch(strtolower($_REQUEST['act'])){
	case 'cek':
		$sql="SELECT IFNULL(COUNT(*),0) AS jml FROM b_konsul WHERE dokter_id='".$dokter_id."'";
		$kueri=mysql_query($sql);
		$rw=mysql_fetch_array($kueri);
		$jml=$rw['jml'];
		echo $jml;
		return;
		break;
	case 'tambah':
		$sql1="UPDATE b_konsul SET status_dilayani=1 WHERE id='".$id."'";
		mysql_query($sql1);
		return;
		break;
	case 'hapus':
		$sql3="UPDATE b_konsul SET status_dilayani=0 WHERE id='".$id."'";
		mysql_query($sql3);
		return;
		break;
}
if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}

if($_REQUEST['dilayani']!='2'){
	$fDilayani = "AND k.status_dilayani='".$_REQUEST['dilayani']."'";	
}

/*
$sql="SELECT
k.id,
k.pelayanan_id,
p.kunjungan_id,
p.pasien_id,
DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,
u.nama AS unit,
ps.no_rm,
ps.nama,
k.ket,
k.status_dilayani
FROM b_konsul k
INNER JOIN b_pelayanan p ON p.id=k.pelayanan_id
INNER JOIN b_ms_pasien ps ON ps.id=p.pasien_id
INNER JOIN b_ms_unit u ON u.id=p.unit_id
INNER JOIN b_ms_pegawai pg ON pg.id=k.dokter_id
WHERE k.dokter_id='".$dokter_id."' $fDilayani";
*/

$sql="SELECT * FROM (SELECT
k.id,
k.pelayanan_id,
p.kunjungan_id,
p.pasien_id,
DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,
u.nama AS unit,
ps.no_rm,
ps.nama,
k.ket,
k.status_dilayani
FROM b_konsul k
INNER JOIN b_pelayanan p ON p.id=k.pelayanan_id
INNER JOIN b_kunjungan kun ON kun.id=p.kunjungan_id
INNER JOIN b_ms_pasien ps ON ps.id=p.pasien_id
INNER JOIN b_ms_unit u ON u.id=p.unit_id
INNER JOIN b_ms_pegawai pg ON pg.id=k.dokter_id
WHERE k.dokter_id='".$dokter_id."' AND p.tgl = DATE(NOW()) $fDilayani
UNION
SELECT
k.id,
k.pelayanan_id,
p.kunjungan_id,
p.pasien_id,
DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,
u.nama AS unit,
ps.no_rm,
ps.nama,
k.ket,
k.status_dilayani
FROM b_konsul k
INNER JOIN b_pelayanan p ON p.id=k.pelayanan_id
INNER JOIN b_kunjungan kun ON kun.id=p.kunjungan_id
INNER JOIN b_ms_pasien ps ON ps.id=p.pasien_id
INNER JOIN b_ms_unit u ON u.id=p.unit_id
INNER JOIN b_ms_pegawai pg ON pg.id=k.dokter_id
INNER JOIN b_tindakan_kamar tk ON tk.pelayanan_id = p.id
WHERE k.dokter_id='".$dokter_id."' AND kun.pulang=0 AND tk.tgl_out IS NULL $fDilayani) AS gab ".$filter." ORDER BY ".$sorting;

//echo $sql."<br>";
$perpage=100;
$rs=mysql_query($sql);
$jmldata=mysql_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
$sql=$sql." limit $tpage,$perpage";
$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);


while ($rows=mysql_fetch_array($rs)){
	$id=$rows['id']."|".$rows['pelayanan_id']."|".$rows['kunjungan_id']."|".$rows['pasien_id'];
	$i++;
	$detil="<img src='../icon/lihat.gif' width='24' height='24' title='Klik untuk melihat detil' style='cursor:pointer;' onclick='detilKonsulDokter($i);' />";
	$dt.=$id.chr(3).$i.chr(3).$rows["tgl"].chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).$rows["unit"].chr(3).$rows["ket"].chr(3).$detil.chr(3).$rows["status_dilayani"].chr(6);
}

if ($dt!=$totpage.chr(5)) {
	$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act'])."*|*".$_REQUEST["smpn"]."*|*".$_REQUEST["hps"];
	$dt=str_replace('"','\"',$dt);
}
else{
	$dt="0".chr(5).chr(5).strtolower($_REQUEST['act'])."*|*".$_REQUEST["smpn"]."*|*".$_REQUEST["hps"];	
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