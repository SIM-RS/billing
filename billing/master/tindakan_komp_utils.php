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
		mysql_query("select * from b_ms_tindakan_komponen where ms_tindakan_kelas_id='".$_REQUEST['tind']."'");
		if(mysql_affected_rows()==0){			
			echo $sqlTambah="insert into b_ms_tindakan_komponen (ms_tindakan_kelas_id,ms_komponen_id,tarip)
				values('".$_REQUEST['tind']."','".$_REQUEST['komp']."','".$_REQUEST['tarif']."')";
			$rs=mysql_query($sqlTambah);
		}
		break;
	case 'hapus':
		$sqlHapus="delete from b_ms_tindakan_komponen where id='".$_REQUEST['rowid']."'";
		mysql_query($sqlHapus);
		break;
	case 'simpan':
		$sqlSimpan="update b_ms_tindakan_komponen set ms_tindakan_kelas_id='".$_REQUEST['tind']."',ms_komponen_id='".$_REQUEST['komp']."',tarip='".$_REQUEST['tarif']."' where id='".$_REQUEST['id']."'";		
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
	$sql="SELECT tkp.id, tkp.ms_komponen_id, tkp.ms_tindakan_kelas_id, tkp.tarip, k.nama AS komp, kls.nama AS kls
FROM b_ms_tindakan_komponen tkp
INNER JOIN b_ms_komponen k ON k.id=tkp.ms_komponen_id
INNER JOIN b_ms_tindakan_kelas tk ON tk.id=tkp.ms_tindakan_kelas_id
INNER JOIN b_ms_kelas kls ON kls.id=tk.ms_kelas_id ".$filter."";
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
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["kls"].chr(3).$rows["komp"].chr(3).$rows["tarip"].chr(6);
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