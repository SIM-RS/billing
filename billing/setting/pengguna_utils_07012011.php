<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

$grdtab2 = $_REQUEST["grdtab2"];
//$grd1 = $_REQUEST["grd1"];

$kodebr = $_REQUEST['kode'] + 1;
$kodebr = sprintf("%03d",$kodebr);
$kodebr = "GP0".$kodebr ;

switch(strtolower($_REQUEST['act']))
{
	case 'tambah':
		switch($_REQUEST["smpn"])
		{
			case 'btnSimpanGroup':
				$sqlTambah="insert into b_ms_group (kode,nama,ket,aktif) values('".$kodebr."','".$_REQUEST['nama']."','".$_REQUEST['ket']."','".$_REQUEST['aktif']."')";
				break;
			
		}
		$rs=mysql_query($sqlTambah);
		break;
	
	case 'simpan':
		switch($_REQUEST["smpn"])
		{
			case 'btnSimpanGroup':
				$sqlUpdate="UPDATE b_ms_group SET nama = '".$_REQUEST['nama']."', ket = '".$_REQUEST['ket']."', aktif = '".$_REQUEST['aktif']."' WHERE id = '".$_REQUEST['id']."'";
				break;
			
		}
		$rs=mysql_query($sqlUpdate);
		break;
		
	case 'hapus':
		switch($_REQUEST["hps"])
		{
			case 'btnHapusGroup':
				$sqlHapus="delete from b_ms_group where id='".$_REQUEST['rowid']."'";
				break;
			
		}
		mysql_query($sqlHapus);
		break;
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
}
if ($sorting==""){
	$sorting="kode"; //default sort		
}

if($grdtab2 == "true")
{
	$sql="SELECT * FROM b_ms_group where aktif = 1".$filter." order by ".$sorting;
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

if($grdtab2 == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["kode"].chr(3).$rows["nama"].chr(3).$rows["ket"].chr(3).$rows["aktif"].chr(6);
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