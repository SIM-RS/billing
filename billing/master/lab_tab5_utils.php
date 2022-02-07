<?php
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="kode_urut";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$unitId=$_REQUEST['unitId'];
$tind_id=$_REQUEST['tind_id'];
//===============================

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		$id=explode("|",$_REQUEST['fdata']);
		for($i=0;$i<(sizeof($id)-1);$i++){
			$sqlTambah="insert into b_ms_tindakan_pemeriksaan_lab(ms_tindakan_id,ms_pemeriksaan_id)
				values($tind_id,$id[$i])";
			$rs=mysql_query($sqlTambah);
		}
		break;
	case 'hapus':
		$id=explode("|",$_REQUEST['fdata']);
		for($i=0;$i<(sizeof($id)-1);$i++){
		   $sqlHapus="delete from b_ms_tindakan_pemeriksaan_lab where id='".$id[$i]."'";
		   //echo $sqlHapus."<br>";
		   $rs=mysql_query($sqlHapus);
		}
		break;
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" where ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}

switch($grd){
	case "1":
	/*$sql="SELECT id,kode_urut,pemeriksaan,IF (gab.level=0,gab.anak,gab.parent) kelompok,sub_kelompok
FROM (SELECT mpl.id,mpl.kode_urut,mpl.nama pemeriksaan,(SELECT nama_kelompok FROM b_ms_kelompok_lab WHERE id=mkl.parent_id) parent,
IF (mkl.level=1,mkl.nama_kelompok,'-') sub_kelompok,mkl.nama_kelompok anak,mkl.level 
FROM (SELECT * FROM b_ms_pemeriksaan_lab WHERE id NOT IN 
(SELECT ms_pemeriksaan_id FROM b_ms_tindakan_pemeriksaan_lab WHERE ms_tindakan_id='$tind_id')) mpl 
INNER JOIN b_ms_kelompok_lab mkl ON mpl.kelompok_lab_id=mkl.id WHERE mpl.aktif=1) gab".$filter." ORDER BY ".$sorting;*/
	$sql="SELECT id,kode_urut,pemeriksaan,IF (gab.level=0,gab.anak,gab.parent) kelompok,sub_kelompok
FROM (SELECT mpl.id,mpl.kode_urut,mpl.nama pemeriksaan,(SELECT nama_kelompok FROM b_ms_kelompok_lab WHERE id=mkl.parent_id) parent,
IF (mkl.level=1,mkl.nama_kelompok,'-') sub_kelompok,mkl.nama_kelompok anak,mkl.level 
FROM (SELECT * FROM (SELECT DISTINCT mpl1.* FROM b_ms_pemeriksaan_lab mpl1 
INNER JOIN b_ms_normal_lab mnl ON mpl1.id=mnl.id_pemeriksaan_lab 
WHERE mnl.aktif=1 AND mpl1.aktif=1) AS mpl2 WHERE mpl2.id NOT IN 
(SELECT ms_pemeriksaan_id FROM b_ms_tindakan_pemeriksaan_lab WHERE ms_tindakan_id='$tind_id')) mpl 
INNER JOIN b_ms_kelompok_lab mkl ON mpl.kelompok_lab_id=mkl.id) gab".$filter." ORDER BY ".$sorting;
	break;
   case "2":
	$sql="SELECT id,kode_urut,pemeriksaan,IF (gab.level=0,gab.anak,gab.parent) kelompok,sub_kelompok
FROM (SELECT mtpl.id,mpl.kode_urut,mpl.nama pemeriksaan,(SELECT nama_kelompok FROM b_ms_kelompok_lab WHERE id=mkl.parent_id) parent,
IF (mkl.level=1,mkl.nama_kelompok,'-') sub_kelompok,mkl.nama_kelompok anak,mkl.level 
FROM b_ms_tindakan_pemeriksaan_lab mtpl INNER JOIN b_ms_pemeriksaan_lab mpl ON mtpl.ms_pemeriksaan_id=mpl.id 
INNER JOIN b_ms_kelompok_lab mkl ON mpl.kelompok_lab_id=mkl.id
WHERE ms_tindakan_id='$tind_id') gab".$filter." order by ".$sorting;
	break;
}

//echo $sql."<br>";
$rs=mysql_query($sql);
//echo mysql_error();
$jmldata=mysql_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
$sql=$sql." limit $tpage,$perpage";
//echo $sql;

$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);

switch($grd){
	case "1":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
        $sisipan=$rows["id"];
		$dt.=$sisipan.chr(3)."0".chr(3).$rows["pemeriksaan"].chr(3).$rows["kelompok"].chr(3).$rows["sub_kelompok"].chr(6);
	}
	break;
   case "2":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
        $sisipan=$rows["id"];
		$dt.=$sisipan.chr(3)."0".chr(3).$rows["pemeriksaan"].chr(3).$rows["kelompok"].chr(3).$rows["sub_kelompok"].chr(6);
	}
	break;
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