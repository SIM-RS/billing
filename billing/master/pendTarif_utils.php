<?php 
include("../koneksi/konek.php");
$grd=$_REQUEST["grd"];
$grd1=$_REQUEST["grd1"];
$grd2=$_REQUEST["grd2"];
$grd3=$_REQUEST["grd3"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

switch(strtolower($_REQUEST['act']))
{
	
	case 'tambah':
		switch($_REQUEST["smpn"])
		{
			case 'btnSimpan':
				mysql_query("select * from b_ms_kelas where kode='".$_REQUEST['kode']."'");
				if(mysql_affected_rows()==0)
				{	
					$sqlTambah="insert into b_ms_kelas (kode,nama,aktif,flag) values('".$_REQUEST['kode']."','".$_REQUEST['kls']."','".$_REQUEST['aktif']."','".$_REQUEST['flag']."')";
				}
				break;
			
			case 'btnSimpanTrf':
				$sqlTambah="insert into b_ms_komponen (kode,nama,tarip_default,aktif,flag) values('".$_REQUEST['kode']."','".$_REQUEST['nama']."','".$_REQUEST['tarif']."','".$_REQUEST['aktif']."','".$_REQUEST['flag']."')";
				break;
		}
		$rs=mysql_query($sqlTambah);
		break;
	
	case 'simpan':
		switch($_REQUEST["smpn"])
		{
			case 'btnSimpan':
				$sqlUpdate="update b_ms_kelas set kode='".$_REQUEST['kode']."',nama='".$_REQUEST['kls']."',aktif='".$_REQUEST['aktif']."',,'".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";
				break;
			
			case 'btnSimpanTrf':
				$sqlUpdate="update b_ms_komponen set kode='".$_REQUEST['kode']."',nama='".$_REQUEST['nama']."',tarip_default='".$_REQUEST['tarif']."',aktif='".$_REQUEST['aktif']."','".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";
				break;
		}
		$rs=mysql_query($sqlUpdate);
		break;
		
	case 'hapus':
		switch($_REQUEST["hps"])
		{
			case 'btnHapus':
				$sqlHapus="delete from b_ms_kelas where id='".$_REQUEST['rowid']."'";
				break;
			
			case 'btnHapusTrf':
				$sqlHapus="delete from b_ms_komponen where id='".$_REQUEST['rowid']."'";
				break;
		}
		mysql_query($sqlHapus);
		break;
		
	case 'btnSimpanTrf':
		echo $sqlTambah = "INSERT INTO b_ms_komponen (kode,nama,tarif_default,aktif,flag) values ('".$_REQUEST['kode']."','".$_REQUEST['nama']."','".$_REQUEST['tarif']."','".$_REQUEST['aktif']."','".$_REQUEST['flag']."')";
		$rs = mysql_query($sqlTambah);
		break;
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if($sorting==''){
	if($grd=="true" || $grd1=="true"){		
		$defaultsort="kode";
	}
	else{
		$defaultsort="nama";
	}
	$sorting=$defaultsort;
}
//echo $grd.'123';

if($grd == "true")
{
	$sql = "SELECT id,kode,nama,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_kelas ".$filter." order by ".$sorting;	
}
elseif($grd1 == "true")
{
	$sql = "SELECT id,kode,nama,tarip_default,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_komponen ".$filter." order by ".$sorting;
}
elseif($grd2 == "true")
{
	$sql = "SELECT id,nama FROM b_ms_komponen ".$filter." order by ".$sorting;
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
		$dt.=$rows["id"].chr(3).$rows["kode"].chr(3).$rows["nama"].chr(3).$rows["aktif"].chr(6);
	}
}
elseif($grd1 == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).$rows["kode"].chr(3).$rows["nama"].chr(3).$rows["tarip_default"].chr(3).$rows["aktif"].chr(6);
	}
	
}
elseif($grd2 == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).$rows["nama"].chr(6);
	}
	
}


if ($dt!=$totpage.chr(5))
{
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