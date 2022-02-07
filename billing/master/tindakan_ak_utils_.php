<?php
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="tindakan";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$pendapatan=$_REQUEST['pendapatan'];
$id=explode(",",$_REQUEST['id']);
//===============================
       
if($grd == 2)
	switch(strtolower($_REQUEST['act'])){
		case 'tambah':
			for($i=0;$i<(sizeof($id)-1);$i++){				
				$sqlTambah="UPDATE b_ms_tindakan SET ak_ms_unit_id = '{$pendapatan}' WHERE id = '". $id[$i] ."'";
				$rs=mysql_query($sqlTambah);
			}
			break;
		case 'hapus':
			for($i=0;$i<(sizeof($id)-1);$i++){
			   $sqlHapus="UPDATE b_ms_tindakan SET ak_ms_unit_id = 0 WHERE id = '". $id[$i] ."'";
			   mysql_query($sqlHapus);
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
		$sql = "SELECT * FROM (SELECT t.id, t.kode, t.nama tindakan, kt.nama kelompok, k.nama klasifikasi
				FROM b_ms_tindakan t
				INNER JOIN b_ms_kelompok_tindakan kt
				   ON kt.id = t.kel_tindakan_id
				INNER JOIN b_ms_klasifikasi k
				   ON k.id = t.klasifikasi_id
				WHERE t.ak_ms_unit_id = 0 OR t.ak_ms_unit_id IS NULL) AS t1
				{$filter}
				ORDER BY {$sorting}";

	break;
   case "2":
		$sql = "SELECT * FROM (SELECT t.id, t.kode, t.nama tindakan, kt.nama kelompok, k.nama klasifikasi, ak.nama pendapatan
				FROM b_ms_tindakan t
				INNER JOIN b_ms_kelompok_tindakan kt
				   ON kt.id = t.kel_tindakan_id
				INNER JOIN b_ms_klasifikasi k
				   ON k.id = t.klasifikasi_id
				INNER JOIN rspelindo_akuntansi.ak_ms_unit_new ak
				   ON ak.id = t.ak_ms_unit_id
				  AND ak.id = '{$pendapatan}'
				WHERE t.ak_ms_unit_id <> 0 OR t.ak_ms_unit_id IS NOT NULL) t1
				{$filter}
				ORDER BY {$sorting}";
	break;
}

//echo $sql."<br>";
$rs=mysql_query($sql);
echo mysql_error();
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
			$sisipan=$rows["id"]."|".$rows["tindakan"];
			$dt.=$sisipan.chr(3)."0".chr(3).$rows["tindakan"].chr(3).$rows["kelompok"].chr(3).$rows["klasifikasi"].chr(6);
		}
		break;
	case "2":
		while ($rows=mysql_fetch_array($rs))
		{
			$i++;
			$sisipan=$rows["id"]."|".$rows["tindakan"];
			$dt.=$sisipan.chr(3)."0".chr(3).$rows["tindakan"].chr(3).$rows["kelompok"].chr(3).$rows["klasifikasi"].chr(6);
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