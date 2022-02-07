<?php
include '../../koneksi/konek.php';

$page=$_REQUEST["page"];
$defaultsort="transfusi_id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}
if ($sorting==""){
	$sorting=$defaultsort;
}

$sql = "SELECT * FROM b_persetujuan_transfusi";

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
	$sisip = "<img src='../../icon/edit.gif' width='16' height='16' alt='Klik Untuk Mengedit Data' onclick=editData(".$rows['transfusi_id'].") />
				&nbsp;&nbsp;
			  <img src='../../icon/del16.gif' width='16' height='16' alt='Klik Untuk Menghapus Data' onclick=deleteData(".$rows['transfusi_id'].") />
				&nbsp;&nbsp;
			  <img src='../../icon/printer.png' width='16' height='16' alt='Klik Untuk Mencetak Data' onclick=cetakData(".$rows['transfusi_id'].") />";
	if($rows["transfusi_status"] == 1){ $stt = "Setuju"; }
	else{ $stt = "Tidak Setuju"; }
	$i++;
	$dt .= $rows['transfusi_id'].chr(3).number_format($i,0,",","").chr(3).
		   $rows["saksi_satu"].chr(3).$rows["saksi_dua"].chr(3).$stt.chr(3).$sisip.chr(6);
}
if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1);
	$dt=str_replace('"','\"',$dt);
}
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
	header("Content-type: application/xhtml+xml");
}else {
	header("Content-type: text/xml");
}
echo $dt;
?>