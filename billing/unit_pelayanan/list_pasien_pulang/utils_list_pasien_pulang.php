<?php
include '../koneksi/konek.php';

$page=$_REQUEST["page"];
$defaultsort="list_pulang_id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}
if ($sorting==""){
	$sorting=$defaultsort;
}

$sql = "SELECT * FROM b_list_pasien_pulang";

$rs=mysql_query($sql);
$jmldata=mysql_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
$sql=$sql." limit $tpage,$perpage";

$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);

while ($rows=mysql_fetch_array($rs)){
	$sisip = "<img src='../icon/edit.gif' alt='' onclick=editData(".$rows['list_pulang_id'].") />";
	$i++;
	$dt.=$rows['list_pulang_id'].chr(3).number_format($i,0,",","").chr(3).$rows["administrasi"].chr(3).$rows["fasilitas"].chr(3).$sisip.chr(6);
}
if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
	$dt=str_replace('"','\"',$dt);
}
echo $dt;
?>