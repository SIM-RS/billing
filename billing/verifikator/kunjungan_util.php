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
//===============================

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}

$sql="SELECT
  ps.no_rm,
  ps.nama       nama_pasien,
  p.id          id_pelayanan,
  u.id          id_unit,
  (SELECT
     nama
   FROM b_ms_unit
   WHERE id = u.parent_id)    jenis_layanan,
  (SELECT
     nama
   FROM b_ms_unit
   WHERE id = p.unit_id)    tempat_layanan,
  (SELECT
     nama
   FROM b_ms_unit
   WHERE id = p.unit_id_asal)    tempat_layanan_asal,
  kso.id        id_kso,
  kso.nama      nama_kso,
  kl.id         id_kelas,
  kl.nama       nama_kelas,
  p.tgl,
  IF(p.dilayani=0,'Belum','Sudah')    dilayani
FROM b_pelayanan p
  INNER JOIN b_ms_pasien ps
    ON ps.id = p.pasien_id
  INNER JOIN b_ms_unit u
    ON u.id = p.unit_id
  INNER JOIN b_ms_kso kso
    ON kso.id = p.kso_id
  INNER JOIN b_ms_kelas kl
    ON kl.id = p.kelas_id
WHERE ps.no_rm = '1141081'";

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
		$proses = "<img src='../icon/edit.gif' width='20' style='cursor:pointer' />&nbsp;&nbsp;&nbsp;<img src='../icon/erase.png' width='20' style='cursor:pointer' />";
		//$edit = $rows['id_pelayanan'];
		$id=$rows['id_pelayanan'];
		$i++;
		$dt.=$id.chr(3).$i.chr(3).$rows["jenis_layanan"].chr(3).$rows["tempat_layanan"].chr(3).$rows["tempat_layanan_asal"].chr(3).$rows["nama_kso"].chr(3).$rows["nama_kelas"].chr(3).tglSQL($rows["tgl"]).chr(3).tglSQL($rows["tgl"]).chr(3).$rows["dilayani"].chr(3).$proses.chr(6);
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