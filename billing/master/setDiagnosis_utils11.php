<?php 
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="kode";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

switch(strtolower($grd)){
	case '2':
		switch(strtolower($_REQUEST['act'])){
			case 'tambah':		
				$sqlTambah="insert into b_ms_diagnosa_unit (ms_unit_id,ms_diagnosa_id) values('".$_REQUEST['unitId']."','".$_REQUEST['diagId']."')";
				$rs=mysql_query($sqlTambah);
				if($rs>0) echo "<script>alert('Data Telah Berhasil Tersimpan..');</script>";
				break;
			case 'hapus':
				$sqlHapus="delete from b_ms_diagnosa_unit where id='".$_REQUEST['id']."'";
				mysql_query($sqlHapus);
				break;
			case 'simpan':
				$sqlSimpan = "UPDATE b_ms_diagnosa_unit SET ms_unit_id='".$_REQUEST['unitId']."',ms_diagnosa_id='".$_REQUEST['diagId']."' WHERE id='".$_REQUEST['id']."'";	
				$rs=mysql_query($sqlSimpan);
				break;
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
	$sql = "SELECT id, kode, nama FROM b_ms_diagnosa ".$filter." order by ".$sorting;
	break;
	case "2":
	$sql = "select * from (SELECT d.id, d.kode, d.nama, du.ms_unit_id, u.nama AS namaunit
			FROM b_ms_diagnosa d
			INNER JOIN b_ms_diagnosa_unit du ON du.ms_diagnosa_id = d.id
			INNER JOIN b_ms_unit u ON u.id = du.ms_unit_id
			WHERE du.ms_unit_id = '".$_REQUEST['unitId']."') as t1 ".$filter." ORDER BY ".$sorting;
	break;
}


//echo $sql."<br>";
$rs=mysql_query($sql);
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
		$dt.=$rows["id"].chr(3).$rows["kode"].chr(3).$rows["nama"].chr(6);
	}
	break;
	case "2":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).$rows["kode"].chr(3).$rows["nama"].chr(6);
	}
	break;
}

if ($dt!=$totpage.chr(5))
{
	$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
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