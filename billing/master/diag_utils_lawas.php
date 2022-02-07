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

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		mysql_query("select * from b_ms_diagnosa where kode='".$_REQUEST['kode']."'");
		if(mysql_affected_rows()==0){			
			$sqlTambah="insert into b_ms_diagnosa (kode,nama,level,parent_id,parent_kode,surveilance,aktif,dg_kode,kdg_id)
				values('".$_REQUEST['kode']."','".$_REQUEST['nama']."','".$_REQUEST['level']."','".$_REQUEST['parentId']."','".$_REQUEST['parentKode']."','".$_REQUEST['sur']."','".$_REQUEST['aktif']."','".$_REQUEST['kdgol']."','".$_REQUEST['emergency']."')";
			$rs=mysql_query($sqlTambah);
		}
		break;
	case 'hapus':
		$sqlHapus="delete from b_ms_diagnosa where id='".$_REQUEST['rowid']."'";
		mysql_query($sqlHapus);
		break;
	case 'simpan':
		$sqlSimpan="update b_ms_diagnosa set kode='".$_REQUEST['kode']."',nama='".$_REQUEST['nama']."',level='".$_REQUEST['level']."',dg_kode='".$_REQUEST['txtGol']."',
		parent_id='".$_REQUEST['parentId']."',parent_kode='".$_REQUEST['parentKode']."',surveilance='".$_REQUEST['sur']."',aktif='".$_REQUEST['aktif']."',dg_kode='".$_REQUEST['kdgol']."',kdg_id='".$_REQUEST['emergency']."' where id='".$_REQUEST['id']."'";		
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
	$sql="SELECT 
	  id,
	  kode,
	  nama,
	  LEVEL,
	  parent_id,
	  parent_kode,
	  islast,
	  IF(surveilance = 1, 'Ya', 'Tidak') AS surveilance,
	  IF(aktif = 1, 'Aktif', 'Tidak') AS aktif,
	  dg_kode,md.kdg_id,mdg.kdg_nama,
	  (SELECT 
		DG_NAMA 
	  FROM
		b_ms_diagnosa_gol 
	  WHERE DG_KODE = md.dg_kode) AS gol 
	FROM
	  b_ms_diagnosa md left join b_ms_diagnosa_gambar mdg on md.kdg_id=mdg.kdg_id ".$filter." order by ".$sorting;
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
		$dt.=$rows["id"]."|".$rows["kdg_id"].chr(3).number_format($i,0,",","").chr(3).$rows["kode"].chr(3).$rows["nama"].chr(3).$rows["LEVEL"].chr(3).$rows["parent_id"].chr(3).$rows["parent_kode"].chr(3).$rows["surveilance"].chr(3).$rows["islast"].chr(3).$rows["aktif"].chr(3).$rows["gol"].chr(3).$rows["kdg_nama"].chr(6);
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