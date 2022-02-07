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
$kodeAnak = $_REQUEST['kodeInduk'].".".$_REQUEST['kode'];
$levelAnak = $_REQUEST['levelInduk'] + 1;
$kso = $_REQUEST['kso'];
		
switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		mysql_query("select * from b_ms_diagnosa where kode='".$kodeAnak."'");
		if(mysql_affected_rows()==0){			
			$sqlTambah="insert into b_ms_diagnosa (kode,nama,level,parent_id,parent_kode,surveilance,aktif)
				values('".$kodeAnak."','".$_REQUEST['nama']."','".$levelAnak."','".$_REQUEST['idInduk']."','".$_REQUEST['kodeInduk']."','".$_REQUEST['sur']."','".$_REQUEST['aktif']."')";
			$rs=mysql_query($sqlTambah);
		}
		break;
	case 'hapus':
		$sqlHapus="delete from b_ms_diagnosa where id='".$_REQUEST['rowid']."'";
		mysql_query($sqlHapus);
		break;
	case 'simpan':
		$sqlSimpan="update b_ms_diagnosa set kode='".$_REQUEST['kode']."',nama='".$_REQUEST['nama']."',level='".$levelAnak."',
		parent_id='".$_REQUEST['idInduk']."',parent_kode='".$_REQUEST['kodeInduk']."',surveilance='".$_REQUEST['sur']."',aktif='".$_REQUEST['aktif']."' where id='".$_REQUEST['idAnak']."'";		
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
	$sql="SELECT * FROM $dbbilling.b_ms_pasien
INNER JOIN $dbbilling.b_kunjungan ON $dbbilling.b_ms_pasien.id = $dbbilling.b_kunjungan.pasien_id
INNER JOIN $dbbilling.b_ms_kso ON $dbbilling.b_ms_kso.id = $dbbilling.b_kunjungan.kso_id
WHERE $dbbilling.b_ms_kso.id = '".$kso."' ";
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
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["kode"].chr(3).$rows["nama"].chr(3).$rows["level"].chr(3).$rows["parent_id"].chr(3).$rows["parent_kode"].chr(3).$rows["surveilance"].chr(3).$rows["islast"].chr(3).$rows["aktif"].chr(6);
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