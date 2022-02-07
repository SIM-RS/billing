<?php
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="nama";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$unitId=$_REQUEST['unitId'];
$kelompokID=$_REQUEST['tind_id'];
//===============================

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		$id=explode("|",$_REQUEST['fdata']);
		for($i=0;$i<(sizeof($id)-1);$i++){
			$sqlTambah="insert into b_ms_kelompok_tindakan_pemeriksaan_lab_tind(ms_kel_tind_lab_id,ms_tind_id)
				values($kelompokID,$id[$i])";
			$rs=mysql_query($sqlTambah);
		}
		break;
	case 'hapus':
		$id=explode("|",$_REQUEST['fdata']);
		for($i=0;$i<(sizeof($id)-1);$i++){
		   $sqlHapus="delete from b_ms_kelompok_tindakan_pemeriksaan_lab_tind where id='".$id[$i]."'";
		   //echo $sqlHapus."<br>";
		   $rs=mysql_query($sqlHapus);
		}
		break;
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}

switch($grd){
	case "1":
		$sql = "SELECT t.id, t.nama
				FROM b_ms_tindakan_unit tu
				INNER JOIN b_ms_tindakan_kelas mtk ON mtk.id = tu.ms_tindakan_kelas_id
				INNER JOIN b_ms_tindakan t ON t.id = mtk.ms_tindakan_id
				WHERE tu.ms_unit_id = 58 AND t.aktif = 1 
					AND t.id NOT IN (SELECT ms_tind_id FROM b_ms_kelompok_tindakan_pemeriksaan_lab_tind)
					{$filter}
				GROUP BY t.id
				ORDER BY ".$sorting;
				// WHERE ms_kel_tind_lab_id = {$kelompokID}
		break;
	case "2":
		$sql = "SELECT lt.id, t.nama
				FROM b_ms_kelompok_tindakan_pemeriksaan_lab_tind lt
				INNER JOIN b_ms_tindakan t ON t.id = lt.ms_tind_id
				WHERE lt.ms_kel_tind_lab_id = {$kelompokID}
				GROUP BY t.id
				ORDER BY ".$sorting;
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
		$dt.=$sisipan.chr(3)."0".chr(3).$rows["nama"].chr(6);
	}
	break;
   case "2":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
        $sisipan=$rows["id"];
		$dt.=$sisipan.chr(3)."0".chr(3).$rows["nama"].chr(6);
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