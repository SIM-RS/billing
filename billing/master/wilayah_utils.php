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

$kodebr = $_REQUEST['parentKode'] . $_REQUEST['kode'];

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		mysql_query("select * from b_ms_wilayah where kode='".$_REQUEST['kode']."'");
		if(mysql_affected_rows()==0){			
			$sqlTambah="insert into b_ms_wilayah (kode,nama,level,parent_id,parent_kode,aktif,flag)
				values('".$kodebr."','".$_REQUEST['nama']."','".$_REQUEST['level']."','".$_REQUEST['parentId']."','".$_REQUEST['parentKode']."','".$_REQUEST['aktif']."','".$_REQUEST['flag']."')";
			$rs=mysql_query($sqlTambah);
		}
		break;
	case 'hapus':
		$sqlHapus="delete from b_ms_wilayah where id='".$_REQUEST['rowid']."'";
		mysql_query($sqlHapus);
		break;
	case 'simpan':
		$sqlSimpan="update b_ms_wilayah set kode='".$_REQUEST['kode']."',nama='".$_REQUEST['nama']."',level='".$_REQUEST['level']."',
		parent_id='".$_REQUEST['parentId']."',parent_kode='".$_REQUEST['parentKode']."',aktif='".$_REQUEST['aktif']."',flag='".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";		
		$rs=mysql_query($sqlSimpan);
		break;
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}

if($grd == "true")
{
	$sql="SELECT id,kode,nama,level,parent_id,parent_kode,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_wilayah ".$filter." order by ".$sorting;
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

if($grd == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["kode"].chr(3).$rows["nama"].chr(3).$rows["level"].chr(3).$rows["parent_id"].chr(3).$rows["parent_kode"].chr(3).$rows["aktif"].chr(6);
	}
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